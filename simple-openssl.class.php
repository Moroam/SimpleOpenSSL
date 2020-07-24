<?php
class SimpleOpenSSL{
  protected $key = null;
  protected $type = '';

  protected $ENCRYPT_BLOCK_SIZE = 200;// this for 2048 bit key for example, leaving some room
  protected $DECRYPT_BLOCK_SIZE = 256;// this again for 2048 bit key

  public function __construct(string $key_file, string $type = 'public'){
    if ($type !== 'public' && $type !== 'private'){
      throw new Exception("Error: Invalid key type");
    }
    $this->type = $type;

    if (!(file_exists($key_file) && is_readable($key_file))) {
      throw new Exception("Error: Failed loading $type key file");
    }

    $func = $type == 'public' ? 'openssl_csr_get_public_key' : 'openssl_pkey_get_private';
    $this->key =$func(file_get_contents($key_file))
      or die("Error: Couldn't get the $type key");
  }

  public function encrypt(string $data) : string {
    $encrypted = '';
    $enc = 'openssl_' . $this->type . '_encrypt';

    $data = str_split(gzcompress($data, 9), $this->ENCRYPT_BLOCK_SIZE);
    foreach($data as $chunk) {
      $enc($chunk, $partEnc, $this->key, OPENSSL_PKCS1_PADDING) or die("Error: Failed to encrypt data the $this->type key");
      $encrypted .= $partEnc;
    }
    return base64_encode($encrypted);
  }

  public function decrypt(string $data) : string {
    $decrypted = '';
    $dec = 'openssl_' . $this->type . '_decrypt';

    $data = str_split(base64_decode($data), $this->DECRYPT_BLOCK_SIZE);
    foreach($data as $chunk) {
      $dec($chunk, $partDec, $this->key, OPENSSL_PKCS1_PADDING) or die("Error: Failed to decrypt data the $this->type key");
      $decrypted .= $partDec;
    }

    return gzuncompress($decrypted);
  }

}
