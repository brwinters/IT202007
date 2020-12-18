 <div class="container-fluid">
        <h3>List Survey</h3>
        <form method="POST" class="form-inline">
            <input class="form-control" name="query" placeholder="Search" value="<?php safer_echo($query); ?>"/>
            <input class="btn btn-primary" type="submit" value="Search" name="search"/>
        </form>
        <div class="results">
            <?php if (count($results) > 0): ?>
                <div class="list-group">
                    <?php foreach ($results as $r): ?>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col">
                                    <div>Name:</div>
                                    <div><?php safer_echo($r["name"]); ?></div>
                                </div>
                                <div class="col">
                                    <div>State:</div>
                                    <div><?php getState($r["state"]); ?></div>
                                </div>
                                <div class="col">
                                    <div>Next Stage:</div>
                                    <div><?php safer_echo($r["next_stage_time"]); ?></div>
                                </div>
                                <div class="col">
                                    <div>Owner Id:</div>
                                    <div><?php safer_echo($r["user_id"]); ?></div>
                                </div>
                                <div class="col">
                                    <a type="button" href="add_question.php?id=<?php safer_echo($r['id']); ?>">Edit</a>
                                    <a type="button" href="view_survey.php?id=<?php safer_echo($r['id']); ?>">View</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No results</p>
            <?php endif; ?>
        </div>
    </div>
<?php require(__DIR__ . "/../partials/flash.php");
<?php
//we'll be including this on most/all pages so it's a good place to include anything else we want on those pages
require_once(__DIR__ . "/../lib/helpers.php");
?>
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
      integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>

<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="<?php echo getURL("home.php"); ?>">Home</a></li>
            <?php if (!is_logged_in()): ?>
                <li class="nav-item"><a class="nav-link" href="<?php echo getURL("login.php"); ?>">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo getURL("register.php"); ?>">Register</a></li>
            <?php endif; ?>
            <?php if (has_role("Admin")): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Admin
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="nav-link" href="<?php echo getURL("test/test_create_egg.php"); ?>">Create
                            Egg</a>
                        <a class="nav-link" href="<?php echo getURL("test/test_list_egg.php"); ?>">View
                            Eggs</a>
                        <a class="nav-link" href="<?php echo getURL("test/test_create_incubator.php"); ?>">Create
                            Incubator</a>

                        <a class="nav-link" href="<?php echo getURL("test/test_list_incubators.php"); ?>">View
                            Incubator</a>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (is_logged_in()): ?>
                <li class="nav-item"><a class="nav-link" href="<?php echo getURL("my_eggs.php"); ?>">My Eggs</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo getURL("shop.php"); ?>">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo getURL("my_cart.php"); ?>">Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo getURL("create_survey.php"); ?>">Create
                        Survey</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo getURL("surveys.php"); ?>">Surveys</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo getURL("create_competition.php"); ?>">Create
                        Competition</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo getURL("competitions.php"); ?>">Active
                        Competitions</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo getURL("my_competitions.php"); ?>">My
                        Competitions</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo getURL("profile.php"); ?>">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo getURL("logout.php"); ?>">Logout</a></li>
            <?php endif; ?>
        </ul>
        <span class="navbar-text">Balance: <?php echo getBalance(); ?></span>
    </nav>
</div>
<?php
/*put this at the bottom of the page so any templates
 populate the flash variable and then display at the proper timing*/
?>
<div class="container" id="flash">
    <?php $messages = getMessages(); ?>
    <?php if ($messages): ?>
        <?php foreach ($messages as $msg): ?>
            <div class="row justify-content-center">
                <div class="alert alert-primary" role="alert"><?php echo $msg; ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<script>
    //used to pretend the flash messages are below the first nav element
    function moveMeUp(ele) {
        let target = document.getElementsByTagName("nav")[0];
        if (target) {
            target.after(ele);
        }
    }

    moveMeUp(document.getElementById("flash"));
</script>
