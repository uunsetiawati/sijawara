<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use DB, JWTAuth, RestApi, Validator;

class BlogController extends Controller
{
	public function index(Request $request)
    {
    	if (request()->wantsJson() && request()->ajax()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $blog = Blog::where(function($q) use ($request) {
                $q->where('title', 'LIKE', '%'.$request->search.'%');
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $blog->map(function($a) {
            	$a->content = substr(strip_tags($a->content), 0, 110);
                $a->images = '<img src="'.$a->image_url.'" class="img-responsive" style="height: 40px; width: 60px; object-fit: cover;"/>';
                $a->action = '<button class="btn btn-sm btn-primary edit" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-pencil-alt"></i> Edit</button> <button class="btn btn-sm btn-danger delete" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-trash"></i> Hapus</button>';

                switch ($a->lang) {
                    case 'id':
                        $a->lang = '<img src="/assets/media/svg/flags/004-indonesia.svg" class="img-responsive img-thumbnail" style="height: 40px; width: 60px; object-fit: cover;"/>';
                        break;

                    case 'en':
                        $a->lang = '<img src="/assets/media/svg/flags/226-united-states.svg" class="img-responsive img-thumbnail" style="height: 40px; width: 60px; object-fit: cover;"/>';
                        break;
                }
                return $a;
            });

            return response()->json($blog);

        }else{
            abort(404);
        }
    }

    public function show(Request $request, $slug=null)
    {
        if (request()->wantsJson() && request()->ajax()) {

            $lang = [];
            if(isset($request->hl)) {
                $lang = ['lang' => $request->hl];
            }

            $take = 16;
            if($request->take) {
                $take = $request->take;
            }
            $page = $request->page-1;
            $blog = Blog::with('Category.Category')->where($lang)->where('title', 'LIKE', '%'.$request->q.'%')->whereHas('Category', function($q) use ($request){
                if($request->type != 'all') {
                    $q->where('blog_category_id', $request->type);
                }
            })->orderBy('created_at', 'DESC')->skip($take*$page)->take($take)->get();

            // $blog->map(function($a) {
            foreach ($blog as $a) {
                $categories = [];
                foreach ($a->Category as $res) {
                    $categories[] = $res->Category->nm_category;
                }
                unset($a->Category);
                $a->category = $categories;
            }

            // $blog = Blog::with('Category')->get()->skip($take*$page)->take($take)->get();

            if($slug != null) {
                $blog = Blog::with('Category.Category')->where($lang)->where('slug', $slug)->first();
                if(!isset($blog->id)) {
                    return RestApi::error('Berita tidak ditemukan.', 404);
                }
                $categories = [];
                foreach ($blog->Category as $res) {
                    $categories[] = $res->Category->nm_category;
                }
                // unset($blog->Category);
                // $blog->category = $categories;

                if(!isset($blog->id)) {
                    return RestApi::error('Berita tidak ditemukan.', 404);
                }
            }
            
            return RestApi::success($blog);
        }else{
            return response()->json([
                'status' => false,
                'message' => '404 Not Found.'
            ], 404);
        }
    }

    public function create(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $rules = [
                'title' => 'required|string',
                'content' => 'required|string',
                'images' => 'required',
                'lang' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $data = [
                'user_id' => JWTAuth::user()->id,
                'title' => $request->title,
                'content' => $request->content,
                'slug' => str_slug($request->title).'-'.strtolower(str_random(6)),
                'lang' => $request->lang,
            ];

            if(is_uploaded_file($request->images)) {
                $rules = [
                    'images' => 'required|mimes:jpg,png,jpeg|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $images = 'BLOG_IMAGE_'.strtoupper(str_slug($request->title, "_")).'_'.time().'.'.request()->images->getClientOriginalExtension();
                request()->images->move(public_path('uploads/images'), $images);
                // unset($request['image']);
                $data['images'] = $images;
            }

            $blog = Blog::create($data);

            if(isset($request->categories)) {
                foreach (explode(',', $request->categories) as $res) {
                    \App\Models\BlogCategoryTemp::create(['blog_id' => $blog->id, 'blog_category_id' => $res]);
                }
            }

            if($blog) {
                return RestApi::success('Berhasil menambah data.');
            } else {
                return RestApi::error('Gagal menambah data.', 400);
            }
            
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }

    public function edit($uuid)
    {
        if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {
            
            $blog = Blog::findByUuid($uuid);

            if (!isset($blog->id)) {
                return RestApi::error('Blog tidak ditemukan.', 404);
            }

            $categories = [];

            $categoriesx = \App\Models\BlogCategoryTemp::where('blog_id', $blog->id)->get();
            foreach ($categoriesx as $res) {
                $categories[] = $res->blog_category_id;
            }

            $blog->categories = $categories;

            return response()->json([
                'status' => true,
                'data' => $blog
            ]);
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }

    public function update(Request $request, $uuid)
    {
        if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {

            $rules = [
                'title' => 'required|string',
                'content' => 'required|string',
                'lang' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $data = [
                'user_id' => JWTAuth::user()->id,
                'title' => $request->title,
                'content' => $request->content,
                'slug' => str_slug($request->title),
                'lang' => $request->lang,
            ];

            $blog = Blog::findByUuid($uuid);

            if (!isset($blog->id)) {
                return RestApi::error('Blog tidak ditemukan.', 404);
            }

            if(is_uploaded_file($request->images)) {
                $rules = [
                    'images' => 'required|mimes:jpg,png,jpeg|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $images = 'BLOG_IMAGE_'.strtoupper(str_slug($request->title, "_")).'_'.time().'.'.request()->images->getClientOriginalExtension();
                request()->images->move(public_path('uploads/images'), $images);
                // unset($request['image']);
                $data['images'] = $images;
            }

            $cek = \App\Models\BlogCategoryTemp::where('blog_id', $blog->id)->delete();
            if(isset($request->categories)) {
                foreach (explode(',', $request->categories) as $res) {
                    if(isset($res)) {
                        \App\Models\BlogCategoryTemp::create(['blog_id' => $blog->id, 'blog_category_id' => $res]);
                    }
                }
            }

            if ($blog->update($data)) {
                return RestApi::success('Berhasil mengubah data.');
            } else {
                return RestApi::error('Gagal mengubah data.', 400);
            }
            
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }
    
    public function delete($uuid)
    {
        if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {
            
            $blog = Blog::findByUuid($uuid);

            if (!isset($blog->id)) {
                return RestApi::error('Blog tidak ditemukan.', 404);
            }

            if(isset($blog->images)){
                $img = public_path('uploads/images/').$blog->images;
                if (file_exists($img) && is_file($img)) {
                    unlink($img);
                }
            }
            
            if ($blog->delete()) {
                return RestApi::success('Berhasil menghapus data.');
            } else {
                return RestApi::error('Gagal menghapus data.', 400);
            }
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }
}
