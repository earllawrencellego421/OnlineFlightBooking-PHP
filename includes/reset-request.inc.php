<?php

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['reset-req-submit'])) {

    require '../helpers/init_conn_db.php';   
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    // Build the reset link from the actual current host/path instead of a
    // hardcoded URL, so it works on localhost, staging, or production
    // without editing this file each time.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    // This file lives in includes/, so its parent folder is the project root
    // where create-new-pwd.php actually is.
    $project_root = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/');
    $base_url = $protocol . '://' . $host . $project_root;
    $url = $base_url . '/create-new-pwd.php?selector=' . $selector . '&validator=' . bin2hex($token);

    $expires = date('U')+1800;
    $user_email = $_POST['user_email'];
    if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)) {
        header('Location: ../reset-pwd.php?err=invalidemail');    
        exit();
    }    
    $sql = 'DELETE FROM PwdReset WHERE pwd_reset_email=?;';
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) { 
        header('Location: ../reset-pwd.php?err=sqlerr');    
        exit();            
    } else {
        mysqli_stmt_bind_param($stmt,'s',$user_email);            
        mysqli_stmt_execute($stmt);
    }     
    $sql = 'INSERT INTO PwdReset (pwd_reset_email,pwd_reset_selector,pwd_reset_token,
    pwd_reset_expires) VALUES (?,?,?,?);';
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        header('Location: ../reset-pwd.php?err=sqlerr');     
        exit();            
    } else {
        $token_hash = password_hash($token,PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt,'ssss',$user_email,$selector,$token_hash,$expires);            
        mysqli_stmt_execute($stmt);
    } 

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    require_once "../vendor/autoload.php";
    include '../vendor/phpmailer/phpmailer/src/Exception.php';
    include '../vendor/phpmailer/phpmailer/src/PHPMailer.php';  
    try {     
        $mail = new PHPMailer(true);        
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        // TODO: set your real Gmail address + a Gmail "App Password"
        // (not your normal Gmail password — Google blocks that for SMTP).
        // Generate one at: https://myaccount.google.com/apppasswords
        $mail->Username   = "your_username";
        $mail->Password   = "your_password";
        $mail->IsHTML(true);
        $mail->SetFrom('test@gmail.com');
        $mail->AddAddress($user_email);    
        $mail->Subject = "Reset password request for Earlines";
        $content = "
            <p>We receieved a password reset request, ignore if you did not issue a request</p> 
        ";
        $content .= '<p>Your password reset link:</br>';
        $content .='<a href="'.$url.'">'.$url.'</a></p>';                 

        $mail->MsgHTML($content); 
        $mail->Send();
        header('Location: ../reset-pwd.php?mail=success');       
    } 
    catch(Exception $e) {        
        header('Location: ../reset-pwd.php?err=mailerr');      
    }
   
} else {
    header('Location: ../reset-pwd.php?');    
}