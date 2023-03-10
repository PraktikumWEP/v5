<?php
    require("start.php");

    // form
    $username = "";
    $password = "";
    $password_repeat = "";
    if (isset($_POST["username"]) && isset($_POST["password1"]) && isset($_POST["password2"])) {

        // constants
        define("MIN_PASSWORD_LENGTH", 8);
        define("MIN_USERNAME_LENGTH", 3);

        // data from form
        $username = $_POST["username"];
        $password = $_POST["password1"];
        $password_repeat = $_POST["password2"];

        // trim
        $username = trim($username);
        $password = trim($password);
        $password_repeat = trim($password_repeat);

        // booleans
        $username_OK = false;
        $password1_OK = false;
        $password2_OK = false;

        // check username
        if ((strlen($username) >= MIN_USERNAME_LENGTH) && !($service->userExists($username))) {
            $username_OK = true;
        }

        // check password
        if (strlen($password) >= MIN_PASSWORD_LENGTH) {
            $password1_OK = true;
        }

        // check password repeat
        if ($password == $password_repeat) {
            $password2_OK = true;
        }

        // send if OK
        if ($username_OK && $password1_OK && $password2_OK && $service->register($username, $password)) {
            $_SESSION["user"] = $username;
            header("Location: friendlist.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex,nofollow">
        <meta name="author" content="David Linhardt & Steven Burger">
        <meta name="copyright" content="David Linhardt & Steven Burger">
        
        <title>Register</title>
        <meta name="description" content="description">

        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/components.css">

    </head>    
    <body>
        <div class="background centerRow">
            <div class="register max-width centerRowV card">
                <form method="POST" action="register.php" id="registerForm" class="centerRowV" name="registerForm">
                    <div class="register-image">
                        <img src="./assets/images/user.png" alt="user" class="image">
                    </div>

                    <div class="register-text mElementM">
                        <h1>
                            Register yourself
                        </h1>
                    </div>
                    <fieldset class="register-inputs pContainerS mElement">
                        <legend class="register-inputs-text">Register</legend>
                        <div class="name-box mElementM">
                            <div class="mElement">
                                <label class="label-name" for="name">Username </label>
                            </div>
                            <div class="mElement">
                                <input class="input" id="username" type="text" placeholder="Username" name="username" required>
                            </div>
                            <div class="mElement hasSmall">
                                <small class="error-message"></small>
                            </div>
                        </div>
                        <div class="pass-box mElementM">
                            <div class="mElement">
                                <label class="label-pass" for="password">Password </label>
                            </div>
                            <div class="mElement">
                                <input class="input" id="password1" type="password" placeholder="Password" name="password1" required>
                            </div>
                            <div class="mElement hasSmall">
                                <small class="error-message"></small>
                            </div>
                        </div>
                        <div class="pass-repeat-box mElementM">
                            <div class="mElement">
                                <label class="label-pass-repeat" for="password-repeat">Confirm Password </label>
                            </div>
                            <div class="mElement">
                                <input class="input" id="password2" type="password" placeholder="Confirm Password" name="password2" required>
                            </div>
                            <div class="mElement hasSmall">
                                <small class="error-message"></small>
                            </div>
                        </div>
                    </fieldset>

                    <div class="button-box mElement pContainerS">
                        <a href="login.php">
                            <button type="button" class="button-cancel button mElement">Cancel</button>
                        </a>
                        <button type="submit" class="button-create button mElement">Create Account</button>
                    </div>
                </form>
            </div>   
        </div>
        <script type="text/javascript">
            chatCollectionId = "<?= CHAT_SERVER_ID ?>";
            chatServer = "<?= CHAT_SERVER_URL ?>";
        </script>
        <script type="module" src="./assets/js/validate.js"></script>
    </body>
</html>