<?php
    require("start.php");
    use model\Friend;

    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }
    
    // load friends & requests
    $result = $service->loadFriends();
    $friends = array();
    $requests = array();
    if(isset($result)) {
        foreach($result as $user) {
            if($user->getStatus() == "accepted") {
                $friends[] = $user;
            }
            else {
                $requests[] = $user;
            }
        }
    }

    // accept & dismiss
    if(isset($_POST["accept"])) {
        $user = new Friend($_POST["accept"]);
        $service->friendAccept($user);
        header("Location: friendlist.php");
        exit();
    }
    if(isset($_POST["dismiss"])) {
        $user = new Friend($_POST["dismiss"]);
        $service->friendDismiss($user);
        header("Location: friendlist.php");
        exit();
    }

    // search friend
    $search = "";
    $result2 = $service->loadUsers("");
    $error = "";
    if(isset($_POST["search"])) {
        $search = $_POST["search"];
        $new_friend = new Friend($search);
        if($service->userExists($search)) {
            $service->friendRequest($new_friend);
            header("Location: friendlist.php");
            exit();
        }
        else {
            $error = "User does not exist";
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
        
        <title>Friendlist</title>
        <meta name="description" content="description">

        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/components.css">
    </head>
    <body>
        <div class="background centerRow">
            <div class="register max-width centerRowV card">
                <div class="mElement">
                    <h1>Friends</h1>
                </div>
                <div class="breadcrumb mElement">
                    <a href="logout.php" class="link">&lt; Logout</a>
                    <label class="breadcrumb-divider">&nbsp;|&nbsp;</label>
                    <a href="settings.php" class="link">Settings</a>
                </div>
                <hr class="friendlist-divider "></hr>
                <div class="mElementM">
                    <section>
                        <ul id="friendlist">
                            <?php
                            if(isset($friends)) {
                                foreach($friends as $friend) {                         
                                    echo "<li>";
                                    echo         "<a href='chat.php?friend=" . $friend->getUsername() . "' class='link'>" . $friend->getUsername() . "</a>";
                                    echo         "<label class='notification-count'>0</label>";
                                    echo "</li>";
                                }
                            }
                            else {
                                echo "No friends";
                            }
                            ?>
                        </ul>
                    </section>
                </div>
                <hr class="friendlist-divider"></hr>
                <div class="mElementM">
                    <section>
                        <div class="mElement">
                            <h2>New Requests</h2>
                        </div>
                        <div class="centerRow">
                            <ul id="requests">
                                <?php
                                if(count($requests) > 0) {
                                    foreach($requests as $request) {
                                        echo                            
                                            "<li><form action='friendlist.php' method='POST'>
                                                <a class='link'>Friend request from " . $request->getUsername() . "</a>
                                                <div class='centerCol mElement'>
                                                    <button type='submit' class='button-small centerRow' name='accept' value='". $request->getUsername() ."'>Accept</button>
                                                    <div style='width: 10px'></div>
                                                    <button type='submit' class='button-small centerRow' name='dismiss' value='". $request->getUsername() ."'>Decline</button>
                                                </div>
                                            </form></li>";
                                    }
                                }
                                else {
                                    echo "No friend requests";
                                }
                                ?>
                            </ul>
                        </div>
                    </section>
                </div>
                <hr class="friendlist-divider"></hr>
                <div class="mElementM">
                    <form method="POST" action="friendlist.php" name="addFriend">
                        <div class="mElement">
                            <div class="mElement">
                                <input type="name" placeholder="Name" class="input" name="search" value="<?= $search ?>" required/>
                                <div class="suggested-friends">
                                </div>
                            </div>
                            <div class="mElementM">
                                <button class="button" type="submit">
                                    Add
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="centerRow"><small class="error-message"><?= $error ?></small></div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            chatToken = "<?= $_SESSION['chat_token'] ?>";
            chatCollectionId = "<?= CHAT_SERVER_ID ?>";
            chatServer = "<?= CHAT_SERVER_URL ?>";
            let users = <?= json_encode($result2) ?>;
        </script>
        <script type="module" src="assets/js/friends.js"></script>
    </body>
</html>