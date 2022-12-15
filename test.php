<?php
    require("start.php");
    
    $user = new model\User("Test");
    $json = json_encode($user);
    echo $json . "<br>";
    $jsonObject = json_decode($json);
    $newUser = model\User::fromJson($jsonObject);
    var_dump($newUser);

    echo "TEST TEST";
    $service = new utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    var_dump($service->test());

    echo "LOGIN TEST";
    var_dump($service->login("steven", "12345678"));
    var_dump($_SESSION);

    echo "REGISTER TEST";
    var_dump($service->register("steven", "12345678"));
    var_dump($_SESSION);
?>