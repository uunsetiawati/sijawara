<?php

use Illuminate\Http\Request;

/// HAPUS NOMOR UNTUK MAS AKIL
Route::get('rwpn', 'UserController@rwpn');

Route::prefix('front')->group(function() {
	Route::prefix('course')->group(function() {
		Route::get('show', 'CourseController@show');
    	Route::post('detail', 'FrontController@courseDetail');

		Route::prefix('other')->group(function() {
	    	Route::get('show', 'CourseOtherController@show');
			Route::post('detail', 'FrontController@courseOtherDetail');
	    });

	    Route::prefix('events')->group(function() {
	    	Route::get('show', 'FrontController@courseEvents');
	    	Route::get('category', 'CategoryController@show');
	    });

    });

    Route::prefix('blog')->group(function() {
    	Route::get('show', 'BlogController@show');
    	Route::get('category', 'BlogCategoryController@show');
    	Route::get('{slug}', 'BlogController@show');
    });

    Route::prefix('slider')->group(function() {
    	Route::get('show', 'SliderController@show');
    });

    Route::prefix('announcement')->group(function() {
    	Route::get('show', 'PengumumanController@show');
    });

    Route::prefix('widyaiswara')->group(function() {
    	Route::get('show', 'WidyaiswaraController@show');
    });
});

Route::prefix('oauth')->group(function () {
	Route::post('{provider}', 'Api\AuthController@loginGoogle');
});

