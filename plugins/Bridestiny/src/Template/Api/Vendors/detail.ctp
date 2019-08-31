<?php
    $decode = json_decode($json);

    if (property_exists($decode, 'vendor') && $decode->vendor != NULL) {
        $vendor = $decode->vendor;
        
        if ($vendor->photo == NULL || $vendor->photo == '') {
            $vendor->photo = NULL;
        }
        else {
            $vendor->photo = $baseUrl . 'uploads/images/original/' . $vendor->photo;
        }

        if ($vendor->banner == NULL || $vendor->banner == '') {
            $vendor->banner = NULL;
        }
        else {
            $vendor->banner = $baseUrl . 'uploads/images/original/' . $vendor->banner;
        }

        if ($vendor->ktp != NULL) {
            $vendor->ktp = $baseUrl . 'uploads/images/original/' . $vendor->ktp;
        }

        if ($vendor->npwp != NULL) {
            $vendor->npwp = $baseUrl . 'uploads/images/original/' . $vendor->npwp;
        }

        unset($vendor->api_key_plain);
        unset($vendor->api_key);
        unset($vendor->api_type);

        echo json_encode($decode, JSON_PRETTY_PRINT);
    }
    else {
        echo $json;
    }
?>