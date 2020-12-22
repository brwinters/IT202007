<?php require_once(__DIR__ . "/partials/nav.php"); ?>

<?php
$query = "";
$results = [];
$survey_id = $_GET["id"];

    $db = getDB();
    $stmt = $db->prepare("SELECT id,question from F20_Questions WHERE survey_id = :id ");
    $r = $stmt->execute([":id" => $survey_id]);
    if ($r) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else {
        flash("original message" . var_export($stmt->errorInfo(),true));
    }
?>
    <div class="container-fluid">
        <h3>List Questions</h3>
        <form method="POST" class="form-inline">
        </form>
        <div class="results">
            <?php if (count($results) > 0): ?>
                <div class="list-group">
                    <?php foreach ($results as $r): ?>
                        <div class="list-group-item">
                             div class="row">
                                    <div>Question:</div>
                                    <div><?php safer_echo($r["question"]); ?></div>
                                </div>
                    </div>                  
                                <div class="col">
                                    <a type="button" href="add_question.php?id=<?php safer_echo($r['id']); ?>">Add</a>
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
