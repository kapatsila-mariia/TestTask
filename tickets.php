<?php
  class MyClass {
    public $x;
    public $responses;
	public $api_key; 
	
public $password;
public $url;

    
    public function __construct($api_key,$password,$url) {
	  $ch = curl_init($url);

curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
$info = curl_getinfo($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($server_output, 0, $header_size);
$response = substr($server_output, $header_size);

if($info['http_code'] == 200) {
   
$this->responses=$response;
	
} else {
    if($info['http_code'] == 404) {
        echo "Error, Please check the end point \n";
    } else {
        echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
        echo "Headers are ".$headers;
        echo "Response are ".$response;
    }
	
}


curl_close($ch);
    }
    function sum() {
      $sum = 2;
      return $sum;
    }
    
	function makeCsv() {
		$res=json_decode($this->responses);
	$key = "Ticket ID; Group ID; ID; Agent; Status;Priority; Contact Name; Agent Name; Description \n";
	$file = fopen('tickets.csv', 'a');
	fwrite($file,$key);
	
foreach ($res as $r){ 
$str= $r->{'display_id'}.";".$r->{'group_id'}.";".$r->{'id'}.";".$r->{'responder_id'}.";".$r->{'status_name'}.";".$r->{'priority_name'}.";".$r->{'requester_name'}.";".$r->{'responder_name'}.";\" ".$r->{'description'}." \" ; \n";
fwrite($file, $str);
echo $str;

echo "<br>";};

	fclose($file);
      
    }
	
	public function getResponse(){
            return $this->responses;
        }
	
  }
 $api_key = "4PpDhZCFGCM2qhOnueor";
 $password = "13ajhntgsfyj13";
 $url = "https://newaccount1608230400089.freshdesk.com/helpdesk/tickets.json";

  $work=New MyClass($api_key,$password,$url,$response);
  $work->makeCsv();
?>