<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('sendmail')) {

    function sendmail($to, $subject, $content, $other = null) {
        // Temp assign to mail test
        //$to = "marysm801@gmail.com"; //nhandev1110@gmail.com
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n";
        $CI = & get_instance();
        $CI->load->library('email');
        $CI->email->set_mailtype("html");
        $CI->email->from('noreply@dezignwall.com', 'Dezignwall, Inc');
        $CI->email->to($to);
        if ($other != null && $other != '') {
            $CI->email->cc($other);
        }
//$CI->email->cc("nhandev1110@gmail.com"); 
        $CI->email->subject($subject);
        $CI->email->message($content);
        $CI->email->send();
    }

};

