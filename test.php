<?php
    require("start.php");
    use model\Friend;
    use model\User;
    
    $user = new User("Test");
    $json = json_encode($user);
    echo $json . "<br>";
    $jsonObject = json_decode($json);
    $newUser = User::fromJson($jsonObject);
    var_dump($newUser);

    echo "<br><br>";

    echo "TEST TEST";
    $service = new utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    var_dump($service->test());

    echo "<br><br>";

    echo "LOGIN TEST";
    var_dump($service->login("steven", "12345678"));
    var_dump($_SESSION);

    echo "<br><br>";

    echo "REGISTER TEST";
    var_dump($service->register("steven", "12345678"));
    var_dump($_SESSION);

    echo "<br><br>";

    echo "LOAD USER TEST";
    $user = $service->loadUser("steven");
    var_dump($user);

    echo "<br><br>";

    echo "SAVE USER TEST";
    var_dump($service->saveUser($user));
    
    echo "<br><br>";

    echo "LOAD FRIENDS TEST";
    $friends = $service->loadFriends();
    var_dump($friends);

    echo "<br><br>";

    echo "FRIEND REQUEST TEST";
    $friend = new Friend("Kek");
    var_dump($service->friendRequest($friend));

    echo "<br><br>";

    echo "FRIEND ACCEPT TEST";
    var_dump($service->friendAccept($friend));

    echo "<br><br>";

    echo "FRIEND DISMISS TEST";
    var_dump($service->friendDismiss($friend));

    echo "<br><br>";

    echo "FRIEND DISMISS TEST";
    var_dump($service->friendRemove($friend));

    echo "<br><br>";

    echo "USER EXISTS TEST";
    var_dump($service->userExists("steven"));

    echo "<br><br>";

    echo "UNREAD MESSAGES TEST";
    var_dump($service->getUnread());
?>