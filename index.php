<?php

require 'Redirector.php';

define('ANDROID_URL', 'https://play.google.com/store/apps/details?id=com.android.chrome&hl=es_419');
define('iOS_URL', 'https://itunes.apple.com/us/app/chrome-web-browser-by-google/id535886823?mt=8');
define('OPTIONAL_URL', 'https://www.google.com/chrome/');


try {
	$redirector = new Redirector(ANDROID_URL, iOS_URL, OPTIONAL_URL);
	$redirector->distribute();
}
catch (Exception $e) {
    echo 'Excepción: ',  $e->getMessage();
}