<?php
namespace utils;

use utils\HttpClient;

class BackendService {
    private $url;       // backend url
    private $id;        // my collection id

    public function __construct($url, $id) {
        $this->url = $url;
        $this->id = $id;
    }

    public function login($username, $password) {
        try {
            $result = HttpClient::post($this->url . "/" . $this->id . "/login", 
                array("username" => $username, "password" => $password));
            echo "login ok<br>";
            return true;
        } catch(\Exception $e) {
            echo "login error: " . $e . "<br>";
            return false;
        }
    }

    public function register($username, $password) {
        try {
            $result = HttpClient::post($this->url . "/" . $this->id . "/register", 
                array("username" => $username, "password" => $password));
            //echo "Token: " . $result->token;
            $_SESSION['token'] = $result->token; // save for subsequent calls
            return true;
        } catch(\Exception $e) {
            echo "register error: " . $e . "<br>";
            return false;
        }
    }
}

?>