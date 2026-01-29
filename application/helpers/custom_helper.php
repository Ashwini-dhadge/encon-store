<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Upload single and multiple image
 */


if (!function_exists('myUpload')) {

    function myUpload($upload_path, $name, $multiple = true)
    {
        $ci =& get_instance();
        $config = array(
            // 'file_name' => "doc_img_" . time(),
            'allowed_types' => '*',
            'max_size' => 1000024,
            'overwrite' => FALSE,
            'upload_path' => $upload_path
        );

        $ci->load->library('upload', $config);
        $ci->upload->initialize($config);

        if (!$multiple) {
            if ($_FILES[$name]['name'] == null) {
                return array('errorf' => TRUE, 'error' => 'Please Select Image');
            }

            if (!$ci->upload->do_upload($name)) {
                return array('errorf' => TRUE, 'error' => $ci->upload->display_errors());
            } else {

                $data = $ci->upload->data();
                return array('errorf' => FALSE, 'data' => $ci->upload->data());
            }
        } else {
            $temp = array();

            if ($_FILES[$name]['name'] == null) {
                return array('errorf' => TRUE, 'error' => 'Please Select Image');
            }

            $files = $_FILES;
            // echo "<pre>";print_r($_FILES);die;
            $number_of_files_uploaded = count($_FILES[$name]['name']);

            for ($i = 0; $i < $number_of_files_uploaded; $i++) {

                $_FILES = array();
                $_FILES[$name]['name'] = $files[$name]['name'][$i];
                $_FILES[$name]['type'] = $files[$name]['type'][$i];
                $_FILES[$name]['tmp_name'] = $files[$name]['tmp_name'][$i];
                $_FILES[$name]['error'] = $files[$name]['error'][$i];
                $_FILES[$name]['size'] = $files[$name]['size'][$i];

                if (!$ci->upload->do_upload($name)) {
                    $temp = array('errorf' => TRUE, 'error' => $ci->upload->display_errors());
                    break;
                } else {
                    $temp[] = $data = $ci->upload->data();
                }
            }

            $_FILES = $files;
            if (isset($temp['errorf'])) {
                return $temp;
            } else {
                return array('errorf' => FALSE, 'data' => $temp);
            }
        }
    }

}


/**
 * Send mobile notification
 */
if (!function_exists('sendMobileNotification')) {

    function sendMobileNotification($tokenIds, $message, $title)
    {
        /*$fields = array(
            'registration_ids' => $tokenIds,
            'data' => array('message' => $message)
        );*/
        $fields = array(
            'registration_ids' => $tokenIds,
            'priority' => 10,
            'data' => array('title' => $title, 'body' =>  $message, 'id' => 1),
        );
        
        // $newF = json_encode($fields);
        
            // 'apns' => array('headers' => array('apns-expiration' => '10')),
            // 'android' => array("ttl" => "100s"),
            // 'webpush' => array('headers' => array('TTL' => '10'))

        $headers = array(
            'Authorization:key = ' . MOBILE_NOTIFICATION_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, MOBILE_NOTIFICATION_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($newF));
        $result = curl_exec($ch);
        //print_r($result);
        return $result;
    }
}

/**
 * Send email
 */
