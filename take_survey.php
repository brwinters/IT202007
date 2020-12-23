<?php require_once(__DIR__ . "/partials/nav.php"); ?>
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
    $stmt = $db->prepare("SELECT F20_Questions.id,F20_Answers.id,question,answer FROM F20_Questions JOIN F20_Answers ON F20_Answers.question_id = F20_Questions.id WHERE survey_id = :id");
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
                                    <div><?php safer_echo($r["question"]); ?></div>
                                </div> 
                     <?php endforeach; ?>
                     <?php foreach ($results as $r): ?>
                        <div class="list-group-item">
                                        <div>Answers:</div>
                                    <div><?php safer_echo($r["answer"]); ?></div>
                                </div> 
                        </div>
                    <?php endforeach; ?>
                 </div>
            <?php else: ?>
                <p>No results</p>
            <?php endif; ?>
        </div>
    </div>

<html>
<body>


  <p>Please select your one option:</p>
  <input type="radio" id="answer.id" name="answer" value="30">
  <label for="age1">Cake</label><br>
  <input type="radio" id="answer.id" name="answer" value="60">
  <label for="age2">Ice Cream</label><br>  
  <input type="radio" id="answer.id" name="answer" value="100">
  <label for="age3">Pie</label><br><br>
  <input type="submit" value="Submit">
</form>

</body>
</html>

<?php require(__DIR__ . "/partials/flash.php");
