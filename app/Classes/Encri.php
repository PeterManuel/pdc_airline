<?php
    
    namespace App\Classes;
    
    Class Encri{

        public function encriptar($valor){

            return bin2hex(openssl_encrypt($valor, 'aes-256-cbc', 'hVvSElNjoH4xwKlOZAPVC71Tz629MYec', OPENSSL_RAW_DATA, '5H5hd8GUp9hoxFMF'));
        }

        public function desencriptar($valor_encriptado){

            //verificar se a has é valida
            if(strlen($valor_encriptado)%2 != 0){
                return null;
            }

            return openssl_decrypt(hex2bin($valor_encriptado), 'aes-256-cbc', 'hVvSElNjoH4xwKlOZAPVC71Tz629MYec', OPENSSL_RAW_DATA, '5H5hd8GUp9hoxFMF' );
        }
    }