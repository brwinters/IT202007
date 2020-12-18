<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<div class="container-fluid">
        <h2>Create Survey</h2>
        <form method="POST">
            <div class="form-group">
                <label>Title</label>
                <input class="form-control" name="name" placeholder="Title"/>
            </div>
             <form method="POST">
            <div class="form-group">
                <label>Description</label>
                <input class="form-control" name="name" placeholder="Description"/>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="0">Drafts</option>
                    <option value="1">Private</option>
                    <option value="2">Public</option>
                    
                </select>
            </div>
          <input class="btn btn-primary" type="submit" name="save" value="Create"/>
        </form>
    </div>
<?php
if (isset($_POST["save"])) {
    //TODO add proper validation/checks
    $name = $_POST["name"];
    $name = $_POST["name"];
    $status = $_POST["status"];
    $nst = date('Y-m-d H:i:s');//calc
    $user = get_user_id();
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Survey (title, description, user_id) VALUES(:name, :user)");
    $r = $stmt->execute([
        ":name" => $name,
        ":user" => $user
    ]);
    if ($r) {
        flash("Created successfully with id: " . $db->lastInsertId());
    }
    else {
        $e = $stmt->errorInfo();
        flash("Error creating: " . var_export($e, true));
    }
}
?>
<?php require(__DIR__ . "/partials/flash.php");
                 
