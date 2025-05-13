<?php
    // TODO:Datos a Cifrar
    $data = "T3cn0logistic4.#$/GC";
    // TODO: clave de cifrado (asegurte de usar una clave segura en un entorno real)
    $key = "mi_key_secret";
    // TODO: Metodo de Cifrado
    $cipher = "aes-256-cbc";

    // TODO: Vector de inicializacion (IV) necesario para el cifrado
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    // TODO: cifrado
    $cifrado = openssl_encrypt($data, $cipher, $key,OPENSSL_RAW_DATA, $iv);
    // TODO: descifrado
    $descifrado = openssl_decrypt($cifrado, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    
    echo "Texto cifrado: " . base64_encode($cifrado);
    echo "Texto descifrado: " . $descifrado;
?>