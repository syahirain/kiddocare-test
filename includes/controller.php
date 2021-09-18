<?php
include 'webfunction.php';

if ($_POST['formtype'] == "aSBTRwc3ty83bnn0"){

    $result = loginRequest();

    // var_dump($result);
    
    header("Location: /");

}