<html>
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }}</title>
  <script>
    window.opener.postMessage({ otp: "{{ $otp }}", email: "{{ $email }}", name: "{{ $name }}", type: "oauth" },"{{ url('/') }}")
    window.close()
  </script>
</head>
<body>
</body>
</html>