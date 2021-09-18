<?php

if(isset($_POST['username']) && isset($_POST['password'])){

    $fn = fopen("../users.txt","r");
  
    while(! feof($fn))  {
        $result = fgets($fn);
        $data = (explode("|",$result));
        
        if ($_POST['username'] == trim($data[0]) && $_POST['password'] == trim($data[1])){
            $token = substr(md5(rand()), 0, 7);
            break;
        }
    }

    if(isset($token)){
        echo json_encode(array( 'Token' => $token));
    }else{
        echo json_encode(array( 'Error' => 'Error'));
    }

    fclose($fn);

}else{
    echo json_encode(array( 'Error' => 'Error data not found'));
}
