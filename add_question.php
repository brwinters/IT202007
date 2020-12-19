<?php
//we'll put this at the top so both php block have access to it
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}


//fetching
$result = [];
if (isset($id)) {
 $stmt = $db->prepare("INSERT INTO Survey (title, description) VALUES(:name, :user)");
   }
?>
   <FORM NAME ="form1" METHOD =$_POST
	Enter a question: <INPUT TYPE = 'TEXT' Name ='question'  value="What is the Question?"  maxlength="40">


	<INPUT TYPE = "Submit" Name = "Sub1"  VALUE = "Set this Question">
		</form>
<?php require(__DIR__ . "/partials/flash.php");
