<?php

class EncryptionManager {
    private $encryption_key;
    private $cipher = 'AES-256-CBC';
    private $iv_length;

    public function __construct($key) {
        $this->encryption_key = $key;
        $this->iv_length = openssl_cipher_iv_length($this->cipher); 
    }

    // Encrypt the data
    public function encrypt($data) {
        $iv = openssl_random_pseudo_bytes($this->iv_length); 
        $encrypted_data = openssl_encrypt($data, $this->cipher, $this->encryption_key, 0, $iv);
        return base64_encode($iv . $encrypted_data);
    }

    // Decrypt the data
    public function decrypt($encrypted_data) {
        $encoded_data = base64_decode($encrypted_data);
        $iv = substr($encoded_data, 0, $this->iv_length); 
        $ciphertext = substr($encoded_data, $this->iv_length);  
        return openssl_decrypt($ciphertext, $this->cipher, $this->encryption_key, 0, $iv);
    }
}
