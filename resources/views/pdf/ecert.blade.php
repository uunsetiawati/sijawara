<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>E-CERTIFICATE OF COURSE</title>
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
		  font-family: 'Freesans-Bold';
		  /*font-style: normal;*/
		  /*font-weight: normal;*/
		  src: url({{ storage_path('fonts/freesansbold.ttf') }}) format('truetype');
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
			margin-top: 7px;
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
		  	left: 45%;
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
			font-family:'FreeSans-Bold';
		  	position: absolute;
		  	left: 12%;
		  	top: 480px;
		  	color: black;
		  	width: 600px;
		  	/*text-decoration: underline;*/
		  	/*background-color: red;*/
		}
		
		.melaksanakan {
			font-size: 18px;
		  	line-height: 80%;
			font-family:'Montserrat-Medium';
		  	position: absolute;
		  	left: 20%;
		  	top: 550px;
		  	width: 470px;
		  	color: black;
		}

		.kotattd {
			font-size: 18px;
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
			font-size: 18px;
		  	line-height: 80%;
			font-family:'Montserrat-Medium';
		  	position: absolute;
		  	left: 57%;
		  	top: 760px;
		  	color: black;
		  	text-align: center;
		  	/*background-color: red;*/
		}

		.namattd {
			font-size: 18px;
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
	<div class="name">{{ strtoupper($courseSection->User->name) }}</div>
	<div class="melaksanakan">Telah mengikuti kegiatan Webinar/Pembahasan Kursil/Modul dengan judul “<span style="font-family:'Montserrat-SemiBold';">{{ $courseSection->Course->nm_course }}</span>”.</div>
</body>
</html>