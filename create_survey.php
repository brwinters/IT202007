<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>
<div class="container-fluid">
        <h3>Create Survey</h3>
        <form method="POST">
            <div class="form-group">
                <label>Title</label>
                <input class="form-control" name="Title" placeholder="Title"/>
            </div>
             <form method="POST">
            <div class="form-group">
                <label>Description</label>
                <input class="form-control" name="Description" placeholder="Description"/>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="0">Drafts</option>
                    <option value="1">Private</option>
                    <option value="2">Public</option>
                    
                </select>
            </div>
          
<?php
if (isset($_POST["save"])) {
    //TODO add proper validation/checks
    $Title = $_POST["title"];
    $Description = $_POST["description"];
    $Status = $_POST["status"];
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
                 
