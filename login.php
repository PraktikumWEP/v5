<?php
    require("start.php");
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
        <div class="background centerRow">
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
                                <input type="text" placeholder="Username" class="input" required></input>
                            </div>
                        </div>
                        <div class="mElementM">
                            <div class="mElement">
                                <label>Password</label>
                            </div>
                            <div class="mElement">
                                <input type="password" placeholder="Password" class="input" required></input>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="button-box mElement pContainerS">
                    <a href="friendlist.php">
                        <button type="button" class="button mElement">
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
        </div>
    </body>
</html>