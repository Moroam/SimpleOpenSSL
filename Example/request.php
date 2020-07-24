<?php
ob_start("ob_gzhandler");
header('Content-type: text/html; charset="utf-8"');

require_once 'simple-openssl.class.php';

error_reporting(E_ALL);
if(ini_set('display_errors', 1)===false)
  echo "ERROR INI SET";

?>
<form method="post">
  <label>Name</label>
  <input type="text" name="name">
  <input type="submit" name="send">
</form>
<?php

if(!isset($_POST['send'])) goto end;

$url = "your_url/getdata.php";

$arr = ['name' => $_POST['name'] ];
var_dump($arr);
echo "<br>";

$data = json_encode($arr);

$S = new SimpleOpenSSL('your_key.csr');
$post_data['data'] = $S->encrypt($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);

$err = curl_error($ch);
if (!empty($err)) echo  "<h1>$err</h1>";

curl_close($ch);

if (substr($output, 0, 5) != 'Error') {
  var_dump( json_decode($output) );
  echo "<br>";

  $dctext = $S->decrypt(trim($output));
  $arr = json_decode($dctext);
  echo "<pre>"; var_dump($arr); echo '</pre><br>received '.mb_strlen($dctext).' B';
} else {
  echo $output;
}

end:
ob_end_flush();
