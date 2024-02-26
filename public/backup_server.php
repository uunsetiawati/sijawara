<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__.'/../sijawara/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../sijawara/bootstrap/app.php';

$app->bind('path.public', function() {
 
return __DIR__;
 
});

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);



// HTACCESS

RewriteCond %{HTTPS} !=on
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

<FilesMatch "\.(?i:gif|jpe?g|png|ico)$">

  <IfModule mod_headers.c>
    Header set Cache-Control "max-age=172800, public, must-revalidate"
  </IfModule>

</FilesMatch>


// .ENV

APP_NAME="Si Jawara"
APP_ENV=production
APP_KEY=base64:ZtNoiR7oqnh6hGdKbEbZU0HKmHfilL2LeeieO1VgoDs=
APP_DEBUG=false
APP_LOG_LEVEL=debug
APP_URL=https://sijawara.diskopukm.jatimprov.go.id

WA_KEY=5c7fa8f5-7627-4302-82d5-a581f88f9d5d
WA_URL=http://whatsapp.mcflyon.co.id/api/

WA_MESSAGE="*#SIJAWARA*\n\nKode OTP Anda adalah _$OTP$_. Kode ini berlaku dalam 2 menit. RAHASIAKAN kode Anda. Abaikan Jika Anda tidak meminta kode verifikasi ini.\n\n*_Dinas UPT Pelatihan Koperasi dan UKM Provinsi Jawa Timur._*"

MIX_APP_NAME=${APP_NAME}
MIX_APP_URL=${APP_URL}

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=simppol_s1j4w4r4
DB_USERNAME=simppol_s1jawara
DB_PASSWORD=qwe123zxc456

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=send.mail.fahri@gmail.com
MAIL_PASSWORD=
MAIL_NAME="Test Mail"
MAIL_ENCRYPTION=tls

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

JWT_SECRET=kIOSK1DfKew6KiMjtdRhWAfJPnSFO2Tqp22h3aSi2Lw72b4UE41uN7dFpyZ3oWAl
JWT_TTL=10080