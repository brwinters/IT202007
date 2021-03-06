<?php require_once(__DIR__ . "/partials/nav.php"); ?>

?>
<?php
//get latest 10 surveys we haven't take
$db = getDB();
$stmt = $db->prepare("SELECT id, name FROM Surveys WHERE (SELECT count(1) from F20_Responses where user_id = :id and survey_id = F20_Surveys.id) = 0 order by created desc LIMIT 10");
$r = $stmt->execute([":id" => get_user_id()]);
if ($r) {
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else {
    flash("There was a problem fetching surveys: " . var_export($stmt->errorInfo(), true), "danger");
}
$count = 0;
if (isset($results)) {
    $count = count($results);
}
?>
<div class="container-fluid">
    <h3>Surveys (<?php echo $count; ?>)</h3>
    <?php if (isset($results) && $count > 0): ?>
        <div class="list-group">
            <?php foreach ($results as $s): ?>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-8"><?php safer_echo($s["name"]); ?></div>
                        <div class="col">
                            <a type="button" class="btn btn-success"
                               href="<?php echo getURL("survey.php?id=" . $s["id"]); ?>">
                                Take Survey
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No surveys available</p>
    <?php endif; ?>
</div>
<?php require(__DIR__ . "/partials/flash.php"); ?>
