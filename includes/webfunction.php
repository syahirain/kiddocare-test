<?php

function loginRequest(){
    $loginData = array(
        'username' => $_POST['txt_email'],
        'password' => $_POST['txt_pword']
    );

    $loginResult = logincURLRequest($loginData);

    if(isset($loginResult->Token)){
        setcookie("Token", $loginResult->Token, time() + (86400), "/"); // 86400 = 1 day
        if(isset($_POST['customCheck'])){
            setcookie("rememberUsername", $_POST['txt_email'], time() + (31536000), "/"); // 31536000 = 1 year
            setcookie("rememberPassword", $_POST['txt_pword'], time() + (31536000), "/"); // 31536000 = 1 year
        }else{
            setcookie("rememberUsername", $_POST['txt_email'], time() - 3600, "/"); // remove remember me cookie
            setcookie("rememberPassword", $_POST['txt_pword'], time() - 3600, "/"); // remove remember me cookie
        }
    }else{
        setcookie("loginError", "ERROR", time() + (86400), "/"); // 86400 = 1 day
    }

    return $loginResult;
}

function logincURLRequest($data){  
    include 'urllist.php';

    $cURLConnection = curl_init($mainURL.'api/login.php');
   
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    
    $apiResponse = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    
    // $apiResponse - available data from the API request
    $apiResponse = json_decode($apiResponse);
    
    return $apiResponse;
}

function getRequestAPI($url){
    include 'urllist.php';

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, $mainURL.$url);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

    $apiResponse = curl_exec($cURLConnection);
    curl_close($cURLConnection);

     // $apiResponse - available data from the API request
     $apiResponse = json_decode($apiResponse,true);
    
     return $apiResponse;

}