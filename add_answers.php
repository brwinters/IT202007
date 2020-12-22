<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
$question_id = -1;
if (isset($_GET["id"])) {
    $question_id = $_GET["id"];
}

if (isset($_POST["submit"])) {
	$answer = $_POST["answer"];
	if(!empty($answer) && $question_id > -1){
	$db = getDB();
 $stmt = $db->prepare("INSERT INTO F20_Answers (question_id, answer) VALUES(:sid, :q)");
	$r = $stmt->execute ([":sid"=>$question_id, ":q"=>$answer]);
	   if($r){
		   flash("Answers created");
   }
	   else{
		   flash("Problem creating answer " . var_export($stmt->errorINfo(), true));
	   }
	   }
	   else{
		   flash("Answer must not be empty and survey id must be passed in the url");
	   }
	   }
	   ?>
<form method="POST">
	Answe A: <input name="answer"/>
	<input type="submit" name="submit"/>
	<form>
<?php require(__DIR__ . "/partials/flash.php");
