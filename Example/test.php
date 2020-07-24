<?php
require_once 'simple-openssl.class.php';

error_reporting(E_ALL);
if(ini_set('display_errors', 1)===false)
  echo "ERROR INI SET";


$loc_pub = getcwd() . '/your_key.csr';
$loc_pr = getcwd() . '/your_key.key';

$P = new SimpleOpenSSL($loc_pub);
$Pr = new SimpleOpenSSL($loc_pr, 'private');

$encrypted = $P->encrypt('Миру мир!!!');
echo $encrypted . "<br>";
echo $Pr->decrypt($encrypted) . "<br><br>";

$encrypted = $Pr->encrypt('Cogĭto, ergo sum.');
echo $encrypted . "<br>";
echo $P->decrypt($encrypted);
