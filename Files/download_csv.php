<?php

    $file = fopen("data.csv", "w");
    
    foreach($postData->children() as $post) {
        $line = "";
        foreach($post->children() as $item) {
            $line = $line.$item;
        }
        
        fputcsv($file, explode(',', $line));
    }
?>