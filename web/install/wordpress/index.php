<?php
//Install WordPress
//
// Main include

error_reporting(NULL);

ob_start();
$TAB = 'InstallWP';

include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Check user
if ($_SESSION['user'] != 'admin') {
    header('Location: /list/user');
    exit;
}

/*
exec (VESTA_CMD . "v-list-user ".$user." json", $outputi, $return_vari);
$datai = json_decode(implode('', $outputi), true);
$dati = array_reverse($datao,true);
$email=$dati["$user"]['CONTACT'];
print_r($email);*/

exec (VESTA_CMD."v-list-web-domains $user json", $output, $return_var);
$data = json_decode(implode('', $output), true);
$data = array_reverse($data,true);



// Render page
render_page($user, $TAB, 'install_wp');

// Back uri
$_SESSION['back'] = $_SERVER['REQUEST_URI'];