<?php
    require("start.php");
    use model\Friend;

    // check session
    if (!isset($_SESSION["user"]) || $_SESSION["user"] == "") {
        header("Location: login.php");
        exit();
    }

    // check query parameters
    $other_user = false;
    if (isset($_GET['user']) && $_GET['user'] != "") {
        $other_user = $_GET['user'];
        if (isset($_POST["remove"])) {
            $friend = new Friend($_POST["remove"]);
            if ($service->friendRemove($friend)) {
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

        <title>Chat</title>
        <meta name="description" content="description">

        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/components.css">
    </head>
    <body>
        <div class="background centerRow">
            <div class="register max-width centerRowV card">
                <div class="chat-text mElement">
                    <h1>
                        <?php echo "Chat with " . $other_user ?>
                    </h1>
                </div>
                <div class="breadcrumb mElement">
                    <form action="chat.php?user=<?= $other_user ?>" method="POST">
                        <a class="link" href="friendlist.php">&lt; Back</a>
                        <label class="breadcrumb-divider">&nbsp;|&nbsp;</label>
                        <a class="link" href="profile.php?user=<?= $other_user ?>">Profile</a>
                        <label class="breadcrumb-divider">&nbsp;|&nbsp;</label>
                        <a class="link removeFriend submitTrigger">Remove Friend</a>
                        <input type="hidden" name="remove" value="<?= $other_user ?>">
                        <input type="submit" id="submit">
                    </form>
                </div>

                <div class="mElement">
                    <fieldset class="pContainerS" >
                        <legend>Chat</legend>
                        <div id="chat">
                            <!-- contents added by chat.js-->
                        </div>
                    </fieldset>
                </div>
                <script type="text/javascript">
                    chatCollectionId = "<?= CHAT_SERVER_ID ?>";
                    chatServer = "<?= CHAT_SERVER_URL ?>";
                    chatUser = "<?= $other_user ?>"
                    chatToken = "<?= $_SESSION["chat_token"] ?>";
                </script>
                <script type="module" src="assets/js/chat.js"></script>
                <form method="post" action="chat.php" name="sendMessage">
                    <div class="chat-new-message mElementM">
                        <div class="mElement">
                            <input class="input-message input" placeholder="New Message" required>
                        </div>
                        <div class="mElementM centerRow">
                            <button class="button-send button" type="submit">Send</button>
                        </div>
                    </div>
                </form>
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