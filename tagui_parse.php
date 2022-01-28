function telegram_intent($raw_intent) {
$params = trim(substr($raw_intent." ",1+strpos($raw_intent." "," ")));
$param1 = trim(substr($params,0,strpos($params," "))); $param2 = trim(substr($params,1+strpos($params," ")));
if (($param1 == "") or ($param2 == ""))
echo "ERROR - " . current_line() . " chat_id/message missing for " . $raw_intent . "\n";
else {
preg_match('#\[(.*?)\]#', $param2, $doc);
$docs_name = $content =  "";
if(count($doc) > 0){
  $param2 = trim(str_replace("$doc[0] ","", $param2));
  $files = explode(',', $doc[1]);
  $url = "https://YOUR_SERVER_DOMAIN/upload_doc.php";
  
  $boundary = '--------------------------' . microtime(true);
  foreach($files as $file){
    $file = abs_file($file);
    if(file_exists($file)){
      $basename = basename($file);
      $docs_name .= urlencode($basename).",";
      
      $content .=  "--".$boundary."\r\n".
        "Content-Disposition: form-data; name=\"docs[]\"; filename=\"" . $basename . "\"\r\n" .
        "Content-Type: application/octet-stream\r\n\r\n" .
        file_get_contents($file) . "\r\n";
    }
  }
  $content .= "--".$boundary."\r\n".
    "Content-Disposition: form-data; name=\"secret\"\r\n\r\n".
    "YOURSECRETHERE\r\n";
  $content .= "--".$boundary."--\r\n";
  $context = stream_context_create([
    'http' => [
      'method' => 'POST',
      'header' => "Content-Type: multipart/form-data; boundary=" . $boundary,
      'content' => $content,
    ]
  ]);
  file_get_contents($url, false, $context);
  
  return "casper.then(function() {"."{techo('".$raw_intent."');\ntelegram_result = ''; // 'api http' to allow API calls\n".
  "telegram_chat_id = encodeURIComponent('". $param1 ."');\n".
  "telegram_message = encodeURIComponent('". $param2 ."');\n".
  "telegram_docs = encodeURIComponent('". $docs_name ."');\n".
  "telegram_result = call_api(telegram_endpoint+'/sendAttachment.php?chat_id='+telegram_chat_id+'&text='+telegram_message+'&docs='+telegram_docs);\n".
  "try {telegram_json = JSON.parse(telegram_result); telegram_result = 'fail';\n".
  "if (telegram_json.ok) telegram_result = 'success';}\n"."catch(e) {telegram_result = 'fail';}}".end_fi()."});"."\n\n";
} else
return "casper.then(function() {"."{techo('".$raw_intent."');\ntelegram_result = ''; // 'api http' to allow API calls\n".
"telegram_chat_id = encodeURIComponent('". $param1 ."');\n"."telegram_message = encodeURIComponent('". $param2 ."');\n".
"telegram_result = call_api(telegram_endpoint+'/sendMessage.php?chat_id='+telegram_chat_id+'&text='+telegram_message);\n".
"try {telegram_json = JSON.parse(telegram_result); telegram_result = 'fail';\n".
"if (telegram_json.ok) telegram_result = 'success';}\n"."catch(e) {telegram_result = 'fail';}}".end_fi()."});"."\n\n";}}
