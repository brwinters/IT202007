<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
//we'll put this at the top so both php block have access to it
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
?>
<?php
//saving
if (isset($_POST["save"])) {
    //TODO add proper validation/checks
    $name = $_POST["title"];
    $state = $_POST["state"];
    $nst = date('Y-m-d H:i:s');//calc
    $user = get_user_id();
    $db = getDB();
    if (isset($id)) {
        $stmt = $db->prepare("UPDATE Survey set name=:name, where id=:id");
       
        $r = $stmt->execute([
            ":name" => $name,
            ":state" => $state,
            ":nst" => $nst,
            ":id" => $id
        ]);
        if ($r) {
            flash("Updated successfully with id: " . $id);
        }
        else {
            $e = $stmt->errorInfo();
            flash("Error updating: " . var_export($e, true));
        }
    }
    else {
        flash("ID isn't set, we need an ID in order to update");
    }
}
?>
<?php
//fetching
$result = [];
if (isset($id)) {
    $id = $_GET["id"];
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM Survey where id = :id");
    $r = $stmt->execute([":id" => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
  <FORM NAME ="form1" METHOD ="GET" ACTION ="setQuestion.php">
	Enter a question: <INPUT TYPE = 'TEXT' Name ='question'  value="What is the Question?"  maxlength="40">
<p>
	Answer A: <INPUT TYPE = 'TEXT' Name ='AnswerA'  value="Option A" maxlength="20">
	Answer B: <INPUT TYPE = 'TEXT' Name ='AnswerB'  value="Option B" maxlength="20">
	Answer C: <INPUT TYPE = 'TEXT' Name ='AnswerC'  value="Option C" maxlength="20">
<P align = center>
	<INPUT TYPE = "Submit" Name = "Sub1"  VALUE = "Set this Question">
<?php require(__DIR__ . "/partials/flash.php");
