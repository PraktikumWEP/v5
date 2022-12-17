<?php
    require("start.php");
    use model\Friend;

    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }

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
                        <ul>
                            <?php
                                if(isset($friends)) {
                                    foreach($friends as $friend) {
                                        echo                            
                                            "<li>
                                                <a href='chat.php?friend=" . $friend->getUsername() . "' class='link'>" . $friend->getUsername() . "</a>
                                                <label class='notification-count'>0</label>
                                            </li>";
                                    }
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
                        <div>
                            <ol>
                                <li>
                                    <a class="link">Friend request from Track</a>
                                    <div class="centerCol mElement">
                                        <button class="button-small centerRow">Accept</button>
                                        <div style="width: 10px"></div>
                                        <button class="button-small centerRow">Decline</button>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </section>
                </div>
                <hr class="friendlist-divider"></hr>
                <div class="mElementM">
                    <form method="GET" action="chat.html" name="addFriend">
                        <div class="mElement">
                            <div class="mElement">
                                <input type="name" placeholder="Name" class="input" required/>
                                <div class="suggested-friends">
                                </div>
                            </div>
                            <div class="mElementM">
                                <button class="button">
                                    Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="module" src="assets/js/friends.js"></script>
    </body>
</html>