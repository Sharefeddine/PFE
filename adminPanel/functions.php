<?php
function getDateBefore70Years(){
$currentDate = new DateTime();
$currentDate->modify('-70 years');
return $currentDate->format('Y-m-d');
}
function generateRandomCode() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    $characterCount = strlen($characters);
    for ($i = 0; $i < 16; $i++) $code .= $characters[random_int(0, $characterCount - 1)];
    return $code;
}
?>