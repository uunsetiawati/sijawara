<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\User;
use App\Models\UserTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helpers\RestApi;

class TopicController extends Controller {
  public function index(Request $request) {
    if (request()->wantsJson()) {

      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      DB::statement(DB::raw('set @angka=0+' . $page * $per));
      $topic = Topic::where(function ($q) use ($request) {
        $q->where('name', 'LIKE', '%' . $request->search . '%');
      })->where('slug', '!=', 'all')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

      $topic->map(function ($a) {
        $a->action = '
          <button class="btn btn-sm btn-icon btn-light-info mb-2 edit" title="Edit" data-id="' . $a->uuid . '"><i class="fa fa-pen"></i></button> 
          <button class="btn btn-sm btn-icon btn-light-danger mb-2 delete" title="Delete" data-id="' . $a->uuid . '"><i class="fa fa-trash"></i></button>
        ';
        return $a;
      });

      return response()->json($topic);
    } else {
      abort(404);
    }
  }

  public function create(Request $request) {
    if (request()->wantsJson() && request()->ajax()) {
      $validator = Validator::make($request->all(), [
        'name' => 'required|string|unique:topics',
        'users' => 'required|array',
        'users.*' => 'required|string',
      ]);

      if ($validator->fails()) {
        return response()->json([
          'status'    => false,
          'message'   => $validator->messages()->first()
        ], 400);
      }

      $topic = Topic::create([
        'name' => $request->name,
        'slug' => str_slug($request->name),
      ]);

      if ($topic) {    
        foreach ($request['users'] as $user) {
          $user = User::findByUuid($user);
          UserTopic::create([
            'user_id' => $user->id,
            'topic_id' => $topic->id,
          ]);
        }

        return response()->json([
          'status' => true,
          'data' => 'Berhasil menambah topic.'
        ]);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Gagal menambah topic.'
        ], 400);
      }
    } else {
      abort(404);
    }
  }

  public function show() {
    if (request()->wantsJson() && request()->ajax()) {
      $topic = Topic::get();

      return response()->json([
        'status'    => true,
        'data'      => $topic
      ], 200);
    } else {
      abort(404);
    }
  }

  public function edit($uuid) {
    if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {
      $topic = Topic::findByUuid($uuid);
      $topic->users;

      if (!isset($topic->id)) {
        return RestApi::error('Topic tidak ditemukan.', 404);
      }
      
      return response()->json([
        'status' => true,
        'data' => $topic
      ]);
    } else {
      return RestApi::error('404 Not Found.', 404);
    }
  }

  public function update(Request $request, $uuid) {
    if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {
      $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'users' => 'required|array',
        'users.*' => 'required|string',
      ]);
      
      if($validator->fails()) {
          return RestApi::error($validator->messages()->first(), 400);
      }
      
      $topic = Topic::findByUuid($uuid);

      if (!isset($topic->id)) {
        return RestApi::error('Topic tidak ditemukan.', 404);
      }

      if ($topic->update($request->only(['name']))) {
        UserTopic::where('topic_id', $topic->id)->delete();

        foreach ($request['users'] as $user) {
          $user = User::findByUuid($user);
          UserTopic::create([
            'user_id' => $user->id,
            'topic_id' => $topic->id,
          ]);
        }

        return response()->json([
          'status' => true,
          'data' => 'Berhasil merubah topik.'
        ]);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Gagal merubah topik.'
        ], 400);
      }
    } else {
      return RestApi::error('404 Not Found.', 404);
    }
  }

  public function delete($uuid) {
    if (request()->wantsJson() && request()->ajax()) {
      $topic = Topic::findByUuid($uuid);

      if (!$topic) {
        return response()->json([
          'status' => false,
          'message' => 'data tidak ada'
        ], 400);
      }

      $topic->delete();

      if ($topic) {
        return response()->json([
          'status' => true,
          'data' => 'Berhasil menghapus topik.'
        ]);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Gagal menghapus topik.'
        ], 500);
      }
    } else {
      abort(404);
    }
  }
}
