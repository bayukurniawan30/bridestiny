<?php
    $decode = json_decode($json);

    if (property_exists($decode, 'vendor') && $decode->vendor != NULL) {
        unset($decode->vendor->api_key);
        unset($decode->vendor->api_type);

        echo json_encode($decode, JSON_PRETTY_PRINT);
    }
    else {
        echo $json;
    }
?>