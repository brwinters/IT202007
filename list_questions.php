<?php require_once(__DIR__ . "/partials/nav.php"); ?>

<?php
$query = "";
$results = [];
$survey_id = $_GET["id"];

    $db = getDB();
    $stmt = $db->prepare("SELECT id,question, from F20_Questions WHERE survey_id = :id ");
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
            <input class="form-control" name="query" placeholder="Search" value="<?php safer_echo($query); ?>"/>
            <input class="btn btn-primary" type="submit" value="Search" name="search"/>
        </form>
        <div class="results">
            <?php if (count($results) > 0): ?>
                <div class="list-group">
                    <?php foreach ($results as $r): ?>
                        <div class="list-group-item">
                            <div class="row">
                               
                                    <div>Title:</div>
                                    <div><?php safer_echo($r["title"]); ?></div>
                                </div>
                             div class="col">
                                    <div>Question:</div>
                                    <div><?php safer_echo($r["Question"]); ?></div>
                                </div>
                                <div class="col">
                                    <div>State:</div>
                                    <div><?php getState($r["visibility"]); ?></div>
                                </div>                  
                                <div class="col">
                                    <a type="button" href="add_question.php?id=<?php safer_echo($r['id']); ?>">Add</a>
                                    <a type="button" href="view_survey.php?id=<?php safer_echo($r['id']); ?>">View</a>
                                </div>
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
