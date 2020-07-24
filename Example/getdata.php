<?php
declare(strict_types=1);

if(!isset($_POST['data'])) return;

$input = $_POST['data'];

require_once 'simple-openssl.class.php';

$S = new SimpleOpenSSL('your_key.key', 'private');
$input = $S->decrypt($input);
$input = json_decode($input, true);

if(count($input) == 0){
  $output = 'Empty request';
} else {
  $output = "Received Name: " . $input['name'];
}

$output = json_encode($output);

echo $S->encrypt($output);
