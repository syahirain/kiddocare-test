<?php

if(!isset($_COOKIE['Token'])){
    include 'includes/login.php';
}else{
    include 'includes/main.php';
}