if (!function_exists('sendMailByPhpMailer')) {

    function sendMailByPhpMailer($to, $subject, $body,$attchment_path='',$cc_arry='')
    {
        // print_r($to);die;
        $ci =& get_instance();
        $mail = $ci->phpmailer_lib->load();
        $mail->setFrom('info@encongroup.co.in', 'Encon');
        $mail->addAddress($to);
        if(!empty($cc_arry)){
             foreach ($cc_arry as $cc) {
               $mail->AddCC(trim($cc));
             }
        }
        $mail->isHTML(true);
        $mail->Subject =$subject;
        $mail->Body = $body;
        if(!empty($attchment_path)){
            foreach ($attchment_path as $file_path) {
                // chmod($file_path, 0777);
                $mime_type = mime_content_type($file_path);
                $filename = trim(basename($file_path));
                $mail->addAttachment($file_path, $filename, 'base64', $mime_type);
            }
        }
        // return $ci->email->print_debugger();
        if ($mail->send()) {
            return true;
        } else {
             echo 'Mailer Error: ' . $mail->ErrorInfo;die;
            return false;
        }
    }
}
if (!function_exists('sendMailWithAttchment')) {

    function sendMailWithAttchment($from, $from_name, $to, $subject, $body,$attchment_path='',$cc_arry='')
    {
        // print_r($to);
        //  print_r($cc_arry);
        //   print_r($attchment_path);
    //   echo $_SERVER["DOCUMENT_ROOT"].'/2023/encongroup/v4/pdfs/ENCON_PO_PDF_6.pdf'.'<br>';
    //     foreach ($attchment_path as $file_path) {
    //             //  $this->email->attach($file_path);
    //             echo $file_path."<br>";
    //         }
    //       $ci->email->attach($_SERVER["DOCUMENT_ROOT"].'/2023/encongroup/v4/pdfs/ENCON_PO_PDF_6.pdf');
    //     $ci->email->attach($_SERVER["DOCUMENT_ROOT"].'/2023/encongroup/v4/pdfs/ENCON_PO_PDF_13.pdf');
    //     $ci->email->attach($_SERVER["DOCUMENT_ROOT"].'/2023/encongroup/v4/assets/uploads/additional_attchment/doc_img_1703688650.jpg');
        $ci =& get_instance();
        $ci->load->library('email');
        // $config = Array(
        //     'protocol' => 'smtp',
        //     // 'protocol' => 'sendmail',
        //     'smtp_host' => 'smtp.office365.com',
        //     'smtp_port' => 587,
        //     'smtp_user' => 'info@encongroup.co.in',
        //     'smtp_pass' => 'Windhans@#23',
        //     'mailtype' => 'html',
        //     'charset' => 'utf-8',
        //     'wordwrap' => TRUE,
            
        // );
             $config = Array(
            'protocol' => 'smtp',
            // 'protocol' => 'sendmail',
            'smtp_host' => 'windhans.in',
            'smtp_port' => 465,
            // 'smtp_crypto' => 'tls',
            // '_smtp_auth' => TRUE,
            'smtp_timeout' => 30,
            'smtp_user' => 'info@windhans.in',
            'smtp_pass' => 'Yk%lA!U]AG+P',
            /*'smtp_user' => 'info@encongroup.co.in',
            'smtp_pass' => 'Windhans@#23',*/
            /*'smtp_user' => 'ashwini@windhans.com',
            'smtp_pass' => 'Riyansh@2016',*/
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'newline'=>'\r\n',
            'smtp_debug'=>2,
            'send_multipart'=> FALSE
            /*'crlf'    => '\r\n',
            'starttls' => TRUE,
            */
            
        );
        //  $ci->email->set_header('Content-Type', 'text/html');
        // $ci->email->set_header('Content-Type', 'text/html');
        // echo json_encode($config);die;
       //  print_r($from);
       //  print_r($to);
        // print_r($attchment_path);
        // print_r($cc_arry);
          
        // $ci->email->initialize($config);
        // $ci->email->from($from, $from_name);
        // $ci->email->to($to);
        // if(!empty($cc_arry)){
        //         $this->email->cc($cc_arry);
        // }
    
        // $ci->email->subject($subject);
        // $ci->email->message($body);
        if(!empty($attchment_path)){
            foreach ($attchment_path as $file_path) {
                 chmod($file_path, 0777);
                $ci->email->attach($file_path);
            }
        }

         //    $ci->email->attach($attchment_path);
        // $ci->email->send();
        // echo $ci->email->print_debugger();
        $ci->email->initialize($config);
        $ci->email->from($from, $from_name);
        $ci->email->to($to);
        // foreach ($attchment_path as $file_path) {
        //          $ci->email->attach($file_path);
        // }
        if(!empty($cc_arry)){
                 $ci->email->cc($cc_arry);
        }
        $ci->email->subject($subject);
        $ci->email->message($body);
        // echo($ci->email->print_debugger());
        // $ci->email->print_debugger(array('headers'));die;
        if($ci->email->send()){
            return true;
        } else {
            echo($ci->email->print_debugger());die;
            return false;
        }
        // Send the email
        // if ($ci->email->send()) {
        //     echo "Email sent successfully.";
        // } else {
        //     echo($ci->email->print_debugger());
        // }
        // echo "df";
        
        //         die;
       
    }
}
if (!function_exists('sendMailWithAttchment')) {

    function sendMailWithAttchment($from, $from_name, $to, $subject, $body,$attchment_path='',$cc_arry='')
    {
        // print_r($to);
        //  print_r($cc_arry);
        //   print_r($attchment_path);
    //   echo $_SERVER["DOCUMENT_ROOT"].'/2023/encongroup/v4/pdfs/ENCON_PO_PDF_6.pdf'.'<br>';
    //     foreach ($attchment_path as $file_path) {
    //             //  $this->email->attach($file_path);
    //             echo $file_path."<br>";
    //         }
    //       $ci->email->attach($_SERVER["DOCUMENT_ROOT"].'/2023/encongroup/v4/pdfs/ENCON_PO_PDF_6.pdf');
    //     $ci->email->attach($_SERVER["DOCUMENT_ROOT"].'/2023/encongroup/v4/pdfs/ENCON_PO_PDF_13.pdf');
    //     $ci->email->attach($_SERVER["DOCUMENT_ROOT"].'/2023/encongroup/v4/assets/uploads/additional_attchment/doc_img_1703688650.jpg');
        $ci =& get_instance();
        $ci->load->library('email');
        // $config = Array(
        //     'protocol' => 'smtp',
        //     // 'protocol' => 'sendmail',
        //     'smtp_host' => 'smtp.office365.com',
        //     'smtp_port' => 587,
        //     'smtp_user' => 'info@encongroup.co.in',
        //     'smtp_pass' => 'Windhans@#23',
        //     'mailtype' => 'html',
        //     'charset' => 'utf-8',
        //     'wordwrap' => TRUE,
            
        // );
             $config = Array(
            'protocol' => 'smtp',
            // 'protocol' => 'sendmail',
            'smtp_host' => 'windhans.in',
            'smtp_port' => 465,
            // 'smtp_crypto' => 'tls',
            // '_smtp_auth' => TRUE,
            'smtp_timeout' => 30,
            'smtp_user' => 'info@windhans.in',
            'smtp_pass' => 'Yk%lA!U]AG+P',
            /*'smtp_user' => 'info@encongroup.co.in',
            'smtp_pass' => 'Windhans@#23',*/
            /*'smtp_user' => 'ashwini@windhans.com',
            'smtp_pass' => 'Riyansh@2016',*/
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'newline'=>'\r\n',
            'smtp_debug'=>2,
            'send_multipart'=> FALSE
            /*'crlf'    => '\r\n',
            'starttls' => TRUE,
            */
            
        );
        //  $ci->email->set_header('Content-Type', 'text/html');
        // $ci->email->set_header('Content-Type', 'text/html');
        // echo json_encode($config);die;
       //  print_r($from);
       //  print_r($to);
        // print_r($attchment_path);
        // print_r($cc_arry);
          
        // $ci->email->initialize($config);
        // $ci->email->from($from, $from_name);
        // $ci->email->to($to);
        // if(!empty($cc_arry)){
        //         $this->email->cc($cc_arry);
        // }
    
        // $ci->email->subject($subject);
        // $ci->email->message($body);
        if(!empty($attchment_path)){
            foreach ($attchment_path as $file_path) {
                 chmod($file_path, 0777);
                $ci->email->attach($file_path);
            }
        }

         //    $ci->email->attach($attchment_path);
        // $ci->email->send();
        // echo $ci->email->print_debugger();
        $ci->email->initialize($config);
        $ci->email->from($from, $from_name);
        $ci->email->to($to);
        // foreach ($attchment_path as $file_path) {
        //          $ci->email->attach($file_path);
        // }
        if(!empty($cc_arry)){
                 $ci->email->cc($cc_arry);
        }
        $ci->email->subject($subject);
        $ci->email->message($body);
        // echo($ci->email->print_debugger());
        // $ci->email->print_debugger(array('headers'));die;
        if($ci->email->send()){
            return true;
        } else {
            echo($ci->email->print_debugger());die;
            return false;
        }
        // Send the email
        // if ($ci->email->send()) {
        //     echo "Email sent successfully.";
        // } else {
        //     echo($ci->email->print_debugger());
        // }
        // echo "df";
        
        //         die;
       
    }
}
if (!function_exists('sendMailWithAttchment1')) {

    function sendMailWithAttchment1($from, $from_name, $to, $subject, $body,$attchment_path='',$cc_arry='')
    {
        echo"<pre>";
         print_r($attchment_path);
        $ci =& get_instance();
        $ci->load->library('email');
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'windhans.in',
            'smtp_port' => 465,
            'smtp_user' => 'info@windhans.in',
            'smtp_pass' => 'Yk%lA!U]AG+P',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'smtp_crypto'=>'ssl',
            'wordwrap' => TRUE,
        );
       
        $ci->email->initialize($config);
        $ci->email->from('info@windhans.in', 'ENCONGROUP PO');
        $ci->email->to('ashwinidhadge2709@gmail.com');
        if(!empty($cc_arry)){
                 $ci->email->cc($cc_arry);
        }
        $ci->email->subject($subject);
        $ci->email->message($body);
        foreach ($attchment_path as $file_path) {
                if (file_exists($file_path)) {
                    // Change the permissions to 777
                    chmod($file_path, 0777);
                     $ci->email->attach($file_path);
                } else {
                    echo "File does not exist: $file_path";
                }
            // $ci->email->attach($file_path);
        }
    //   $file_path = '/home/encongroup/public_html/ERP/pdfs/ENCON_PO_PDF_31.pdf';
    //     $ci->email->attach($file_path);
        if ($ci->email->send()) {
            echo 'Email sent successfully.';
        } else {
            echo 'Email sending failed.';
            echo $ci->email->print_debugger(); // Print any errors
        }
       
    }
}

