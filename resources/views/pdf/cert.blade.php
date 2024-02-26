<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CERTIFICATE OF COURSE</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	{{-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet"> --}}
	<style>
		@font-face {
		  font-family: 'Montserrat-Regular';
		  /*font-style: normal;*/
		  /*font-weight: normal;*/
		  src: url({{ storage_path('fonts/Montserrat-Regular.ttf') }}) format('truetype');
		}

		@font-face {
		  font-family: 'Montserrat-Medium';
		  /*font-style: normal;*/
		  /*font-weight: normal;*/
		  src: url({{ storage_path('fonts/Montserrat-Medium.ttf') }}) format('truetype');
		}

		@font-face {
		  font-family: 'Montserrat-Bold';
		  /*font-style: normal;*/
		  /*font-weight: normal;*/
		  src: url({{ storage_path('fonts/Montserrat-Bold.ttf') }}) format('truetype');
		}

		@font-face {
		  font-family: 'Montserrat-SemiBold';
		  /*font-style: normal;*/
		  /*font-weight: normal;*/
		  src: url({{ storage_path('fonts/Montserrat-SemiBold.ttf') }}) format('truetype');
		}

		@page { margin: 0px;}
		body { margin: 0px; text-align: center}
		.imgres {
			position: absolute;
			width: 795px;
		}
		.keikutsertaan {
			font-size: 22px;
			font-family:'Montserrat-Bold';
		  	position: absolute;
		  	left: 35%;
		  	top: 222px;
		  	color: black;
		}

		.nomor {
			font-family:'Montserrat-SemiBold';
		  	position: absolute;
		  	left: 35%;
		  	top: 290px;
		  	color: black;
		}

		.denganbangga {
			font-size: 22px;
			font-family:'Montserrat-Medium';
		  	position: absolute;
		  	left: 33%;
		  	top: 380px;
		  	color: black;
		}

		.name {
			font-size: 26px;
			font-family:'Montserrat-Bold';
		  	position: absolute;
		  	left: 20%;
		  	top: 450px;
		  	color: black;
		  	width: 600px;
		  	/*background-color: red;*/
		}
		
		.melaksanakan {
			font-size: 18px;
		  	line-height: 80%;
			font-family:'Montserrat-Medium';
		  	position: absolute;
		  	left: 28.5%;
		  	top: 510px;
		  	width: 470px;
		  	color: black;
		}

		.kotattd {
			font-size: 17px;
			font-family:'Montserrat-Medium';
		  	position: absolute;
		  	left: 63%;
		  	top: 720px;
		  	color: black;
		  	text-align: right;
		  	/*background-color: red;*/
		  	width: 260px;
		}

		.kepalattd {
			font-size: 17px;
		  	line-height: 80%;
			font-family:'Montserrat-Medium';
		  	position: absolute;
		  	left: 58%;
		  	top: 760px;
		  	color: black;
		  	text-align: center;
		  	/*background-color: red;*/
		}

		.namattd {
			font-size: 17px;
		  	line-height: 80%;
			font-family:'Montserrat-SemiBold';
		  	position: absolute;
		  	left: 54%;
		  	top: 900px;
		  	color: black;
		  	text-align: center;
		  	width: 350px;
		  	/*background-color: red;*/
		  	text-decoration: underline;
		}

		.nipttd {
			font-size: 16px;
		  	line-height: 80%;
			font-family:'Montserrat-Medium';
		  	position: absolute;
		  	left: 54%;
		  	top: 922px;
		  	color: black;
		  	text-align: center;
		  	width: 350px;
		  	/*background-color: red;*/
		}

	</style>
</head>
<body>
	<img src="{{ $image }}" class="imgres">
	<div class="keikutsertaan">KEIKUTSERTAAN / PARTISIPASI</div>
	<div class="nomor">Nomor : 895.2/DARING-{{ str_pad($courseSection->no_urut, 3, "0", STR_PAD_LEFT) }}/02/115.6/{{ AppHelper::BulanToRomawi(intval(date('m'))) }}/{{ date('Y') }}</div>
	<div class="denganbangga">Dengan bangga diberikan kepada :</div>
	<div class="name">{{ strtoupper($courseSection->User->name) }}</div>
	<div class="melaksanakan">Telah mengikuti kegiatan Webinar/Pembahasan Kursil/Modul dengan judul “<span style="font-family:'Montserrat-SemiBold';">{{ $courseSection->CourseOther->title }}</span>” yang diselenggarakan tanggal 
	{{-- \AppHelper::tgl_indo($courseSection->CourseOther->date_start) --}}
	@if(strtotime($courseSection->CourseOther->date_start) != strtotime($courseSection->CourseOther->date_end))
	{{ explode(" ", AppHelper::tanggal_indo($courseSection->CourseOther->date_start))[0] }} s.d. {{ AppHelper::tanggal_indo($courseSection->CourseOther->date_end) }}.
	@else
	{{ AppHelper::tanggal_indo($courseSection->CourseOther->date_start) }}.
	@endif
	</div>
	<div class="kotattd">Malang, {{ \AppHelper::tgl_indo(date('Y-m-d')) }}</div>
	<div class="kepalattd">Kepala UPT Pelatihan<br/>Dinas Koperasi, Usaha Kecil<br/>Menengah Provinsi Jawa Timur</div>
	<div class="namattd">IVA CHANDRANINGTYAS, S.Sos, M.AB</div>
	<div class="nipttd">NIP. 19720502 199403 2 008</div>
	{{-- <h2 class="name">{{ strtoupper($peserta->nm_peserta) }}</h2>
	<h2 class="judul">{{ strtoupper($peserta->pelatihan->judul_pelatihan) }}</h2>
	<h4 class="tempat">{{ ucwords($peserta->pelatihan->tempat_pelaksanaan) }}</h4>
	@if(strtotime($peserta->pelatihan->tgl_mulai) != strtotime($peserta->pelatihan->tgl_selesai))
	<h4 class="tanggal">Pada Tanggal {{ AppHelper::tanggal_indo($peserta->pelatihan->tgl_mulai) }} s.d. {{ AppHelper::tanggal_indo($peserta->pelatihan->tgl_selesai) }}</h4>
	@else
	<h4 class="tanggal">Pada Tanggal {{ AppHelper::tanggal_indo($peserta->pelatihan->tgl_mulai) }}</h4>
	@endif
	@if(strtotime($peserta->pelatihan->tgl_mulai) != strtotime($peserta->pelatihan->tgl_selesai))
	<div class="tanggalttd">Sidoarjo, {{ AppHelper::tanggal_indo($peserta->pelatihan->tgl_selesai) }}</div>
	@else
	<div class="tanggalttd">Sidoarjo, {{ AppHelper::tanggal_indo($peserta->pelatihan->tgl_mulai) }}</div>
	@endif
	<div class="dqrcode">{!! $qrcode !!}</div>
	<div class="namattd">Dr. MAS PURNOMO HADI, MM</div>
	<div class="jabatanttd">Pembina Utama Muda</div>
	<div class="nipttd">NIP. 19610818 198403 1 005</div> --}}
</body>
</html>