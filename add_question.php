<?php require_once(__DIR__ . "/partials/nav.php"); ?>

<?php
//we'll put this at the top so both php block have access to it
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}


//fetching
$result = [];
if (isset($_POST)) {
 $stmt = $db->prepare("INSERT INTO Survey (title, description) VALUES(:name, :user)");
   }
?>
	<INPUT TYPE = "Submit" Name = "Sub1"  VALUE = "Set this Question">
<?php require(__DIR__ . "/partials/flash.php");

