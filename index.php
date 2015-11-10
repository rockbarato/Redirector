<?php

require 'Redirector.php';

define('ANDROID_URL', 'https://play.google.com/store/apps/details?id=com.opentech.py.cep');
define('iOS_URL', 'https://itunes.apple.com/py/app/club-de-ejecutivos/id583435746');
define('OPTIONAL_URL', 'http://clubdeejecutivos.org.py/');


try {
	$redirector = new Redirector(ANDROID_URL, iOS_URL, OPTIONAL_URL);
	$redirector->distribute();
}
catch (Exception $e) {
    echo 'Excepción: ',  $e->getMessage();
}