<?php

Route::get('/certificate/{type}/{course_uuid}/{section_uuid}/download', function($type, $course_uuid, $section_uuid) {
	$types = ['course', 'online', 'offline'];
	if(!in_array($type, $types)) {
		abort(404);
		return;
	}

	return App::call('App\Http\Controllers\CertificateController@'.$type.'Download', [$course_uuid, $section_uuid]);
});

Route::prefix('oauth')->group(function () {
	Route::get('{provider}', 'OauthController@redirect');
	Route::get('{provider}/callback', 'OauthController@callback');
});

Route::get('/callback/oauth', function() {
	$config = \App\Models\Setting::first();
	return view('app', compact('config'));
});

Route::get('/landing', function() {
	$config = \App\Models\Setting::first();
	return view('landing', ['config' => $config]);
})->where('any', '^(?!api\/)[\/\w\.-]*');

Route::get('/landing/{any}', function() {
	$config = \App\Models\Setting::first();
	return view('landing', ['config' => $config]);
})->where('any', '^(?!api\/)[\/\w\.-]*');


Route::get('/{any}', function() {
	$config = \App\Models\Setting::first();
	return view('app', compact('config'));
})->where('any', '^(?!api\/)[\/\w\.-]*');