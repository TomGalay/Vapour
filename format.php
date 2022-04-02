<?php

function formatDate($val){
    $date = date_create($val);
    return date_format($date,"M-d-Y");;
}

function formatPrice($val){
    return "P".number_format($val,2,'.',',');
}

?>