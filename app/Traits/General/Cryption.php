<?php

namespace App\Traits\General;

trait Cryption{

    public function my_encrypt($data) {
        $ciphering = "BF-CBC";

        // Use OpenSSl encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Use random_bytes() function which gives
        // randomly 16 digit values
        // echo "random_bytes <br>";
        // $encryption_iv = random_bytes($iv_length);

        $encryption_iv = hex2bin("b906e8139f100716");



        // Alternatively, we can use any 16 digit
        // characters or numeric for iv
        $encryption_key = openssl_digest(php_uname(), 'MD5', TRUE);

        // Encryption of string process starts
        $encryption = openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);

        // Display the encrypted string
        return $encryption;
    }

    public function my_decrypt($data) {
        $ciphering = "BF-CBC";

        // Use OpenSSl encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Use random_bytes() function which gives
        // randomly 16 digit values
        $encryption_iv = random_bytes($iv_length);
        $encryption_iv = hex2bin("b906e8139f100716");

        // Store the decryption key
        $decryption_key = openssl_digest(php_uname(), 'MD5', TRUE);

        // Descrypt the string
        $decryption = openssl_decrypt ($data, $ciphering, $decryption_key, $options, $encryption_iv);

        // Display the decrypted string
        return $decryption;
    }
}