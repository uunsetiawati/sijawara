<?php

namespace App\Helpers;

use Auth;
use LogicException;
use App\Models\Notification;
use App\Models\Topic;
use DOMDocument;

class AppHelper
{

	static function encrypt($string="")
	{
		$key = md5(str_random(32));
		$enc = openssl_encrypt($string, "AES-128-ECB", $key);
		return $key.$enc;
	}

	static function decrypt($string="")
	{
		$key = substr($string, 0, 32);
		$string = str_replace($key, '', $string);
		$dec = openssl_decrypt($string, "AES-128-ECB", $key);
		return $dec;
	}

	static function readMore($string="", $length=100)
	{
		if (strlen($string) <= $length) {
			return $string;
		}else{
			if(substr($string, $length-1, 1) == ' '){
				return substr($string, 0, $length-1).'...';
			}
			return substr($string, 0, $length).'...';
		}
	}

	static function generateOTP($n) { 
	    $generator = "1357902468";
	    $result = ""; 
	  
	    for ($i = 1; $i <= $n; $i++) { 
	        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
	    }
	    
	    return $result; 
	}

	static function isValidUrl($url){

        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*
        (:[0-9]+)?(/.*)?$|i', $url);
    }

	static function randomColor($awal='rgb(', $akhir=')')
	{
		$rgbColor = [];

		foreach(array('r', 'g', 'b') as $color){
			$rgbColor[$color] = mt_rand(0, 255);
		}

		return $awal.implode(",", $rgbColor).$akhir;
	}

	static function cached_asset($path, $bustQuery = false)
	{
        $realPath = public_path($path);
        if ( ! file_exists($realPath)) {
            throw new LogicException("File not found at [{$realPath}]");
        }
        $timestamp = filemtime($realPath);

        if ( ! $bustQuery) {
            $extension = pathinfo($realPath, PATHINFO_EXTENSION);
            $stripped = substr($path, 0, -(strlen($extension) + 1));
            $path = implode('.', array($stripped, $timestamp, $extension));
        } else {
            $path  .= '?' . $timestamp;
        }
        return asset($path);
    }

	static function BulanToRomawi($date)
	{
		$array_bln = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bln = $array_bln[$date];
		return $bln;
	}

