<?php
    namespace model;
    use JsonSerializable;

    class Friend implements JsonSerializable {
        private $username;
        private $status;

        public function __construct($username = null) {
            $this->username = $username;
        }

        // send user in json format to backend
        public function jsonSerialize() {
            return get_object_vars($this);
        }       
        
        public static function fromJson($data) {
            $friend = new Friend();
            foreach ($data as $key => $value) {
                $friend->{$key} = $value;
            };
            return $friend;
        }

        public function acceptFriend() {
            $this->status = "accepted";
        }

        public function dismissFriend() {
            $this->status = "dismissed";
        }

        public function getUsername() {
            return $this->username;
        }

        public function getStatus() {
            return $this->status;
        }
    }
?>