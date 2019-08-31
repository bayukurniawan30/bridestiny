<?php
    $decode = json_decode($json);

    if (property_exists($decode, 'categories') && $decode->categories != NULL) {
        foreach ($decode->categories as $category) {
            if ($category->image == NULL || $category->image == '') {
                $category->image = NULL;
            }
            else {
                $category->image = $baseUrl . 'uploads/images/original/' . $category->image;
            }
        }

        echo json_encode($decode, JSON_PRETTY_PRINT);
    }
    else {
        echo $json;
    }
?>