/**
 * Send mobile message
 */
if (!function_exists('sendMobileMessage')) {

    function sendMobileMessage($message = '', $mobileNumber = 0)
    {
        $api_key = '25FA3EFD508EDC';
        $contacts = $mobileNumber;
        $from = 'YOJANA';
        $sms_text = urlencode($message);

        //Submit to server

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "http://kutility.in/app/smsapi/index.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&routeid=415&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }
}

/**
 * Create random string with character and number
 */
if (!function_exists('createCharNumRandom')) {

    function createCharNumRandom()
    {
        $chars = "ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
        $i = 0;
        $pass = '';

        while ($i <= 8) {
            $num = mt_rand(0, 61);
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }
}

/**
 * Create random 6 digit number
 */
if (!function_exists('create6NumRandom')) {

    function create6NumRandom()
    {
        return mt_rand(100000, 999999);
        // return '123456';
    }
}
/**
 * Create random 4 digit number
 */
if (!function_exists('create4NumRandom')) {

    function create4NumRandom()
    {
        return mt_rand(1000, 9999);
    }
}

/**
 * Create random 6 digit number
 */
if (!function_exists('createUniqueNumber')) {

    function createUniqueNumber()
    {
        $ci =& get_instance();
        $unique = mt_rand(10000, 99999);
        $result = $ci->Welcome_model->getData('tbl_users', array('unique_number' => $unique));
        if(count($result)){
            return createUniqueNumber();
        } else {
            return "NC-".$unique;
        }
    }
}

/**
 * Check : Mobile number already exists or not
 */
if (!function_exists('checkMobileIsExists')) {

    function checkMobileIsExists($Mobile = 0)
    {
        $ci =& get_instance();
        $result = $ci->Common_model->getData(DB_REGISTER, array('register_mobile' => $Mobile));
        if(count($result)){
            return $result[0];
        } else {
            return 'false';
        }
    }
}

/**
 * Check : return diff between 2 dates
 */
if (!function_exists('dateDifference')) {

    function dateDifference($date1 = '', $date2 = '')
    {
        $date1= date_create($date1);
        $date2= date_create($date2);
        $diff=date_diff($date1,$date2);
        $days = $diff->format("%a");

        if($days != 0){
            return $days;
        }else{
            return 1;
        }
    }
}

/**
 * Recent Activity
 */
if (!function_exists('activityLog')) {

    function activityLog($user_id, $desc, $type, $id, $activity_details)
    {
    	$CI = & get_instance();
    	$data = array(
					'user_id' => $user_id,
					'message' => $desc,
					'type' => $type,
					'activity_id' => $id,
					'activity_details'	  => $activity_details
    				);
    	$CI->db->insert('tbl_recent_activities',$data);
    }
}

 
 /**
 * earlyCharges
 */
if (!function_exists('earlyCharges')) {

    function earlyCharges($time,$room_charges)
    {
        $time=date('H',strtotime($time));

        if ( $time < 9) {
                $dct=$room_charges*(EARLYPER/100);
        }else{
            $dct=0;
        }
        return $dct;
    }
}

if (!function_exists('lateCheckoutCharges')) {

    function lateCheckoutCharges($room_charges)
    {
        $time=date('H');

        if ( $time < 14) {
                $dct=$room_charges*(PERBEFORE2/100);
        }else if ( $time > 15 && $time < 17  ) {
                $dct=$room_charges*(PER3TO5/100);
        }else if( $time > 17  ){
            $dct=$room_charges*(PERAFTER5/100);
        }else{
            $dct=0;
        }
        return $dct;
    }
}
 
if (!function_exists('convertNumber')) {
   function convertNumber($number){
           $no = floor($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "" . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
    if($points){
        $words_format=$result . "Rupees  " . $points . " Paise";
    }else{
         $words_format=$result . "Rupees  ";
    }
  return $words_format;
    }


    
/* Move deleted Image */
  
  if(!function_exists('imageMove')) 
    {
     function imageMove($from_path, $to_path)
        {
            $path = FCPATH.$from_path; 
            $target_path = FCPATH.$to_path;
            //echo $path.'<br>';echo $target_path;
           // die;
            $a = copy($path, $target_path); // move to file
            // echo $a;die;
            if($path){ 
                $abc = unlink($path); // remove file 
            }   
        }
    }
    
    
function fileUploadForRepeter($path,$repeter_name,$image_field_name,$multiple=false)
{
	$CI = & get_instance();
	$attach_file=array();
	
	if ($path  && $repeter_name && $image_field_name) {
	    if($_FILES){
	           
			    foreach($_FILES[$repeter_name] AS $k => $v){
            	foreach( $v AS $v2){
            		$attach_file[$k][]=$v2[$image_field_name];
            		//$cont++;
            	}
            }
	    }
	    
	   
	   
        if(! $attach_file){
            	$return ['status'] = false;
		        $return ['status'] = 'Invaild Parameters Repeteer Js!';
	            return $return;
        }
     
	    
	    $config['file_name'] = "file_" . time();
		$config['upload_path'] = './'.$path;
	    $config['allowed_types'] = '*';
	    $config['overwrite'] = FALSE;
	    $config['encrypt_name'] = FALSE;
	    $config['remove_spaces'] = TRUE;

	    $CI->load->library('upload', $config);
	    $CI->upload->initialize($config);
        
        

	
	        

		    $cpt = count($attach_file['name']);
		  
		    for($i=0; $i<$cpt; $i++)
		    {        
		        //$_FILES1 = array();
		        if(!$multiple){
		            if(!empty($attach_file['name'][$i])){
		            	$tem_path = $attach_file['name'][$i];
        	         	$new_name = time().".".pathinfo($tem_path, PATHINFO_EXTENSION);
                        $_FILES['new_file']['name'] = $new_name;
                        $_FILES['new_file']['type'] =  $attach_file['type'][$i];
                        $_FILES['new_file']['tmp_name'] = $attach_file['tmp_name'][$i];
                        $_FILES['new_file']['error'] =$attach_file['error'][$i];
                        $_FILES['new_file']['size'] = $attach_file['size'][$i];    
            	  	
        		        if(!$CI->upload->do_upload('new_file'))
        		        {
        					$return['status'] = false;
                			$return['message'] = $CI->upload->display_errors();
        				}else{
        					$uploadData = $CI->upload->data();
                			$return['status'] = true;
                			$return['message'] = 'Image uploaded!';
                			$return['image_name'][$i] = $uploadData['file_name'];
        				}
		            }else{
		                $return['image_name'][$i] = '';
		            }
		        }else{
		            $cpt1 = count($attach_file['name'][$i]);
		            
		           for($j=0; $j<$cpt1; $j++){
		               if(!empty($attach_file['name'][$i][$j])){
		                   $tem_path = $attach_file['name'][$i][$j];
		               
        	         	$new_name = time().".".pathinfo($tem_path, PATHINFO_EXTENSION);
                        $_FILES['new_file']['name'] = $new_name;
                        $_FILES['new_file']['type'] =  $attach_file['type'][$i][$j];
                        $_FILES['new_file']['tmp_name'] = $attach_file['tmp_name'][$i][$j];
                        $_FILES['new_file']['error'] =$attach_file['error'][$i][$j];
                        $_FILES['new_file']['size'] = $attach_file['size'][$i][$j];    
            	  	
        		        if(!$CI->upload->do_upload('new_file'))
        		        {
        					$return['status'] = false;
                			$return['message'] = $CI->upload->display_errors();
        				}else{
        					$uploadData = $CI->upload->data();
                			$return['status'] = true;
                			$return['message'] = 'Image uploaded!';
                			$return['image_name'][$i][$j] = $uploadData['file_name'];
        				}
		               }else{
		               
                		   $return['image_name'][$i][$j] ='';
		               }
		               	
		           }
		        }
	         
			}
		
	}else{
		$return ['status'] = false;
		$return ['status'] = 'Invaild Parameters!';
	}
	return $return;
}

}