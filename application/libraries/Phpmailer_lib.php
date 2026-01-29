<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'third_party/PHPMailer/PHPMailerAutoload.php';

class Phpmailer_lib
{
    private $ci;
    private $mail;
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->mail = new PHPMailer;
    }

    public function load()
    {
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.office365.com';//'smtp.gmail.com';////'windhans.in'; // Change this to your SMTP server
        // $this->mail->Host = 'windhans.in'; // Change this to your SMTP server
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'info@encongroup.co.in'; // Change this to your SMTP username
        $this->mail->Password = 'wmnvpbvbpkfpfjkn';//Windhans@#23'; // Change this to your SMTP password
        // $this->mail->Username = 'info@windhans.in'; // Change this to your SMTP username
        // $this->mail->Password = 'Yk%lA!U]AG+P'; // Change this to your SMTP password
        // $this->mail->Username = 'procurement@encongroup.in'; // Change this to your SMTP username
        // $this->mail->Password = 'encon123#'; // Change this to your SMTP password
        $this->mail->SMTPSecure = 'tls'; // Change this to 'ssl' if needed
        $this->mail->Port = 587; // Change this to your SMTP port
        //$this->mail->SMTPDebug = 3;
        $this->mail->isHTML(true);
        $this->mail->Timeout = 20;
        return $this->mail;
    }
}