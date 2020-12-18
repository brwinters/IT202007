<?php
//we'll be including this on most/all pages so it's a good place to include anything else we want on those pages
require_once(__DIR__ . "/../lib/helpers.php");
?>
<ul>
    <li><a href="home.php">Home</a></li>
    <?php if(!is_logged_in()):?>
    <li><a href="login.php">Login</a></li>
    <li><a href="Registration.php">Register</a></li>
    <?php endif;?>
    <?php if(is_logged_in()):?>
    <li><a href="logout.php">Logout</a></li>
    <?php endif; ?>
</ul>
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
