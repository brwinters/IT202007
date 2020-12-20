<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
$survey_id = -1
if (isset($_GET["id"])) {
    $survey_id = $_GET["id"];
}

if (isset($_POST["submit"])) {
	$question = $_POST["question"];
	if(!empty(question) && $survey_id > -1
 $stmt = $db->prepare("INSERT INTO Questions (surevy_id, question) VALUES(:sid, :q)");
	$r = $stmt->execute ([":sid"=>$survey_id, ":q"=>$question]);
	   if($r){
		   flash("Question created");
   }
	   else{
		   flash("Problem creating question " . var_export($stmt->errorINfo(), true));
	   }
	   }
	   else{
		   flash("Questions must not be empty and survey id must be passed in the url");
	   }
	   }
	   ?>
<form method="POST">
	<input name="questions"/>
	<input type="submit" name="submit"/>
	<form>
  
<?php require(__DIR__ . "/partials/flash.php");