Route::prefix('v1')->group(function() {

	// Route::get('faq', 'FaqController@show');
	Route::get('setting', 'SettingController@show');
	
	Route::prefix('auth')->group(function(){
		Route::post('checkOtp', 'AuthController@checkOtp');
		Route::get('verify/{verification_code}', 'AuthController@verifyUser');
		Route::post('register', 'AuthController@register');
		Route::post('login', 'AuthController@login');
		// Route::post('recover', 'AuthController@recover');
		// Route::post('recover/check', 'AuthController@checkRecover');
		// Route::post('recover/send', 'AuthController@postRecover');
		Route::post('checkEmail', 'Api\AuthController@checkEmail');
		Route::post('checkNik', 'Api\AuthController@checkNik');
	});

	Route::prefix('secure')->group(function(){
		Route::post('checkCredentials', 'Api\AuthController@checkCredentials');
		Route::post('getOtp', 'Api\AuthController@getOtp');
		Route::post('checkOtp', 'Api\AuthController@checkOtp');
		Route::post('login', 'Api\AuthController@login');

		Route::prefix('register')->group(function(){
			Route::post('/', 'Api\AuthController@register');
			Route::post('getOtp', 'Api\AuthController@getOtpRegister');
			Route::post('checkOtp', 'Api\AuthController@checkOtpRegister');
			Route::post('checkOtpOauth', 'Api\AuthController@checkOtpOauth');
		});

		Route::prefix('forgot')->group(function(){
			Route::post('getOtp', 'Api\AuthController@forgotPassword');
			Route::post('checkOtp', 'Api\AuthController@forgotCheck');
			Route::group(['middleware' => ['jwt.auth']], function() {
				Route::post('send', 'Api\AuthController@updatePassword');
			});
		});
	});

	Route::group(['middleware' => ['jwt.auth']], function() {

		Route::get('check_data', 'HomeController@checkJenis');
		Route::get('check_profile', 'HomeController@checkProfile');

		Route::prefix('export')->group(function() {
			Route::post('offline_course_participants', 'ExportExcelController@offlineCourseParticipant');
			Route::post('online_course_participants', 'ExportExcelController@onlineCourseParticipant');
			Route::post('course_participants', 'ExportExcelController@courseParticipant');
			Route::group(['middleware' => ['admin.access']], function() {
				Route::post('koperasi', 'ExportExcelController@koperasiExcel');
				Route::post('ukm', 'ExportExcelController@ukmExcel');
			});
		});

		Route::prefix('certificate')->group(function() {
			Route::post('course/getCertificate', 'CertificateController@course');
			Route::post('online/getCertificate', 'CertificateController@online');
			Route::post('offline/getCertificate', 'CertificateController@offline');
		});

		Route::prefix('ukm')->group(function() {
			Route::get('check', 'UkmController@check');
			Route::post('save', 'UkmController@create');
			Route::post('update', 'UkmController@update');
			Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'UkmController@index');
	    		Route::post('create', 'UkmController@create');
	    		Route::get('{uuid}/edit', 'UkmController@edit');
	    	});
		});

		Route::prefix('koperasi')->group(function() {
			Route::get('check', 'KoperasiController@check');
			Route::post('save', 'KoperasiController@create');
			Route::post('update', 'KoperasiController@update');
			Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'KoperasiController@index');
	    		Route::post('create', 'KoperasiController@create');
	    		Route::get('{uuid}/edit', 'KoperasiController@edit');
	    	});
		});

		Route::prefix('home')->group(function() {
			Route::group(['middleware' => ['admin.access']], function() {
				Route::get('getDashboard', 'HomeController@getDashboard');
			});
		});

		Route::prefix('auth')->group(function(){
		    Route::post('logout', 'AuthController@logout');
		    Route::get('user', 'AuthController@user');
		    Route::get('refresh', 'AuthController@refresh');
		});

		Route::prefix('secure')->group(function(){
		    Route::post('logout', 'Api\AuthController@logout');
		    Route::get('user', 'Api\AuthController@user');
		    Route::get('refresh', 'Api\AuthController@refresh');

			Route::prefix('register')->group(function(){
				Route::post('checkEmail', 'Api\AuthController@checkEmail');
				Route::post('checkNik', 'Api\AuthController@checkNik');
				Route::post('updateInfo', 'Api\AuthController@updateInfoRegister');
			});
		});

		Route::prefix('user')->group(function() {
			Route::post('changePassword', 'UserController@changePassword');
			Route::post('updateProfile', 'UserController@updateProfile');
			Route::group(['middleware' => ['admin.access']], function() {
				Route::post('index', 'UserController@index');
				Route::get('{uuid}/detail', 'UserController@detail');
				Route::post('forTopic', 'UserController@forTopic');
			});
		});

		Route::prefix('blog')->group(function() {
			Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'BlogController@index');
	    		Route::post('create', 'BlogController@create');
	    		Route::get('{uuid}/edit', 'BlogController@edit');
	    		Route::post('{uuid}/update', 'BlogController@update');
	    		Route::delete('{uuid}/delete', 'BlogController@delete');
	    	});

			Route::prefix('category')->group(function() {
		    	Route::get('show', 'BlogCategoryController@show');
		    	Route::group(['middleware' => ['admin.access']], function() {
		    		Route::post('index', 'BlogCategoryController@index');
		    		Route::post('create', 'BlogCategoryController@create');
		    		Route::get('{uuid}/edit', 'BlogCategoryController@edit');
		    		Route::post('{uuid}/update', 'BlogCategoryController@update');
		    		Route::delete('{uuid}/delete', 'BlogCategoryController@delete');
		    	});
		    });
		});

	    Route::prefix('course')->group(function() {

	    	Route::get('show', 'CourseController@show');
	    	Route::get('joined', 'CourseController@joined');
	    	Route::post('detail', 'CourseController@detail');
	    	Route::post('get_section', 'CourseController@section');
	    	Route::post('section', 'CourseContentController@detail');
	    	Route::post('join', 'CourseController@join');
	    	Route::post('complete', 'CourseController@complete');
	    	Route::post('checkQuestion', 'CourseContentController@checkQuestion');
	    	Route::post('saveAnswer', 'CourseContentController@saveAnswer');
	    	Route::post('get_score', 'CourseController@getScore');
	    	Route::group(['middleware' => ['admin.access']], function() {
		    	Route::post('peserta', 'CourseController@peserta');
	    	});

	    	Route::prefix('category')->group(function() {
		    	Route::get('show', 'CategoryController@show');
		    	Route::group(['middleware' => ['admin.access']], function() {
		    		Route::post('index', 'CategoryController@index');
		    		Route::post('create', 'CategoryController@create');
		    		Route::get('{uuid}/edit', 'CategoryController@edit');
		    		Route::post('{uuid}/update', 'CategoryController@update');
		    		Route::delete('{uuid}/delete', 'CategoryController@delete');
		    	});
		    });

		    Route::prefix('content')->group(function() {
		    	Route::get('show', 'CourseContentController@show');
		    	Route::group(['middleware' => ['admin.access']], function() {
		    		Route::post('index', 'CourseContentController@index');
		    		Route::post('create', 'CourseContentController@create');
		    		Route::get('{uuid}/edit', 'CourseContentController@edit');
		    		Route::post('{uuid}/update', 'CourseContentController@update');
		    		Route::delete('{uuid}/delete', 'CourseContentController@delete');
		    	});
		    });

		    Route::prefix('other')->group(function() {
		    	Route::get('show', 'CourseOtherController@show');
		    	Route::post('detail', 'CourseOtherController@detail');
		    	Route::post('join', 'CourseOtherController@join');
		    	Route::group(['middleware' => ['admin.access']], function() {
		    		Route::post('index', 'CourseOtherController@index');
			    	Route::post('peserta', 'CourseOtherController@peserta');
			    	Route::post('verif', 'CourseOtherController@verif');
			    	Route::post('reject', 'CourseOtherController@reject');
		    		Route::post('create', 'CourseOtherController@create');
		    		Route::get('{uuid}/edit', 'CourseOtherController@edit');
		    		Route::post('{uuid}/update', 'CourseOtherController@update');
		    		Route::delete('{uuid}/delete', 'CourseOtherController@delete');
		    	});
		    });

	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'CourseController@index');
	    		Route::post('create', 'CourseController@create');
	    		Route::get('{uuid}/edit', 'CourseController@edit');
	    		Route::post('{uuid}/update', 'CourseController@update');
	    		Route::delete('{uuid}/delete', 'CourseController@delete');
	    	});

	    });

	    Route::prefix('widyaiswara')->group(function() {
	    	Route::get('show', 'WidyaiswaraController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'WidyaiswaraController@index');
	    		Route::post('create', 'WidyaiswaraController@create');
	    		Route::get('{uuid}/edit', 'WidyaiswaraController@edit');
	    		Route::post('{uuid}/update', 'WidyaiswaraController@update');
	    		Route::delete('{uuid}/delete', 'WidyaiswaraController@delete');
	    	});
	    });

	    Route::prefix('pengumuman')->group(function() {
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'PengumumanController@index');
	    		Route::post('create', 'PengumumanController@create');
	    		Route::get('{uuid}/edit', 'PengumumanController@edit');
	    		Route::post('{uuid}/update', 'PengumumanController@update');
	    		Route::delete('{uuid}/delete', 'PengumumanController@delete');
	    	});
	    });

	    Route::prefix('slider')->group(function() {
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'SliderController@index');
	    		Route::post('create', 'SliderController@create');
	    		Route::get('{uuid}/edit', 'SliderController@edit');
	    		Route::post('{uuid}/update', 'SliderController@update');
	    		Route::delete('{uuid}/delete', 'SliderController@delete');
	    	});
	    });

	    Route::prefix('province')->group(function() {
	    	Route::get('show', 'ProvinceController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'ProvinceController@index');
	    		Route::post('create', 'ProvinceController@create');
	    		Route::get('{uuid}/edit', 'ProvinceController@edit');
	    		Route::post('{uuid}/update', 'ProvinceController@update');
	    		Route::delete('{uuid}/delete', 'ProvinceController@delete');
	    	});
	    });

	    Route::prefix('city')->group(function() {
	    	Route::get('show', 'CityController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'CityController@index');
	    		Route::post('create', 'CityController@create');
	    		Route::get('{uuid}/edit', 'CityController@edit');
	    		Route::post('{uuid}/update', 'CityController@update');
	    		Route::delete('{uuid}/delete', 'CityController@delete');
	    	});
	    });

	    Route::prefix('badan_usaha')->group(function() {
	    	Route::get('show', 'BadanUsahaController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'BadanUsahaController@index');
	    		Route::post('create', 'BadanUsahaController@create');
	    		Route::get('{uuid}/edit', 'BadanUsahaController@edit');
	    		Route::post('{uuid}/update', 'BadanUsahaController@update');
	    		Route::delete('{uuid}/delete', 'BadanUsahaController@delete');
	    	});
	    });

	    Route::prefix('bentuk_koperasi')->group(function() {
	    	Route::get('show', 'BentukKoperasiController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'BentukKoperasiController@index');
	    		Route::post('create', 'BentukKoperasiController@create');
	    		Route::get('{uuid}/edit', 'BentukKoperasiController@edit');
	    		Route::post('{uuid}/update', 'BentukKoperasiController@update');
	    		Route::delete('{uuid}/delete', 'BentukKoperasiController@delete');
	    	});
	    });

	    Route::prefix('jabatan_ukm')->group(function() {
	    	Route::get('show', 'JabatanUkmController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'JabatanUkmController@index');
	    		Route::post('create', 'JabatanUkmController@create');
	    		Route::get('{uuid}/edit', 'JabatanUkmController@edit');
	    		Route::post('{uuid}/update', 'JabatanUkmController@update');
	    		Route::delete('{uuid}/delete', 'JabatanUkmController@delete');
	    	});
	    });

	    Route::prefix('jenis_koperasi')->group(function() {
	    	Route::get('show', 'JenisKoperasiController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'JenisKoperasiController@index');
	    		Route::post('create', 'JenisKoperasiController@create');
	    		Route::get('{uuid}/edit', 'JenisKoperasiController@edit');
	    		Route::post('{uuid}/update', 'JenisKoperasiController@update');
	    		Route::delete('{uuid}/delete', 'JenisKoperasiController@delete');
	    	});
	    });

	    Route::prefix('kategori_ukm')->group(function() {
	    	Route::get('show', 'KategoriUkmController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'KategoriUkmController@index');
	    		Route::post('create', 'KategoriUkmController@create');
	    		Route::get('{uuid}/edit', 'KategoriUkmController@edit');
	    		Route::post('{uuid}/update', 'KategoriUkmController@update');
	    		Route::delete('{uuid}/delete', 'KategoriUkmController@delete');
	    	});
	    });

	    Route::prefix('kelompok_koperasi')->group(function() {
	    	Route::get('show', 'KelompokKoperasiController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'KelompokKoperasiController@index');
	    		Route::post('create', 'KelompokKoperasiController@create');
	    		Route::get('{uuid}/edit', 'KelompokKoperasiController@edit');
	    		Route::post('{uuid}/update', 'KelompokKoperasiController@update');
	    		Route::delete('{uuid}/delete', 'KelompokKoperasiController@delete');
	    	});
	    });

	    Route::prefix('masalah_koperasi')->group(function() {
	    	Route::get('show', 'MasalahKoperasiController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'MasalahKoperasiController@index');
	    		Route::post('create', 'MasalahKoperasiController@create');
	    		Route::get('{uuid}/edit', 'MasalahKoperasiController@edit');
	    		Route::post('{uuid}/update', 'MasalahKoperasiController@update');
	    		Route::delete('{uuid}/delete', 'MasalahKoperasiController@delete');
	    	});
	    });

	    Route::prefix('sektor_usaha')->group(function() {
	    	Route::get('show', 'SektorUsahaController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'SektorUsahaController@index');
	    		Route::post('create', 'SektorUsahaController@create');
	    		Route::get('{uuid}/edit', 'SektorUsahaController@edit');
	    		Route::post('{uuid}/update', 'SektorUsahaController@update');
	    		Route::delete('{uuid}/delete', 'SektorUsahaController@delete');
	    	});
	    });

	    Route::prefix('unit_usaha')->group(function() {
	    	Route::get('show', 'UnitUsahaController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'UnitUsahaController@index');
	    		Route::post('create', 'UnitUsahaController@create');
	    		Route::get('{uuid}/edit', 'UnitUsahaController@edit');
	    		Route::post('{uuid}/update', 'UnitUsahaController@update');
	    		Route::delete('{uuid}/delete', 'UnitUsahaController@delete');
	    	});
	    });

	    Route::prefix('bahan_baku')->group(function() {
	    	Route::get('show', 'BahanBakuController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'BahanBakuController@index');
	    		Route::post('create', 'BahanBakuController@create');
	    		Route::get('{uuid}/edit', 'BahanBakuController@edit');
	    		Route::post('{uuid}/update', 'BahanBakuController@update');
	    		Route::delete('{uuid}/delete', 'BahanBakuController@delete');
	    	});
	    });

	    Route::prefix('legalitas_usaha')->group(function() {
	    	Route::get('show', 'LegalitasUsahaController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'LegalitasUsahaController@index');
	    		Route::post('create', 'LegalitasUsahaController@create');
	    		Route::get('{uuid}/edit', 'LegalitasUsahaController@edit');
	    		Route::post('{uuid}/update', 'LegalitasUsahaController@update');
	    		Route::delete('{uuid}/delete', 'LegalitasUsahaController@delete');
	    	});
	    });

	    Route::prefix('standarisasi_produk')->group(function() {
	    	Route::get('show', 'StandarisasiProdukController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'StandarisasiProdukController@index');
	    		Route::post('create', 'StandarisasiProdukController@create');
	    		Route::get('{uuid}/edit', 'StandarisasiProdukController@edit');
	    		Route::post('{uuid}/update', 'StandarisasiProdukController@update');
	    		Route::delete('{uuid}/delete', 'StandarisasiProdukController@delete');
	    	});
	    });

	    Route::prefix('wilayah_pemasaran')->group(function() {
	    	Route::get('show', 'WilayahPemasaranController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'WilayahPemasaranController@index');
	    		Route::post('create', 'WilayahPemasaranController@create');
	    		Route::get('{uuid}/edit', 'WilayahPemasaranController@edit');
	    		Route::post('{uuid}/update', 'WilayahPemasaranController@update');
	    		Route::delete('{uuid}/delete', 'WilayahPemasaranController@delete');
	    	});
	    });

	    Route::prefix('fas_keg_pernah')->group(function() {
	    	Route::get('show', 'FasKegPernahController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'FasKegPernahController@index');
	    		Route::post('create', 'FasKegPernahController@create');
	    		Route::get('{uuid}/edit', 'FasKegPernahController@edit');
	    		Route::post('{uuid}/update', 'FasKegPernahController@update');
	    		Route::delete('{uuid}/delete', 'FasKegPernahController@delete');
	    	});
	    });

	    Route::prefix('masalah_ukm')->group(function() {
	    	Route::get('show', 'MasalahUkmController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'MasalahUkmController@index');
	    		Route::post('create', 'MasalahUkmController@create');
	    		Route::get('{uuid}/edit', 'MasalahUkmController@edit');
	    		Route::post('{uuid}/update', 'MasalahUkmController@update');
	    		Route::delete('{uuid}/delete', 'MasalahUkmController@delete');
	    	});
	    });

			Route::prefix('notifikasi')->group(function() {
				Route::get('show', 'NotificationController@show');
				Route::get('has_read', 'NotificationController@hasRead');
				Route::get('unread', 'NotificationController@unRead');
				Route::get('count_unread', 'NotificationController@countUnRead');
				Route::post('{uuid}/read', 'NotificationController@read');
				Route::get('{uuid}/get', 'NotificationController@get');
	    	Route::group(['middleware' => ['admin.access']], function() {
	    		Route::post('index', 'NotificationController@index');
	    		Route::post('create', 'NotificationController@create');
	    		Route::post('{uuid}/resend', 'NotificationController@resend');
	    		Route::delete('{uuid}/delete', 'NotificationController@delete');
	    	});
	    });

			Route::prefix('topic')->group(function() {
				Route::get('show', 'TopicController@show');
	    	Route::group(['middleware' => ['admin.access']], function() {
					Route::post('index', 'TopicController@index');
	    		Route::post('create', 'TopicController@create');
					Route::get('{uuid}/edit', 'TopicController@edit');
					Route::post('{uuid}/update', 'TopicController@update');
	    		Route::delete('{uuid}/delete', 'TopicController@delete');
	    	});
	    });

			Route::prefix('device_id')->group(function() {
				Route::post('create', 'UserDeviceIdController@create');
	    });

	    Route::prefix('setting')->group(function() {
		    Route::group(['middleware' => ['admin.access']], function() {
					Route::get('{lang}/edit', 'SettingController@edit');
					Route::post('update', 'SettingController@update');
				});
			});

			Route::prefix('laporan')->group(function() {
				Route::group(['middleware' => ['admin.access']], function() {
					Route::prefix('peserta')->group(function () {
						Route::post('/', 'LaporanController@peserta');
						Route::post('courses', 'LaporanController@pesertaCourses');
					});
					
					Route::prefix('chart')->group(function() {
						Route::post('jenisPeserta', 'LaporanController@chartJenisPeserta');
						Route::post('genderPeserta', 'LaporanController@chartGenderPeserta');
						Route::post('lineCourses', 'LaporanController@lineChartCourses');
					});
				});
			});
	});
});