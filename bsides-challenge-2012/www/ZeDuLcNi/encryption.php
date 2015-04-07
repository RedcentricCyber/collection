<?php
    // encryption functions used for login
    function encrypt($value, $key){
       if(!$value){return false;}
       $text = $value;
       $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
       $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
       $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
       return trim(base64_encode($ciphertext)); //encode for db
    }

    function decrypt($value, $key){
       if(!$value){return false;}
       $ciphertext = base64_decode($value); //decode cookie
       $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
       $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
       $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $ciphertext, MCRYPT_MODE_ECB, $iv);
       return trim($decrypttext);
    }
?>
