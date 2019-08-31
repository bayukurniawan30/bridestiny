<?php
    $decode = json_decode($json);

    if (property_exists($decode, 'dashboard_link')) {
        $decode->dashboard_link = $this->Url->build(['_name' => $routePrefix . 'VendorViewDetail', 'id' => $decode->vendor_id]);
  
        echo json_encode($decode, JSON_PRETTY_PRINT);
    }
    else {
        echo $json;
    }
?>