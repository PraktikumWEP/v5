<?php
    require("start.php");

    if(isset($_SESSION["user"])) {
        header("Location: friendlist.php");
        exit();
    }

    // form
    $username = "";
    $password = "";
    $error = "";
    if(isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if($service->login($username, $password)) {
            header("Location: friendlist.php");
        }
        else {
            $error = "Authentication failed";
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
        
        <title>Login</title>
        <meta name="description" content="description">

        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/components.css">
    </head>
    <body>
        <form class="background centerRow" action="login.php" method="POST">
            <div class="max-width centerRowV card">
                <img src="assets/images/chat.png" class="image"></img>
                <div class="mElementM">
                    <h1>
                        Please sign in
                    </h1>
                </div>
                
                <div class="mElement">
                    <fieldset class="login-inputs pContainerS">
                        <legend>Login</legend>
                        <div class="mElementM">
                            <div class="mElement">
                                <label>Username</label>
                            </div>
                            <div class="mElement">
                                <input type="text" placeholder="Username" class="input" name="username" value="<?= $username ?>" required></input>
                            </div>
                        </div>
                        <div class="mElementM">
                            <div class="mElement">
                                <label>Password</label>
                            </div>
                            <div class="mElement">
                                <input type="password" placeholder="Password" class="input" name="password" value="<?= $password ?>" required></input>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="centerRow"><small class="error-message"><?= $error ?></small></div>

                <div class="button-box mElement pContainerS">
                    <a href="friendlist.php">
                        <button type="submit" class="button mElement">
                            Login
                        </button>
                    </a>
                    <a href="register.php">
                        <button type="button" class="button mElement">
                            Register
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </body>
</html>