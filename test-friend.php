<?php
    require("start.php");
    use model\Friend;
    use model\User;

    session_unset();

    echo "LOGIN TEST";
    var_dump($service->login("1234", "12345678"));
    var_dump($_SESSION);

    echo "LOAD FRIENDS TEST";
    $friends = $service->loadFriends();
    var_dump($friends);

    $friend = new Friend("steven");
    echo "FRIEND REMOVE TEST";
    var_dump($service->friendRemove($friend));


    echo "<br><br>";echo "<br><br>";echo "<br><br>";

    session_unset();

    echo "LOGIN TEST";
    var_dump($service->login("steven", "12345678"));
    var_dump($_SESSION);

    echo "LOAD FRIENDS TEST";
    $friends = $service->loadFriends();
    var_dump($friends);

    $friend = new Friend("1234");
    echo "FRIEND REMOVE TEST";
    var_dump($service->friendRemove($friend));

    
    echo "FRIEND REQUEST TEST";
    var_dump($service->friendRequest($friend));

    echo "LOAD FRIENDS TEST";
    $friends = $service->loadFriends();
    var_dump($friends);


    echo "<br><br>";echo "<br><br>";echo "<br><br>";


    session_unset();

    
    echo "LOGIN TEST";
    var_dump($service->login("1234", "12345678"));
    var_dump($_SESSION);

    echo "LOAD FRIENDS TEST";
    $friends = $service->loadFriends();
    var_dump($friends);
?>