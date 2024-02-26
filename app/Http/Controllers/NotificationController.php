<?php

namespace App\Http\Controllers;

use App\Models\HasReadNotification;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Helpers\RestApi;
use App\Models\NotificationTopic;
use App\Helpers\AppHelper;
use App\Models\Topic;

class NotificationController extends Controller {
  public function index(Request $request) {
    if (request()->wantsJson()) {

      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      DB::statement(DB::raw('set @angka=0+' . $page * $per));
      $notif = Notification::where(function ($q) use ($request) {
        $q->where('judul', 'LIKE', '%' . $request->search . '%');
        $q->where('isi', 'LIKE', '%' . $request->search . '%');
      })->where('onclick', 'SHOW_DETAIL')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

      $notif->map(function ($a) {
        $a->action = '
          <button class="btn btn-sm btn-light-info mb-2 resend" title="Kirim Ulang" data-id="' . $a->uuid . '"><i class="fa fa-paper-plane"></i> Kirim Ulang</button>
          <button class="btn btn-sm btn-icon btn-light-danger mb-2 delete" title="Delete" data-id="' . $a->uuid . '"><i class="fa fa-trash"></i></button>
        ';
        return $a;
      });

      return response()->json($notif);
    } else {
      abort(404);
    }
  }

  public function create(Request $request) {
    if (request()->wantsJson() && request()->ajax()) {
      $validator = Validator::make($request->all(), [
        'judul' => 'required|string',
        'isi' => 'required|string',
        'image' => 'nullable|image',
        'topics' => 'required|array',
        'topics.*' => 'string',
      ]);

      if ($validator->fails()) {
        return response()->json([
          'status'    => false,
          'message'   => $validator->messages()->first()
        ], 400);
      }

      $data = $request->only(['judul', 'isi', 'image']);
      if(isset($request->image)) {
        $rules = [
          'image' => 'mimes:jpg,png,jpeg|max:5120',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
          return RestApi::error($validator->messages()->first(), 400);
        }

        $image = 'NOTIFICATION_'.strtoupper(str_slug($request->title, "_")).'_'.time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('uploads/images'), $image);
        $data['image'] = $image;
      }

      $notif = Notification::create($data);

      if ($notif) {
        $notif = Notification::findByUuid($notif->uuid);
        foreach ($request['topics'] as $topic) {
          $topic = Topic::findByUuid($topic);
          $notifTopic = NotificationTopic::create([
            'notification_id' => $notif->id,
            'topic_id' => $topic->id,
          ]);

          if ($notifTopic) {
            AppHelper::sendNotif($notif, $topic);
          }
        }

        return response()->json([
          'status' => true,
          'data' => 'Berhasil menambah data.'
        ]);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Gagal menambah data.'
        ], 500);
      }
    } else {
      abort(404);
    }
  }

  public function show() {
    $user = User::findByUuid(JWTAuth::user()->uuid);
    $notifications = $user->topics()->with('notifications')->get()->map(function ($topic) {
      return $topic->notifications;
    })->flatten();

    // Ambil notifikasi yang dikirim ke semua user (grup topik Semua User)
    NotificationTopic::where('topic_id', 1)->with('notification')->each(function ($nt) use ($notifications) {
      $notifications->push($nt->notification);
    });

    return response()->json([
      'status'    => true,
      'data'      => $notifications->sortByDesc('created_at')->flatten()
    ], 200);
  }

  public function detail($uuid) {
    if (request()->wantsJson() && request()->ajax()) {
      $notif = Notification::findByUuid($uuid);

      if (!$notif) {
        return RestApi::error('Notifikasi tidak ditemukan.', 404);
      }

      return RestApi::success($notif);
    } else {
      abort(404);
    }
  }

  public function delete($uuid) {
    if (request()->wantsJson() && request()->ajax()) {
      $notif = Notification::findByUuid($uuid);

      if (!$notif) {
        return response()->json([
          'status' => false,
          'message' => 'data tidak ada'
        ], 400);
      }

      if (is_file(public_path('uploads/images/'.$notif->image))) {
        unlink(public_path('uploads/images/'.$notif->image));
      }

      $notif->delete();

      if ($notif) {
        return response()->json([
          'status' => true,
          'data' => 'Berhasil menghapus data '
        ]);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Gagal menghapus data.'
        ], 500);
      }
    } else {
      abort(404);
    }
  }

  public function hasRead(Request $request) {
    $user = User::findByUuid(JWTAuth::user()->uuid);

    return response()->json([
      'status' => true,
      'data' => $user->has_read_notifications
    ], 200);
  }

  public function unRead(Request $request) {
    $user = User::findByUuid(JWTAuth::user()->uuid);
    $notifications = $user->topics()->with('notifications')->get()->map(function ($topic) {
      return $topic->notifications;
    })->flatten();

    // Ambil notifikasi yang dikirim ke semua user (grup topik Semua User)
    NotificationTopic::where('topic_id', 1)->with('notification')->each(function ($nt) use ($notifications) {
      $notifications->push($nt->notification);
    });

    $unReadNotifs = $notifications->filter(function ($notif) use ($user) {
      return !$user->has_read_notifications->map(function ($read) {
        return $read->uuid;
      })->contains($notif->uuid);
    })->unique('id')->values()->all();

    return response()->json([
        'status' => true,
        'data' => $unReadNotifs
    ], 200);
  }

  public function countUnRead(Request $request) {
    $user = User::findByUuid(JWTAuth::user()->uuid);
    $notifications = $user->topics()->with('notifications')->get()->map(function ($topic) {
      return $topic->notifications;
    })->flatten();

    // Ambil notifikasi yang dikirim ke semua user (topic Semua User)
    NotificationTopic::where('topic_id', 1)->with('notification')->each(function ($nt) use ($notifications) {
      $notifications->push($nt->notification);
    });

    $unReadNotifs = $notifications->filter(function ($notif) use ($user) {
      return !$user->has_read_notifications->map(function ($read) {
        return $read->uuid;
      })->contains($notif->uuid);
    })->unique('id');

    return response()->json([
        'status' => true,
        'data' => $unReadNotifs->count()
    ], 200);
  }

  public function read($uuid) {
    if (request()->wantsJson() && request()->ajax()){
      $notif = Notification::findByUuid($uuid);

      if ($notif) {
        HasReadNotification::firstOrCreate([
          'user_id' => JWTAuth::user()->id,
          'notification_id' => $notif->id
        ]);
        return response()->json([
          'status' => true,
          'data' => $notif
        ], 200);
      }
    } else {
      abort(404);
    }
  }

  public function get($uuid) {
    $notif = Notification::findByUuid($uuid);

    if ($notif) {
      // HasReadNotification::firstOrCreate([
      //   'user_id' => JWTAuth::user()->id,
      //   'notification_id' => $notif->id
      // ]);
      return response()->json([
        'status' => true,
        'data' => $notif
      ], 200);
    }
  }

  public function resend($uuid) {
    if (request()->wantsJson() && request()->ajax()) {
      $notif = Notification::findByUuid($uuid);

      if (!$notif) {
        return RestApi::error('Notifikasi tidak ditemukan.', 404);
      }

      foreach ($notif->topics as $topic) {
        AppHelper::sendNotif($notif, $topic);
      }

      HasReadNotification::where('notification_id', $notif->id)->delete();

      return RestApi::success('Berhasil mengirim ulang notifikasi.');
    } else {
      abort(404);
    }
  }
}
