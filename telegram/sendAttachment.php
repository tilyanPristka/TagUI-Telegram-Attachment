<?php
/* SERVICE API SCRIPT FOR TAGUI TELEGRAM BOT ~ https://github.com/kelaberetiv/TagUI/issues/1073 */

// grab chat_id from chat_id parameter
$chat_id = $_GET['chat_id'];

// grab message from text parameter
$message = $_GET['text'];

// grab attachments from doc parameter
$attachments = $_GET['docs'];

// error handling on validating parameters
if ($chat_id == "")
    die("ERROR - chat_id parameter is not provided");
else if (!is_numeric($chat_id))
    die("ERROR - chat_id parameter must be a number");
else if ($message == "")
    die("ERROR - text parameter is not provided");

// set to local timezone for date time stamp in log file
// see list - https://www.php.net/manual/en/timezones.php
date_default_timezone_set('Asia/Jakarta');

// log chat_id and message length to prevent abuse
// $log_entry = "[" . date('d-m-Y H:i:s') . "][" . $chat_id . "][" . strval(strlen($message)) . "]\n";

// log at existing folder outside of public access
// file_put_contents("../../telegram/sendMessage.log", $log_entry, FILE_APPEND);


define("TELE_TOKEN", "YOUR_TELEGRAM_TOKEN");

function sendTeleDoc($chat_id, $message, $attachment){
  $method	= "sendDocument";
  $doc_path = "../storage/".$attachment;
  $url    = "https://api.telegram.org/bot" . TELE_TOKEN . "/". $method . "?chat_id=" . $chat_id;
  return curlTeleDoc($url, $message, $doc_path);
}
function curlTeleDoc($url, $message, $doc_path){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  $finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $doc_path);
  $cFile = new CURLFile($doc_path, $finfo);
  curl_setopt($ch, CURLOPT_POSTFIELDS, [
    "document" => $cFile,
    'caption' => $message
  ]);
  $result = curl_exec($ch);
  curl_close($ch);
  
  return json_encode($result, true);
}

$blank_message = "";
if($attachments != ""){
  $attachments = explode(',', $attachments);
  $jkl = 0;
  foreach($attachments as $attachment){
    if($attachment != ""){
      if($jkl != count($attachments)-2) sendTeleDoc($chat_id, $blank_message, urldecode($attachment));
      else echo sendTeleDoc($chat_id, $message, urldecode($attachment));
    }
    
    // unlink($attachment); // so as not to overload the storage server
    $jkl++;
  }
} else {
  $url = "https://api.telegram.org/bot".TELE_TOKEN;
  echo file_get_contents($url."/sendmessage?chat_id=".$chat_id."&text=$message");
}
?>
