<?php
error_reporting(1);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends CI_Controller {

    public $menu;

    function __construct() {
        parent::__construct();
      
      
     
     
        $this->load->model('Cron_model');
        
   

      
    }


   public function send_mail_cronjob() {
    $CI = &get_instance();
    $this->load->library('email');
    $get_emails = $CI->Cron_model->get_email_scheduled();
 
  
         foreach ($get_emails as $email_data) {
        $subject = "Reminder: " . $email_data->title . " Update";
        $message = $email_data->title." Update for Invoice Number ".$email_data->invoice_no.": Expected Date : " . $email_data->start;
    if (!empty($get_emails) && isset($email_data->email_id)) {
        $to = $email_data->email_id;
        $name = $todaysql[0]->company_name;
      
         $stm_user = "suryakala@amoriotech.com";
        $stm_pass = "Amorio@2022";
        $domain_name = "mail.amoriotech.com";
        $protocol = "smtp";
        $EMAIL_ADDRESS = $mail_set[0]->smtp_user;
        $DOMAIN = substr(strrchr($EMAIL_ADDRESS, "@"), 1);
        if(strtolower($DOMAIN) === 'gmail.com'){
            $config = array(
              'protocol' => $protocol,
              'smtp_host' => $domain_name,
              'smtp_user' => $stm_user,
              'smtp_pass' => $stm_pass,
              'smtp_port' => 465,
              'smtp_timeout' => 30,
              'charset' => 'utf-8',
              'newline' => '\r\n',
              'mailtype' => 'html',
            );
        }else{
            $config = array(
              'protocol' => $protocol,
              'smtp_host' => 'ssl://' . $domain_name,
              'smtp_user' => $stm_user,
              'smtp_pass' => $stm_pass,
              'smtp_port' => 465,
              'smtp_timeout' => 30,
              'charset' => 'utf-8',
              'newline' => '\r\n',
              'mailtype' => 'html',
              'validate' => true,
            );
        }

            $this->email->initialize($config);
            $this->email->from($to);
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);

            if ($this->email->send()) {
                echo "Email sent successfully";
            }  else {
                echo $this->email->print_debugger();
            }
    }
}

}
  
}
?>