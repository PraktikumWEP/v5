<?php
    require("start.php");
    use model\Friend;

    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }

    $user = $_GET["user"];
    if($service->userExists($user)) {
        $user = $service->loadUser($user);
        if(isset($_POST["remove"])) {
            $friend = new Friend($_POST["remove"]);
            if($service->friendRemove($friend)) {
                header("Location: friendlist.php");
            }
        }
    }
    else {
        header("Location: friendlist.php");
        exit();
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
        
        <title>Profile</title>
        <meta name="description" content="description">

        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/components.css">
    </head>
    <body>
        <div class="background centerRow">
            <div class="max-width centerRowV card">
                <div class="mElement">
                    <img src="assets/images/profile.png" class="image"></img>
                </div>
                <div class="mElement">
                    <h1>Profile of <?= $user->username ?></h1>
                </div>
                <div class="breadcrumb mElement">
                    <form action="profile.php?user=<?= $user->username ?>" method="POST">
                        <a href="chat.php?user=<?= $user->username ?>" class="link">&lt; Back to Chat</a>
                        <label class="breadcrumb-divider">&nbsp;|&nbsp;</label>
                        <a class="link removeFriend submitTrigger">Remove Friend</a>
                        <input type="hidden" name="remove" value="<?= $user->username ?>">
                        <input type="submit" id="submit">
                    </form>
                </div>
                <div class="mElement">
                    <p class="paragraph">
                        <?= $user->description ?>
                    </p>
                </div>
                <div class="mElement">
                    <div class="mElement">
                        <label style="font-weight: bold">Coffee or Tea?</label>
                        <div class="mElement">
                            <label>&emsp;&emsp;<?= $user->coffeeOrTea ?></label>
                        </div>
                    </div>
                    <div class="mElement">
                        <label style="font-weight: bold">Name</label>
                        <div class="mElement">
                            <label>&emsp;&emsp;<?= $user->firstName . " " . $user->lastName ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            let submit = document.getElementById("submit");
            let trigger = document.getElementsByClassName("submitTrigger")[0];
            submit.style.visibility = "hidden";
            submit.style.display = "none";
            trigger.addEventListener("click", () => {
                submit.click();
            })
        </script>
    </body>
</html>