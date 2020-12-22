<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
?>
<?php
//fetching
$result = [];
if (isset($id)) {
    $db = getDB();
    $stmt = $db->prepare("SELECT id,question,answer, FROM Questions JOIN Answers ON answer.question_id WHERE survey_id = :id");
    $r = $stmt->execute([":id" => $survey_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
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
                        </div>
                    <?php endforeach; ?>
                 </div>
            <?php else: ?>
                <p>No results</p>
            <?php endif; ?>
        </div>
    </div>
<?php require(__DIR__ . "/partials/flash.php");
