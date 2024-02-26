<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="/">
		<meta charset="utf-8" />
		<title>{{ $config->name }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="{{ str_replace('&nbsp;', ' ', strip_tags($config->description)) }}">
		<meta name="keywords" content="{{ $config->name }}">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="title" content="{{ $config->name }}">
		<link name="gfont" rel="stylesheet" href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/themes/layout/header/base/light.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/themes/layout/header/menu/light.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/themes/layout/brand/light.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/themes/layout/aside/light.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/animated.min.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.png') }}" />
		<meta name="twitter:card" content="summary">
		<meta name="twitter:description" content="{{ str_replace('&nbsp;', ' ', strip_tags($config->description)) }}">
		<meta name="twitter:title" content="{{ $config->name }}">
		<meta name="twitter:image" content="{{ asset('assets/media/logos/favicon.png') }}">
	</head>
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable footer-fixed page-loading">
		<div id="app"></div>
		<div id="kt_scrolltop" class="scrolltop">
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
			</span>
		</div>
@php
$preload = [];
@endphp
@foreach(glob(public_path('jsc/*js')) as $file)
@php
	$preload[] = '"'.str_random(6).base64_encode(str_replace(public_path('/'), '', $file)).'"';
@endphp
@endforeach
		@yield('script')
		<script>var HOST_URL = "{{ url('/') }}";</script>
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins","pc": [{!! implode(', ', ((isset($preload[0])) ? $preload : [])) !!}] };
		
		if(document.location.pathname == '/callback/oauth' || document.location.pathname == '/login' || document.location.pathname == '/register' || document.location.pathname == '/recover' || document.is_404){
        }else if(localStorage.getItem('authToken')) {
        }else{
            document.location.href = 'landing';
        }
		</script>

		<script src="{{ asset('assets/plugins/global/plugins.bundle.js?v=7.0.5') }}"></script>
		<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.5') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js?v=7.0.5') }}"></script>
		<script src="{{ asset('js/app.bundle.js?v=7.0.5') }}"></script>
		<div id="core"></div>
		<div id="script"></div>
	</body>
</html>
