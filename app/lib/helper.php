<?php


namespace MVC\LIB;


use MVC\Models\PHPMailer;
use MVC\Models\SMTP;
use MVC\Models\Exception;

trait Helper
{
    public $key = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';

    public function redirect($page){
        session_write_close();
        header('Location: '.$page);
        exit();
    }

    function enc($data) {
        $enc_key = base64_decode($this->key);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $enc_data = openssl_encrypt($data, 'aes-256-cbc', $enc_key, 0, $iv);
        return base64_encode($enc_data . '::' . $iv);
    }


    function dec($data){
        $enc_key = base64_decode($this->key);

        list($enc_data, $iv) = array_pad(explode('::', base64_decode($data), 2),2,null);
        $dec = openssl_decrypt($enc_data, 'aes-256-cbc', $enc_key, 0, $iv);

        return $dec;
    }

    function smtpmailer($to, $from, $from_name, $subject, $body) {
        global $error;
        $mail = new PHPMailer();  // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true;  // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = GUSER;
        $mail->Password = GPWD;
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->isHTML(TRUE);
        $mail->Body = $body;
        $mail->AltBody = 'There is a great disturbance in the Force.';
        foreach ($to as $item){
            $mail->AddAddress($item);
        }
        if(!$mail->Send()) {
            $error = 'Mail error: '.$mail->ErrorInfo;
            return false;
        } else {
            $error = 'Message sent!';
            return true;
        }
    }

    public function randText($num = 10){
        $arr =  str_split(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), $num);
        return $arr[rand(0,count($arr)-2)];
    }
}