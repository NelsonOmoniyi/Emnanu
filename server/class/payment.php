<?php 

class Payment extends dbobject
{
    private $logger;
    function __construct()
    {
        $this->logger = '../Logs/Exceptions/';
        $this->logger .= date('Y').'/';
        $this->logger .= date('F').'/';
        if (!file_exists($this->logger))
        {
            mkdir($this->logger, 0777, true);
        }
        parent::__construct();
    }
    public function process_payment($data){

        // var_dump($data);
        // exit;
        $validation = $this->validate($data,
        array(
            'name'=>'required',
            'email'=>'email',
            'mobile'=>'required',
            'amount'=>'required'
        ),
        array('name'=>'Name', 'email'=>'Email Address','mobile'=>'Phone Number', 'amount'=>'Amount')
       );

       if (!$validation['error']) {
            // var_dump($data);
            // exit;
           
            $name = $data['name'];
            $mobile = $data['mobile'];
            $amount = $data['amount'];
            $email = $data['email'];


            // var_dump($data);
            // exit;
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.paystack.co/transaction/initialize',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "email": "'.$email.'",
                "amount": "'.$amount.'",
                "callback_url": "http://localhost/emnanu/thanks.php"
            }',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                
                'Cookie: __cf_bm=j3Kg8vZzoMxuN9TCvHIklZdpmWdWhVK.N5wcv37PI7s-1710871926-1.0.1.1-5JV4MOJ3Rt7aJsyiNCxlD9E6BELDdNbnMx0powgKshmX_snrksJwHY6A7P1MuL4JEXb.N32wEodrxLPOw7lFmw; sails.sid=s%3AvrmAldVsW_nrKqmN_Ysh01_9Mc742024.wMY1ECaZuHL9ThpRM8H%2FWz00AlKuzwMWJYWK1mAbX1s'
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;

            file_put_contents($this->logger.'API Response'.date('ymd').'.txt',"Logged at ".date('Y-m-d H:i:s')."\r\n".$response."\r\n".PHP_EOL,FILE_APPEND);
            // return false;
            $data = json_decode(json_encode($response), true);
            $arr = json_decode($data);
            $info = (array) $arr;
            
            $message = $info['message'];
            $status = $info['status'];
            $info1 = (array) $info['data'];
            
            $auth_url = $info1['authorization_url'];
            $ref_id = $info1['reference'];
            $access_code = $info1['access_code'];

            $date = date('Y-m-d H:i:s');
            if (!$response) {
              return json_encode(array("response_code"=>201,"response_message"=>'Error! Please check your internet connection and try Again Later.'));
            }else{
              $sql = "INSERT INTO transactions (ref_id, access_code, name, email, mobile, amount, status, date, message) values ('$ref_id', '$access_code', '$name', '$email', '$mobile', '$amount', '$status', '$date', '$message')";
         
              $res = $this->db_query($sql, false);
              if ($res > 0 ) {
                return json_encode(array("response_code"=>200, "response_message"=>'Success! Please Wait!', "redirect"=>$auth_url));
              }else{
                return json_encode(array("response_code"=>202,"response_message"=>'Error! Please try Again Later.'));
              }
            }
       }else{
            return json_encode(array("response_code"=>20,"response_message"=>$validation['messages'][0]));
       }
    }

    public function trans_record($data){
      $table_name    = "transactions";
      $primary_key   = "ref_id";
      $columner = array(
        array( 'db' => 'ref_id', 'dt' => 0 ),
        array( 'db' => 'name', 'dt' => 1 ),
        array( 'db' => 'email',  'dt' => 2 ),
        array( 'db' => 'mobile', 'dt' => 3),
        array( 'db' => 'amount', 'dt' => 4 ),
        array( 'db' => 'status',  'dt' => 5, 'formatter'=>function($d,$row){
          if ($d == 1) {
            return 'Success';
          }else if ($d == 0) {
            return 'Pending';
          }else{
            return 'Failed';
          }
        }),
        array( 'db' => 'date', 'dt' => 6 )
        
			);
		$filter = "";
//		$filter = " AND role_id='001'";
		$datatableEngine = new engine();
	
		echo $datatableEngine->generic_table($data,$table_name,$columner,$filter,$primary_key);
    }
}

?>