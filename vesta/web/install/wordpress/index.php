<?php
//AUTOMATIC WORDPRESS INSTALLER by Maskoid

error_reporting(NULL);
ob_start();
$TAB = 'WordPress';

// Main include
include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Check user
if ($_SESSION['user'] != 'admin') {
    header('Location: /list/user');
    exit;
}

// Check POST request
if (!empty($_POST['ok'])) {

    // Check token
    if ((!isset($_POST['token'])) || ($_SESSION['token'] != $_POST['token'])) {
        header('location: /login/');
        exit();
    }

    // Check empty fields
    if (empty($_POST['v_domain'])) $errors[] = __('domain');
    if (empty($_POST['v_path'])) $errors[] = __('install_path');
    if (empty($_POST['v_admin_user'])) $errors[] = __('username');
    if (empty($_POST['v_admin_passwd'])) $errors[] = __('password');
    if (empty($_POST['v_blog_title'])) $errors[] = __('blog title');
    if (empty($_POST['v_admin_email'])) $errors[] = __('admin email');
    if (empty($_POST['v_admin_fname'])) $errors[] = __('first name');
    if (empty($_POST['v_admin_lname'])) $errors[] = __('lastname');
    if (empty($_POST['v_http'])) $errors[] = __('http/https');
    if (empty($_POST['v_send_email'])) $errors[] = __('send email');
    if (!empty($errors[0])) {
        foreach ($errors as $i => $error) {
            if ( $i == 0 ) {
                $error_msg = $error;
            } else {
                $error_msg = $error_msg.", ".$error;
            }
        }
        $_SESSION['error_msg'] = __('Field "%s" can not be blank.',$error_msg);
    }

    // Validate email
    if ((!empty($_POST['v_admin_email'])) && (empty($_SESSION['error_msg']))) {
        if (!filter_var($_POST['v_admin_email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_msg'] = __('Please enter valid Admin email address.');
        }
    }

    if ((!empty($_POST['v_send_email'])) && (empty($_SESSION['error_msg']))) {
        if (!filter_var($_POST['v_send_email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_msg'] = __('Please enter valid email address to send login details.');
        }
    }

    // Check password length
    if (empty($_SESSION['error_msg'])) {
        $pw_len = strlen($_POST['v_admin_passwd']);
        if ($pw_len < 6 ) $_SESSION['error_msg'] = __('Password is too short.',$error_msg);
    }

    // Protect input
    $v_database = escapeshellarg($_POST['v_database']);
    $v_dbuser = escapeshellarg($_POST['v_dbuser']);
    $v_type = $_POST['v_type'];
    $v_charset = $_POST['v_charset'];
    $v_host = $_POST['v_host'];
    $v_db_email = $_POST['v_db_email'];


    // Install WordPress

    if (empty($_SESSION['error_msg'])) {
        // assign input to variable
        $domain = escapeshellarg($_POST['v_domain']);
        $path = escapeshellarg($_POST['v_path']);
        $admin_user = escapeshellarg($_POST['v_admin_user']);
        $admin_passwd = escapeshellarg($_POST['v_admin_passwd']);
        $admin_email = escapeshellarg($_POST['v_admin_email']);
        $blog_title = escapeshellarg($_POST['v_blog_title']);
        $fname = escapeshellarg($_POST['v_admin_fname']);
        $lname = escapeshellarg($_POST['v_admin_lname']);
        $https = escapeshellarg($_POST['v_http']);
        $www = escapeshellarg($_POST['v_www']);
        $send_email = escapeshellarg($_POST['v_send_email']);
        
        if ($_POST['v_www'] == 'www')
        {
            $www=$www.".";
            $blog_url = $https."://".$www.$domain.$path;
        } else {
            $blog_url = $https."://".$domain.$path;
        }
        /*

        exec (VESTA_CMD."v-add-database ".$user." ".$v_database." ".$v_dbuser." ".$v_password." ".$v_type." ".$v_host." ".$v_charset, $output, $return_var);
        check_return_code($return_var,$output);
        unset($output);
        unlink($v_password);
        */
        
        exec (VESTA_CMD."v-install-wordpress ".$user." ".$domain." ".$path." ".$admin_user." ".$admin_passwd." ".$admin_email." ".$blog_title." ".$fname." ".$lname." ".$https." ".$www." ".$blog_url, $output, $return_var);
       
        echo "<pre>"; 
            if ($ret == 0) {                // check status code. if successful 
                foreach ($output as $line) {  // process array line by line 
                    echo "$line \n"; 
                } 
            } else { 
                echo "Error in command";    // if unsuccessful display error 
            } 
        echo "</pre>"; 

        check_return_code($return_var,$output);
        unset($output);
        unlink($v_password);

        $_SESSION['ok_msg'] = __('WordPress Installed-SUCCESS');
        $_SESSION['ok_msg'] .= " / <a href=".$blog_url." target='_blank'>" . __('open %s',$blog_title) . "</a>";
 
    }




/*
    // Add database
    if (empty($_SESSION['error_msg'])) {
        $v_type = escapeshellarg($_POST['v_type']);
        $v_charset = escapeshellarg($_POST['v_charset']);
        $v_host = escapeshellarg($_POST['v_host']);
        $v_password = tempnam("/tmp","vst");
        $fp = fopen($v_password, "w");
        fwrite($fp, $_POST['v_password']."\n");
        fclose($fp);
        exec (VESTA_CMD."v-add-database ".$user." ".$v_database." ".$v_dbuser." ".$v_password." ".$v_type." ".$v_host." ".$v_charset, $output, $return_var);
        check_return_code($return_var,$output);
        unset($output);
        unlink($v_password);
        $v_password = escapeshellarg($_POST['v_password']);
        $v_type = $_POST['v_type'];
        $v_host = $_POST['v_host'];
        $v_charset = $_POST['v_charset'];
    }


    // Email login credentials
    if ((!empty($v_db_email)) && (empty($_SESSION['error_msg']))) {
        $to = $v_db_email;
        $subject = __("Database Credentials");
        $hostname = exec('hostname');
        $from = __('MAIL_FROM',$hostname);
        $mailtext = __('DATABASE_READY',$user."_".$_POST['v_database'],$user."_".$_POST['v_dbuser'],$_POST['v_password'],$db_admin_link);
        send_email($to, $subject, $mailtext, $from);
    }

    // Flush field values on success
    if (empty($_SESSION['error_msg'])) {
        $_SESSION['ok_msg'] = __('WordPress Installed-SUCCESS');
        $_SESSION['ok_msg'] .= " / <a href=".$domain." target='_blank'>" . __('open %s',$db_admin) . "</a>";
        unset($v_database);
        unset($v_dbuser);
        unset($v_password);
        unset($v_type);
        unset($v_charset);
    }
*/

    // Flush field values on success
    if (empty($_SESSION['error_msg'])) {
        unset($v_database);
        unset($v_dbuser);
        unset($v_password);
        unset($v_type);
        unset($v_charset);
    }
}

















// Get user list of domains
exec (VESTA_CMD."v-list-web-domains $user json", $output, $return_var);
$data = json_decode(implode('', $output), true);
$data = array_reverse($data,true);


// Render page
render_page($user, $TAB, 'install_wp');


// Back uri
$_SESSION['back'] = $_SERVER['REQUEST_URI'];
