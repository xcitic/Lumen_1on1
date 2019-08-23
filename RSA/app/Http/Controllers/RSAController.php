<?php


namespace App\Http\Controllers;

// use App\Logic\RSA;

use phpseclib\Crypt\RSA;

class RSAController extends Controller {


  private $privateKey;
  private $publicKey;


  public function index()
  {

    $rsa = new RSA();
    $keys = $rsa->createKey(4096);

    $privateKey = $keys["privatekey"];
    $publicKey = $keys["publickey"];

    $encrypted = encrypt('This is super secret. Don\'t let the NSA snoop in on this!! ', $publicKey);
    $decrypted = decrypt($encrypted, $privateKey);
    return '<strong>Encrypted text:</strong> <br> '.$encrypted .'<br><br>'.'<strong>Decrypted text:</strong> '.$decrypted;
  }


  private function encrypt($text = null, $publicKey = null) {
    if (!isset($text)) {
      return 'nothing to encrypt';
    }

    if (!isset($publicKey)) {
      return 'missing public key';
    }

    $rsa = new RSA();
    $rsa->loadKey($publicKey);

    $ciphertext = $rsa->encrypt($text);

    return $ciphertext;

  }

  private function decrypt($ciphertext = null, $privateKey = null) {
    if (!isset($ciphertext)) {
      return 'nothing to decrypt';
    }

    if (!isset($privateKey)) {
      return 'missing private key';
    }

    $rsa = new RSA();
    $rsa->loadKey($privateKey);

    $decrypted = $rsa->decrypt($ciphertext);

    return $decrypted;

  }

}
