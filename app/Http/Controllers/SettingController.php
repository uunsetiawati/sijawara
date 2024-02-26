<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Validator, DB;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function show(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            $lang = [];
            if(isset($request->hl)) {
                $lang = ['lang' => $request->hl];
            }
            $config = Setting::where($lang)->first(['name', 'background', 'logo_dark', 'logo_white', 'description', 'lang']);

            return response()->json([
                'status' => true,
                'data' => $config
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => '404 Not Found.'
            ], 404);
        }
    }

    public function edit($lang)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $config = Setting::where('lang', $lang)->first();

            if (!isset($config)) {
                $config = Setting::first();
                
                $config->name = '';
                $config->description = '';
                $config->lang = $lang;
            }

            return response()->json([
                'status' => true,
                'data' => $config
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => '404 Not Found.'
            ], 404);
        }
    }

    public function update(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {

            $rules = [
                'name' => 'required|string',
                'description' => 'required|string',
                'lang' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status'=> false,
                    'message' => $validator->messages()->first()
                ], 500);
            }
            
            $config = Setting::where('lang', $request->lang)->first();
            if (isset($config)) {
                $config->update($request->only('name', 'description'));
            }else{
                $firstImage = Setting::first();
                $config = Setting::create([
                    'name'          => $request->name,
                    'description'   => $request->description,
                    'background'    => $firstImage->background,
                    'logo_dark'     => $firstImage->logo_dark,
                    'logo_white'    => $firstImage->logo_white,
                    'lang'          => $request->lang,
                ]);
            }

            if(isset(request()->background_file)){
                $rules = [
                    'background_file' => 'required|mimes:jpg,png,jpeg|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return response()->json([
                        'status'=> false,
                        'message' => $validator->messages()->first()
                    ], 500);
                }

                if(is_file(public_path('images/background/').$config->background)){
                    unlink(public_path('images/background/').$config->background);
                }
                $name = 'BACKGROUND_'.time().'.'.request()->background_file->getClientOriginalExtension();
                request()->background_file->move(public_path('images/background'), $name);
                $request['background'] = $name;
            }

            if(isset(request()->logo_dark_file)){
                $rules = [
                    'logo_dark_file' => 'required|mimes:jpg,png,jpeg|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return response()->json([
                        'status'=> false,
                        'message' => $validator->messages()->first()
                    ], 500);
                }

                if(is_file(public_path('images/logo/').$config->logo_dark)){
                    unlink(public_path('images/logo/').$config->logo_dark);
                }
                $name = 'LOGO_DARK_'.time().'.'.request()->logo_dark_file->getClientOriginalExtension();
                request()->logo_dark_file->move(public_path('images/logo'), $name);
                $request['logo_dark'] = $name;
            }

            if(isset(request()->logo_white_file)){
                $rules = [
                    'logo_white_file' => 'required|mimes:jpg,png,jpeg|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return response()->json([
                        'status'=> false,
                        'message' => $validator->messages()->first()
                    ], 500);
                }

                if(is_file(public_path('images/logo/').$config->logo_white)){
                    unlink(public_path('images/logo/').$config->logo_white);
                }
                $name = 'LOGO_WHITE_'.time().'.'.request()->logo_white_file->getClientOriginalExtension();
                request()->logo_white_file->move(public_path('images/logo'), $name);
                $request['logo_white'] = $name;
            }

            // $config->update($request->all());
            $imagesName = $request->only('background', 'logo_dark', 'logo_white');
            if (count($imagesName) > 0) {
                DB::table('settings')->update($imagesName);
            }

            return response()->json([
                'status' => true,
                'data' => $config
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => '404 Not Found.'
            ], 404);
        }
    }
}