    static function tanggal_indo($tanggal, $cetak_hari = false)
	{
		$hari = array ( 1 =>    'Senin',
					'Selasa',
					'Rabu',
					'Kamis',
					'Jumat',
					'Sabtu',
					'Minggu'
				);
				
		$bulan = array (1 =>   'Januari',
					'Februari',
					'Maret',
					'April',
					'Mei',
					'Juni',
					'Juli',
					'Agustus',
					'September',
					'Oktober',
					'November',
					'Desember'
				);
		$split 	  = explode('-', $tanggal);
		$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
		
		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $hari[$num] . ', ' . $tgl_indo;
		}
		return $tgl_indo;
	}

	static function tgl_indo($tgl){
     	$tanggal = substr($tgl,8,2);
     	switch (substr($tgl,5,2)){
					case '01': 
						$bulan= "Januari";
						break;
					case '02':
						$bulan= "Februari";
						break;
					case '03':
						$bulan= "Maret";
						break;
					case '04':
						$bulan= "April";
						break;
					case '05':
						$bulan= "Mei";
						break;
					case '06':
						$bulan= "Juni";
						break;
					case '07':
						$bulan= "Juli";
						break;
					case '08':
						$bulan= "Agustus";
						break;
					case '09':
						$bulan= "September";
						break;
					case '10':
						$bulan= "Oktober";
						break;
					case '11':
						$bulan= "November";
						break;
					case '12':
						$bulan= "Desember";
						break;
				}
		
		$tahun = substr($tgl,0,4);
		if (!isset($tanggal) || !isset($bulan) || !isset($tahun)) {
			return "";
		}
		return $tanggal.' '.$bulan.' '.$tahun;
     }

	static function hari_indo($tanggal)
	{
		$hari = array ( 1 =>    'Senin',
					'Selasa',
					'Rabu',
					'Kamis',
					'Jumat',
					'Sabtu',
					'Minggu'
				);
		$num = date('N', strtotime($tanggal));
		return $hari[$num];
	}

	static function tanpa_tahun($tanggal, $cetak_hari = false)
	{
		$hari = array ( 1 =>    'Senin',
					'Selasa',
					'Rabu',
					'Kamis',
					'Jumat',
					'Sabtu',
					'Minggu'
				);
				
		$bulan = array (1 =>   'Januari',
					'Februari',
					'Maret',
					'April',
					'Mei',
					'Juni',
					'Juli',
					'Agustus',
					'September',
					'Oktober',
					'November',
					'Desember'
				);
		$split 	  = explode('-', $tanggal);
		$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ];
		
		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $hari[$num] . ', ' . $tgl_indo;
		}
		return $tgl_indo;
	}

    static function TglToText($tgl)
    {
    	$split 	  = explode('-', $tgl);
    	$bulan = array (1 =>   'Januari',
					'Februari',
					'Maret',
					'April',
					'Mei',
					'Juni',
					'Juli',
					'Agustus',
					'September',
					'Oktober',
					'November',
					'Desember'
				);
    	$hari = self::hari_indo($tgl);
		$tgl_indo = self::AngkaToText($split[2]);
		$bulan = $bulan[(int)$split[1]];
		$tahun = self::AngkaToText($split[0]);
		return ucfirst($hari)." tanggal ".ucwords($tgl_indo)." bulan ".ucfirst($bulan)." tahun ". ucwords($tahun);

    }

    static function AngkaToText($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = "". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = self::AngkaToText($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = self::AngkaToText($nilai/10)." puluh ". self::AngkaToText($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus " . self::AngkaToText($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = self::AngkaToText($nilai/100) . " ratus " . self::AngkaToText($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu " . self::AngkaToText($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = self::AngkaToText($nilai/1000) . " ribu " . self::AngkaToText($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = self::AngkaToText($nilai/1000000) . " juta " . self::AngkaToText($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = self::AngkaToText($nilai/1000000000) . " milyar " . self::AngkaToText(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = self::AngkaToText($nilai/1000000000000) . " trilyun " . self::AngkaToText(fmod($nilai,1000000000000));
		}     
		return ucwords($temp);
	}

	static function seo($s) {
	    $c = array (' ');
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
	    $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
	    $s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
	    
	    return $s;
	}

	static function filename($s) {
	    $c = array (' ');
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
	    $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
	    $s = strtoupper(str_replace($c, '_', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
	    
	    return $s;
	}

	static function generateRandomToken()
	{
		return self::generateRandomCharHex(8).'-'.self::generateRandomCharHex(4).'-'.self::generateRandomCharHex(4).'-'.self::generateRandomCharHex(4).'-'.self::generateRandomCharHex(12);
	}

	static function generateRandomCharHex($a) {
		$char = 'ABCDEF1234567890';
		$str = '';

		for ($i=0; $i < $a; $i++) { 
			$pos = rand(0, strlen($char)-1);
			$str .= $char[$pos];
		}

		return $str;
	}

	static function generateForgotToken()
	{
		$code = '';
        do {
        $code = strtolower(self::generateRandomCharHex(8).'-'.self::generateRandomCharHex(4).'-'.self::generateRandomCharHex(4).'-'.self::generateRandomCharHex(4).'-'.self::generateRandomCharHex(12));
        $cek=\DB::table('password_resets')->where('token',$code)->count();
        } while(0 < $cek);
        return $code;
	}

	static function rupiah($a, $b=0)
	{
		return "Rp. ".number_format($a,$b,',','.');
	}

	static function getInnerText($string) {
		$string = preg_replace('/<[^>]*>/', ' ', $string);
	
		$string = str_replace("\r", '', $string);
		$string = str_replace("\n", ' ', $string);
		$string = str_replace("\t", ' ', $string);
	
		$string = trim(preg_replace('/ {2,}/', ' ', $string));
		return $string;
	}

	static function sendNotif(Notification $notif, Topic $topic) {
		$headers = [
			'Authorization: key='.env('FCM_SERVER_ID'),
			'Content-Type: application/json',
		];

		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, env('FCM_URL'));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$body = [
			"data" => [
				"title" => $notif->judul,
				"body" => static::getInnerText($notif->isi),
				"click_action" => "FLUTTER_NOTIFICATION_CLICK",
				"id" => $notif->uuid,
				"onclick" => "SHOW_DETAIL"
			]
		];

		if ($notif->onclick != 'SHOW_DETAIL') {
			$body["data"]["onclick"] = $notif->onclick;
			$body["data"]["id"] = $notif->target;
		}

		if ($topic->slug == 'all') {
			$body['to'] = '/topics/all';
		} else {
			$topic = Topic::where('slug', $topic->slug)->first();
			$users = $topic->users;
			$device_ids = $users->map(function ($user) {
				return $user->device_ids->map(function ($device_id) {
					return $device_id->device_id;
				});
			})->flatten()->unique();
			$body['registration_ids'] = $device_ids;
			$body['notification_key_name'] = $topic->slug;
		}

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
					
		curl_exec($ch);
	}

	static function paginateCollection($collection, $perPage, $pageName = 'page', $fragment = null)
	{
			$currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage($pageName);
			$currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage);
			parse_str(request()->getQueryString(), $query);
			unset($query[$pageName]);
			$paginator = new \Illuminate\Pagination\LengthAwarePaginator(
					$currentPageItems,
					$collection->count(),
					$perPage,
					$currentPage,
					[
							'pageName' => $pageName,
							'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
							'query' => $query,
							'fragment' => $fragment
					]
			);
	
			return $paginator;
	}
    
}
