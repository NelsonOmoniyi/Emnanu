<?php
// error_reporting(-1);
// ini_set('display_errors', 'On');
// set_error_handler("var_dump");
// ini_set("mail.log", "/tmp/mail.log");
// ini_set("mail.add_x_header", TRUE);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$dbobject = new dbobject();
Class Message extends dbobject{

   
    public function save_message($data){

         $validation = $this->validate($data,
         array(
             'fullname'=>'required',
             'email'=>'required',
             'phone'=>'required',
             'message'=>'required',
         ),
         array('email'=>'Email Address','phone'=>'Phone Number','message'=>'Message', 'fullname'=>'Full Name')
        );
        if(!$validation['error'])
        {

            $name = $data["fullname"];
            $email = $data["email"];
            $phone = $data["phone"];
            $message = preg_replace('/[^A-Za-z0-9\-]/', ' ',$data["message"]);
            $date = date('Y-m-d H:i:s');

             $sql = "INSERT INTO message (fullname, email, phone, message, date) values ('$name', '$email', '$phone', '$message', '$date')";
         
            $mess = $this->db_query($sql, false);
               
            if ($mess > 0) {
               // $sql = "SELECT email FROM userdata WHERE role_id = '001'";
               // $exec = $this->db_query($sql);
               return json_encode(array("response_code"=>"200", "response_message"=>"Message Sent Successfully!"));
              
               // $mail = new PHPMailer();

               // include_once("libs/dbfunctions.php");
               // include_once("class/fee.php");
               // $fee = new fee();

               // $dbobject = new dbobject();

             
               // try { 

               //    $mail->SMTPDebug = 0;                                       
               //    $mail->isSMTP();                                            
               //    $mail->Host       = 'mail.ruachr.com';                    
               //    $mail->SMTPAuth   = true;                             
               //    $mail->Username   = 'info@ruachr.com';                 
               //    $mail->Password   = 'Zenith2208Admi';                        
               //    $mail->SMTPSecure = 'ssl';                              
               //    $mail->Port       = 465;  
               
               //    $mail->setFrom($email, 'Fee Payment Test');           
               //    $mail->addAddress('omoniyinelson6@yahoo.com');
               //    //$mail->addAddress('receiver2@gfg.com', 'Name');
               //    $mail->Priority = 1;
               //    $mail->AddCustomHeader("X-MSMail-Priority: High");
               //    $mail->WordWrap = 50;
               //    $mail->isHTML(true);                                  
               //    $mail->Subject = 'Fee Payment';
               //    $mail->Body    = 'Hello, this is nelson';
               //    $mail->AltBody = 'Body in plain text for non-HTML mail clients';
               //    $mail->send();
               //    // var_dump($mail);
               //    // exit;
               //    return json_encode(array("response_code"=>"200", "response_message"=>"Message Sent Successfully!", "details"=> $mail));
               // } catch (Exception $e) {
               //    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
               // return json_encode(array("response_code"=>"201", "response_message"=>"Message Not Sent, Try Again Later! {$mail->ErrorInfo}"));

                  
               // }
            }else{
               return json_encode(array("response_code"=>"201", "response_message"=>"Message Not Sent, Try Again Later!"));

            }
            //    return json_encode(array("response_code"=>"200", "response_message"=>"Message Sent Successfully!"));
            // }else{
            //    return json_encode(array("response_code"=>"201", "response_message"=>"Message Not Sent, Try Again Later!"));
            // }
         }else
         {
             return json_encode(array("response_code"=>20,"response_message"=>$validation['messages'][0]));
         }
    }

    public function message_list($data){
      $table_name    = "messages";
		$primary_key   = "id";
		$columner = array(
			array( 'db' => 'id', 'dt' => 0 ),
			array( 'db' => 'fullname', 'dt' => 1 ),
			array( 'db' => 'email',  'dt' => 2 ),
			array( 'db' => 'phone', 'dt' => 3),
         array( 'db' => 'message', 'dt' => 4 ),
         array( 'db' => 'date',  'dt' => 5),
			);
		$filter = "";
//		$filter = " AND role_id='001'";
		$datatableEngine = new engine();
	
		echo $datatableEngine->generic_table($data,$table_name,$columner,$filter,$primary_key);
    }
}


?>