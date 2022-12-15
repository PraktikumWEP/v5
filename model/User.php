<?php
    namespace model;
    use JsonSerializable;

    class User implements JsonSerializable {
        private $username;

        public function __construct($username = null) {
            $this->username = $username;
        }

        // send user in json format to backend
        public function jsonSerialize() {
            return get_object_vars($this);
        }

        // create user in json format from backend
        // $data is already processed as php object
        public static function fromJson($data) {
            $user = new User();
            foreach ($data as $key => $value) {
                $user->{$key} = $value;
            };
            return $user;
        }

        public function getUsername() {
            return $this->username;
        }
    }
?>