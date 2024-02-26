<?php

namespace App\Helpers;
use Auth;
use LogicException;

class GDHelper
{
	CONST GD_KEY = "AIzaSyD739-eb6NzS_KbVJq1K8ZAxnrMfkIqPyw";

	static function googleDrive($docid){
		$support_domain = 'drive.google.com';

		$get_video_info = 'https://drive.google.com/get_video_info?docid=';

	    $result = file_get_contents($get_video_info.$docid, false, stream_context_create(['socket' => ['bindto' => '[::]:0']]));

		preg_match('/(&fmt_stream_map=)(.*)(&url_encoded_fmt_stream_map)/', $result, $matches);
		$result = urldecode($matches[2]);
		$result = preg_replace('/[^\/]+\.(drive|docs|mail)\.google\.com/', 'redirector.googlevideo.com', $result);

		$quality = [
		  '37' => ['label' => '1080p', 'type' => 'video/mp4'],
		  '22' => ['label' => '0720p', 'type' => 'video/mp4'],
		  '59' => ['label' => '0480p', 'type' => 'video/mp4'],
		  '18' => ['label' => '0360p', 'type' => 'video/mp4']
		];

		$links = explode(',', $result);
		$output = [];
		foreach($links as $direct_link) {
		  $direct_link = urldecode($direct_link);
		  preg_match('/https.*/', $direct_link, $matches);
		  $matches = preg_replace('/&driveid=.*/', '', $matches); // remove driveid
		  preg_match('/(.*)(\|)/', $direct_link, $itag);
		  if(!is_null($itag[1]) || !is_null($matches[0])) {
		    if(!is_null($quality[$itag[1]])) {
		      $output[] = ['label' => $quality[$itag[1]]['label'], 'file' => $matches[0], 'type' => $quality[$itag[1]]['type']];
		    }
		  }
		}

		rsort($output);

		$output = json_encode($output);
		$output = preg_replace('/(0)(720|480|360)(p)/', '$2$3', $output); // sort fix

		return $output;
	}

	static function getDriveId($string) {
	  if (strpos($string, "/edit")) {
	    $string = str_replace("/edit", "/view", $string);
	  } else if (strpos($string, "?id=")) {
	    $parts = parse_url($string);
	    parse_str($parts['query'], $query);
	    return $query['id'];
	  } else if (!strpos($string, "/view")) {
	    $string = $string . "/view";
	  }
	  $start  = "file/d/";
	  if(strpos($string, "/preview")){
	    $end = "/preview";
	  }elseif(strpos($string, "/view")){
	    $end = "/view";
	  }
	  $string = " " . $string;
	  $ini    = strpos($string, $start);
	  if ($ini == 0) {
	    return null;
	  }
	  $ini += strlen($start);
	  $len = strpos($string, $end, $ini) - $ini;
	  return substr($string, $ini, $len);
	}
}