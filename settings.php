<?php
    require("start.php");
    use model\User;

    // default
    $inline = true;

    // get user
    $user = new User();
    $user = $service->loadUser($_SESSION["user"]);

    // pull values from form
    if (isset($_POST["first_name"])) {
        $user->firstName = $_POST["first_name"];
    }
    if (isset($_POST["last_name"])) {
        $user->lastName = $_POST["last_name"];
    }
    if (isset($_POST["coffee_or_tea"])) {
        $user->coffeeOrTea = $_POST["coffee_or_tea"];
    }
    if (isset($_POST["description"])) {
        $user->description = $_POST["description"];
    }
    if (isset($_POST["inline"])) {
        $user->layout = $_POST["inline"];
    }

    // layout
    if ( $user->layout === "dualline") {
        $inline = false;
    }

    if(count($_POST) > 0) {
        $service->saveUser($user);
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
        
        <title>Settings</title>
        <meta name="description" content="description">

        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/components.css">
    </head>
    <body>
        <form method="POST" action="settings.php">
            <div class="background centerRow">
                <div class="max-width centerRowV card">
                    <div class="mElementM">
                        <h1>
                            Profile Settings
                        </h1>
                    </div>
                    <div class="mElement">
                        <fieldset class="pContainerS">
                            <legend>Base Data</legend>
                            <div class="mElementM">
                                <div class="mElement">
                                    <label>First Name</label>
                                </div>
                                <div class="mElement">
                                    <input value="<?php if(isset($user->firstName)) {echo $user->firstName;} ?>"name="first_name" type="text" placeholder="Your name" class="input" required/>
                                </div>
                            </div>
                            <div class="mElementM">
                                <div class="mElement">
                                    <label>Last Name</label>
                                </div>
                                <div class="mElement">
                                    <input value="<?php if(isset($user->lastName)) {echo $user->lastName;} ?>" type="text" placeholder="Your surname" class="input" name="last_name" required/>
                                </div>
                            </div>
                            <div class="mElementM">
                                <label>Coffee or Tea?</label>
                                <select name="coffee_or_tea">
                                    <option value="Neither" <?php if(!isset($user->coffeeOrTea) || $user->coffeeOrTea === 'Neither'){echo 'selected';} ?>>Neither</option>
                                    <option value="Coffee" <?php if(isset($user->coffeOrTea)){if($user->coffeeOrTea === 'Coffee'){echo 'selected';}} ?>>Coffee</option>
                                    <option value="Tea" <?php if(isset($user->coffeeOrTea)){if($user->coffeeOrTea === 'Tea'){echo 'selected';}} ?>>Tea</option>
                                    <option value="Both" <?php if(isset($user->coffeOrTea)){if($user->coffeeOrTea === 'Both'){echo 'selected';}} ?>>Both</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>

                    <div class="mElementM">
                        <fieldset class="pContainerS">
                            <legend>Tell Something about you</legend>
                            <div class="mElement">
                                <textarea name="description" placeholder="Leave a comment here" class="input textarea"><?php if(isset($user->description)) {echo $user->description;} ?></textarea>
                            </div>
                        </fieldset>
                    </div>
                    
                    <div class="mElement">
                        <fieldset class="pContainerS">
                            <legend>Preferred Chat Layout</legend>
                            <div class="mElement">
                                <div class="mElement">
                                    <input type="radio" value="inline" name="inline" <?php if($inline) {echo 'checked';} ?> required/>
                                    <label for="layout1">Username and message in one line</label>
                                </div>
                                <div class="mElement">
                                    <input type="radio" value="dualline" name="inline" <?php if(!$inline) {echo 'checked';} ?> required/>
                                    <label for="layout2">Username and message in seperated lines</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="button-box mElement pContainerS">
                        <a href="friendlist.php">
                            <button type="button" class="button mElement">
                                Cancel
                            </button>
                        </a>
                        <a href="">
                            <button type="submit" class="button mElement">
                                Save
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>

