<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (isset($_POST["submit"])) {
    echo "<pre>" . var_export($_POST, true) . "</pre>";
    $survey_id = $_GET["id"];
    $user_id = get_user_id();
    $params[":survey_id"] = $survey_id;
    $query = "INSERT INTO F20_Responses (survey_id, question_id, answer_id, user_id) VALUES (:survey_id, :question_id, :answer_id, :user_id)";//ignore sql error hint

    $db = getDB();
    $stmt = $db->prepare($query);
    $r = $stmt->execute($params);
    if ($r) {
        flash("Answers have been recorded", "success");
    }
    else {
        flash("There was an error recording your answers: " . var_export($stmt->errorInfo(), true), "danger");
    }
    die(header("Location: " . getURL("surveys.php")));
}
?>

<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
?>
<?php
//fetching
$results = [];
if (isset($id)) {
    $db = getDB();
    $stmt = $db->prepare("SELECT F20_Answers.id as answer_id,F20_Questions.id as question_id, question, answer FROM F20_Questions JOIN F20_Answers ON F20_Answers.question_id = F20_Questions.id WHERE survey_id = :id");
    $r = $stmt->execute([":id" => $id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$results) {
        $e = $stmt->errorInfo();
        flash($e[2]);
    }
}
?>
    <h3>Take Survey</h3>
<form method="POST" class="form-inline">
        </form>
        <div class="results">
            <?php if (count($results) > 0): ?>
                <div class="list-group">
                    <?php foreach ($results as $r): ?>
                        <div class="list-group-item">
                                    <div>Question:</div>
                             <input type="hidden" name="question_id" value="<?php echo $r["question_id"];?>"/> <div><?php safer_echo($r["question"]); ?></div>
                                </div> 
                     <?php endforeach; ?>
                     <?php foreach ($results as $r): ?>
                        <div class="list-group-item">
                                        <div>Answers:</div>
                    <input type="radio" value="<?php echo $r["answer_id"];?>" name="answer"/><?php echo $r["answer"];?>
                                </div> 
		      
                        </div>
                    <?php endforeach; ?>
                 </div>
            <?php else: ?>
                <p>No results</p>
            <?php endif; ?>
        </div>
    </div>
<body>
	</form>
 <input type="submit" value=submit>
</form>
<body>

<?php require(__DIR__ . "/partials/flash.php");
