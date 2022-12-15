<?php
    spl_autoload_register(function($class) {
        include str_replace('\\', '/', $class) . '.php';
    });

    session_start();

    define('CHAT_SERVER_URL', 'https://online-lectures-cs.thi.de/chat');
    define('CHAT_SERVER_ID', 'f286aee2-128a-4e99-a839-4e07d87550eb');

    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
?>