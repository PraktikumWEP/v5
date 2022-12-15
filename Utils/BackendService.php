<?php
namespace utils;

use utils\HttpClient;
use model\User;
use model\Friend;

class BackendService {
    private $url;       // backend url
    private $id;        // my collection id

    public function __construct($url, $id) {
        $this->url = $url;
        $this->id = $id;
    }

    public function test() {
        try {
            return HttpClient::get($this->url . '/test.json');
        } catch(\Exception $e) {
            error_log($e);
        }
            return false;
    }

    public function login($username, $password) {
        try {
            $result = HttpClient::post($this->url . "/" . $this->id . "/login", 
                array("username" => $username, "password" => $password));
            $_SESSION["chat_token"] = $result->token;
            return true;
        } catch(\Exception $e) {
            echo "<br>login error: " . $e . "<br>";
            return false;
        }
    }

    public function register($username, $password) {
        try {
            $result = HttpClient::post($this->url . "/" . $this->id . "/register", 
                array("username" => $username, "password" => $password));
            $_SESSION['chat_token'] = $result->token;
            return true;
        } catch(\Exception $e) {
            echo "<br>register error: " . $e . "<br>";
            return false;
        }
    }

    public function loadUser($username) {
        try {
            $result = HttpClient::get($this->url . "/" . $this->id . "/user" . "/$username", $_SESSION["chat_token"]);
            $user = User::fromJson($result); // method gets php object, $result already unpacked php object -> why is it called fromJson ???????🤡
            return $user;
        } catch(\Exception $e) {
            echo "<br>load user error: " . $e . "<br>";
            return null;
        }
    }   

    public function saveUser($user) {
        try {
            $result = HttpClient::post($this->url . "/" . $this->id . "/user", $user, $_SESSION["chat_token"]);
            return $result;
        } catch (\Exception $e) {
            echo "<br>save user error: " . $e . "<br>";
            return false;
        }
    }

    public function loadFriends() {
        try {
            $result = HttpClient::get($this->url . "/" . $this->id . "/friend", $_SESSION["chat_token"]);
            $friends = array();
            foreach($result as $value) {
                $friends[] = Friend::fromJson($value);
            }
            return $friends;
        } catch(\Exception $e) {
            echo "<br>load friends error: " . $e . "<br>";
            return false;
        }
    }

    public function friendRequest($friend) {
        try {
            HttpClient::post($this->url . "/" . $this->id . "/friend", $friend ,$_SESSION["chat_token"]);
            return true;
        } catch(\Exception $e) {
            echo "<br>load friends error: " . $e . "<br>";
            return false;
        }
    }
}
?>