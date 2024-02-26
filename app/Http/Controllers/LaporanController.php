<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseOther;
use App\Models\CourseSection;
use Illuminate\Support\Facades\DB;
use App\Helpers\AppHelper;
use Illuminate\Support\Carbon;

class LaporanController extends Controller {
  public function peserta(Request $request) {
    if (request()->wantsJson() && request()->ajax()) {
      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      DB::statement(DB::raw('set @angka=0+' . $page * $per));
      $data = User::withCount(['courses' => function ($q) {
        $q->where('is_finish', 'Y');
        $q->orWhere('status', '!=', '0');
      }])->where(function ($q) use ($request) {
        $q->where('name', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('email', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('jenis', 'LIKE', '%' . $request->search . '%');
      })->orderBy('courses_count', 'DESC')->paginate($per);

      $data->map(function ($a) {
        $a->angka = DB::select(DB::raw('select @angka:=@angka+1 as angka'))[0]->angka;
        $a->courses_count = $a->courses_count . ' kursus';
        $a->action = '
          <button class="btn btn-sm btn-info show-course" title="Lihat kursus yang diikuti oleh peserta ini" data-id="' . $a->uuid . '">
            <i class="fa fa-eye"></i>
            Detail
          </button>
        ';
        return $a;
      });

      return response()->json($data);
    } else {
      abort(404);
    }
  }

  public function pesertaCourses(Request $request) {
    if (request()->wantsJson() && request()->ajax()) {
      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      $user = User::findByUuid($request->peserta);

      DB::statement(DB::raw('set @angka=0+' . $page * $per));
      $data = CourseSection::with(['Course.Categories', 'CourseOther.Categories'])->where(function ($q) use ($request) {
        $q->whereHas('Course', function ($q) use ($request) {
          $q->where('nm_course', 'LIKE', '%' . $request->search . '%');
          $q->where('is_finish', 'Y');
          $q->orWhereHas('Categories', function ($q) use ($request) {
            $q->where('nm_category', 'LIKE', '%' . $request->search . '%');
          });
        });
        $q->orWhereHas('CourseOther', function ($q) use ($request) {
          $q->where('title', 'LIKE', '%' . $request->search . '%');
          $q->orWhereHas('Categories', function ($q) use ($request) {
            $q->where('nm_category', 'LIKE', '%' . $request->search . '%');
          });
        });
      })
        ->where('user_id', $user->id)->orderBy('created_at', 'DESC')
        ->select(['*', DB::raw('@angka  := @angka  + 1 AS angka')])->get();


      $data->map(function ($a) {
        if (isset($a->Course->id)) {
          $a->name = $a->Course->nm_course;
          $a->tipe = '<span class="label label-lg label-info label-inline">MANDIRI</span>';

          if (isset($a->Course->Categories)) {
            $a->category = $a->Course->Categories->implode('nm_category', ', ');
          }

          $a->jumlah_peserta = $a->Course->CourseSection->count() . ' orang';
          $a->action = '
            <button class="btn btn-sm btn-info detail-course" title="Lihat detail kursus" data-route="admin.course.list.peserta" data-id="' . $a->Course->uuid . '">
              <i class="fa fa-eye"></i>
              Detail
            </button>
          ';
        } else if (isset($a->CourseOther->id)) {
          $a->name = $a->CourseOther->title;
          if ($a->CourseOther->is_online) {
            $a->tipe = '<span class="label label-lg label-danger label-inline">ONLINE</span>';
          } else {
            $a->tipe = '<span class="label label-lg label-success label-inline">OFFLINE</span>';
          }

          if (isset($a->CourseOther->Categories)) {
            $a->category = $a->CourseOther->Categories->implode('nm_category', ', ');
          }

          $a->jumlah_peserta = $a->CourseOther->CourseSection->count() . ' orang';
          $a->action = '
            <button class="btn btn-sm btn-info detail-course" title="Lihat detail kursus" data-route="admin.course.other.peserta" data-id="' . $a->CourseOther->uuid . '">
              <i class="fa fa-eye"></i>
              Detail
            </button>
          ';
        }

        $a->makeHidden('Course');
        $a->makeHidden('CourseOther');
        return $a;
      });

      return response()->json(AppHelper::paginateCollection($data->unique(function ($a) {
        return $a->course_id . '-' . $a->course_other_id;
      }), $per));
    } else {
      abort(404);
    }
  }

  public function chartJenisPeserta(Request $request) {
    if (request()->wantsJson() && request()->ajax()) {
      $data = User::where(function ($q) use ($request) {
        if ($request->province_id != 0) {
          $q->where('province_id', $request->province_id);
        }
        if ($request->city_id != 0) {
          $q->where('city_id', $request->city_id);
        }
      })
        ->where('jenis', '!=', 'null')->get();
      $chart = [
        [
          'name' => 'UKM',
          'jumlah' => $data->filter(function ($a) {
            return $a->jenis == 'UKM';
          })->count()
        ],
        [
          'name' => 'KOPERASI',
          'jumlah' => $data->filter(function ($a) {
            return $a->jenis == 'KOPERASI';
          })->count()
        ],
        [
          'name' => 'INSTANSI',
          'jumlah' => $data->filter(function ($a) {
            return $a->jenis == 'INSTANSI';
          })->count()
        ],
        [
          'name' => 'UMUM',
          'jumlah' => $data->filter(function ($a) {
            return $a->jenis == 'UMUM';
          })->count()
        ]
      ];
      return response()->json([
        'status' => 'success',
        'data' => $chart
      ]);
    } else {
      abort(404);
    }
  }

  public function chartGenderPeserta(Request $request) {
    if (request()->wantsJson() && request()->ajax()) {
      $data = User::where(function ($q) use ($request) {
        if ($request->province_id != 0) {
          $q->where('province_id', $request->province_id);
        }
        if ($request->city_id != 0) {
          $q->where('city_id', $request->city_id);
        }
      })
        ->where('gender', '!=', 'null')
        ->get();
      $chart = [
        [
          'name' => 'PRIA',
          'jumlah' => $data->filter(function ($a) {
            return $a->gender == '1';
          })->count()
        ],
        [
          'name' => 'WANITA',
          'jumlah' => $data->filter(function ($a) {
            return $a->gender == '0';
          })->count()
        ]
      ];
      return response()->json([
        'status' => 'success',
        'data' => $chart
      ]);
    } else {
      abort(404);
    }
  }

  public function lineChartCourses(Request $request) {
    if (request()->wantsJson() && request()->ajax()) {
      $months = collect([
        ['name' => 'Jan', 'num' => '01'],
        ['name' => 'Feb', 'num' => '02'],
        ['name' => 'Mar', 'num' => '03'],
        ['name' => 'Apr', 'num' => '04'],
        ['name' => 'Mei', 'num' => '05'],
        ['name' => 'Jun', 'num' => '06'],
        ['name' => 'Jul', 'num' => '07'],
        ['name' => 'Agu', 'num' => '08'],
        ['name' => 'Sep', 'num' => '09'],
        ['name' => 'Okt', 'num' => '10'],
        ['name' => 'Nov', 'num' => '11'],
        ['name' => 'Des', 'num' => '12']
      ]);

      if ($request->type == 'mandiri') {
        $courses = Course::whereYear('created_at', $request->tahun)
          ->when($request->category != 'semua', function ($q) use ($request) {
            $q->whereHas('Categories', function ($q) use ($request) {
              $q->where('nm_category', $request->category);
            });
          })
          ->get()->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('m');
          });

        $users = CourseSection::whereYear('created_at', $request->tahun)
          ->where('course_id', '!=', null)
          ->get()->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('m');
          });
      } else {
        $courses = CourseOther::whereYear('created_at', $request->tahun)
          ->when($request->category != 'semua', function ($q) use ($request) {
            $q->whereHas('Categories', function ($q) use ($request) {
              $q->where('nm_category', $request->category);
            });
          })
          ->where('is_online', $request->type == 'online' ? '1' : '0')
          ->get()->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('m');
          });

        $users = CourseSection::whereYear('created_at', $request->tahun)
          ->where('course_other_id', '!=', null)
          ->whereHas('CourseOther', function ($q) use ($request) {
            $q->where('is_online', $request->type == 'online' ? '1' : '0');
          })
          ->get()->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('m');
          });
      }

      $labels = $months->map(function ($a) {
        return $a['name'];
      });
      $courses = $months->map(function ($a) use ($courses) {
        return $courses->has($a['num']) ? $courses->get($a['num'])->count() : 0;
      });
      $users = $months->map(function ($a) use ($users) {
        return $users->has($a['num']) ? $users->get($a['num'])->count() : 0;
      });

      return response()->json([
        'status' => 'success',
        'data' => [
          'labels' => $labels,
          'courses' => $courses,
          'users' => $users
        ]
      ]);
    } else {
      abort(404);
    }
  }
}
