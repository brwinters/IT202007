<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!is_logged_in()) {//!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>
<?php
if (isset($_POST["submit"])) {
    //echo "<pre>" . var_export($_POST, true) . "</pre>";
    //TODO this isn't going to be the best way to parse the form, and probably not the best form setup
    //so just use this as an example rather than what you should do.
    //this is based off of naming conversions used in Python WTForms (I like to try to see if I can get some
    //php equivalents implemented (to a very, very basic degree))
    $questionnaire_name = $_POST["questionnaire_name"];
    $is_valid = true;
    if (strlen($questionnaire_name) > 0) {
        //make sure we have a name
        $questionnaire_desc = $_POST["questionnaire_desc"];
        $attempts_per_day = $_POST["attempts_per_day"];
        //TODO important to note, if a checkbox isn't toggled/checked it won't be sent with the request.
        //Checkboxes have a poor design and usually need a hidden form and/or JS magic to work for unchecked values
        //so here we're just going to default to false if it's not present in $_POST
        $use_max = false;//used to hard limit the number of attempts
        if (isset($_POST["use_max"]) && $_POST["use_max"] == 'on') {
            $use_max = true;
        }
    }
                    array_push($questions, [
                        "question" => $question,
                        "answers" => $answers
                    ]);
                }
                else {
                    //we don't have anymore questions in post, early terminate the loop
                    break;
                }
            }
            //echo "<pre>" . var_export($questions, true) . "</pre>";
            //echo "<pre>" . var_export($answers, true) . "</pre>";
            //TODO going to try to do this with as few db calls as I can
            //wrap it up so we can just pass one param to DBH
            $questionnaire = [
                "name" => $questionnaire_name,
                "description" => $questionnaire_desc,
                "attempts_per_day" => $attempts_per_day,
                "max_attempts" => $max_attempts,
                "use_max" => $use_max,
                "questions" => $questions//contains answers
            ];
            //echo "<pre>" . var_export($questionnaire, true) . "</pre>";
            save_questionnaire($questionnaire);
            /*$response = DBH::save_questionnaire($questionnaire);
            if (Common::get($response, "status", 400) == 200) {
                Common::flash("Successfully saved questionnaire", "success");
            }
            else {
                Common::flash("There was an error creating the questionnaire", "danger");
            }*/
        }
    }
    else {
        $is_valid = false;
        flash("A Questionnaire name must be provided", "danger");
    }
    if ($is_valid) {
        //this will erase the form since it's a page refresh, but we need it to show the session messages
        //this is a last resort as we should use JS/HTML5 for a better UX
        // die(header("Location: questionnaire.php"));
    }
}
function save_questionnaire($questionnaire) {
    //this could be moved to a helper file if it's used elsewhere too
    //since I don't plan on implementing edit survey at this time, I'll keep it here
    $db = getDB();
    $hadError = false;
    //insert survey
    $stmt = $db->prepare("INSERT INTO F20_Surveys (name, description, attempts_per_day, max_attempts,use_max, user_id) VALUES (:name, :desc, :apd, :ma, :um, :user_id)");
    $r = $stmt->execute([
        ":name" => $questionnaire["name"],
        ":desc" => $questionnaire["description"],
        ":apd" => $questionnaire["attempts_per_day"],
        ":ma" => $questionnaire["max_attempts"],
        ":um" => $questionnaire["use_max"] ? "1" : "0",//Convert to 1 or 0 for insertion as tinyint 
        ":user_id" => get_user_id()
    ]);
 
    }
    if (!$hadError) {
        flash("Successfully created Survey: " . $questionnaire["name"], "success");
        //redirect to prevent duplicate form submission
        die(header("Location: create_survey.php"));
    }
}

        function update_names_and_ids($ele) {
            let $lis = $ele.children(".list-group-item");
            //loop over all list-group-items of list-group
            $lis.each(function (index, item) {
                let $fg = $(item).find(".form-group");
                let liIndex = index;
                //loop over all form-groups inside list-group-item
                $fg.each(function (index, item) {
                    let $label = $(item).find("label");
                    if (typeof ($label) !== 'undefined' && $label != null) {
                        let forAttr = $label.attr("for");
                        let pieces = forAttr.split('_');
                        //Note this is different since it's a plain array not a jquery object
                        pieces.forEach(function (item, index) {
                            if (!isNaN(item)) {
                                pieces[index] = liIndex;
                            }
                        });
                        let updatedRef = pieces.join("_");
                        $label.attr("for", updatedRef);
                        let $input = $(item).find(":input");
                        if (typeof ($input) !== 'undefined' && $input != null) {
                            $input.attr("id", updatedRef);
                            $input.attr("name", updatedRef);
                        }
                    }
                });
                //See if we have any children list-groups (this would be our answers)
                let $child_lg = $(item).find(".list-group");//probably doesn't need an each loop but it's fine
                $child_lg.each(function (index, item) {
                    let $childlis = $(item).find(".list-group-item");
                    $childlis.each(function (index, item) {
                        let $fg = $(item).find(".form-group");
                        let childLiIndex = index;
                        //loop over all form-groups inside list-group-item
                        $fg.each(function (index, item) {
                            let $label = $(item).find("label");
                            if (typeof ($label) !== 'undefined' && $label != null) {
                                let forAttr = $label.attr("for");
                                let pieces = forAttr.split('_');
                                //Note this is different since it's a plain array not a jquery object
                                let lastIndex = -1;
                                pieces.forEach(function (item, index) {
                                    if (!isNaN(item)) {
                                        //example: question_#_answer_#
                                        if (lastIndex == -1) {
                                            //example: question_#
                                            pieces[index] = liIndex;//replace the first # with the parent outer loop index
                                            lastIndex = index;
                                        } else {
                                            //example: question_#_answer_#
                                            pieces[index] = childLiIndex;//replace the second # with the child loop index
                                        }
                                    }
                                });
                                let updatedRef = pieces.join("_");
                                $label.attr("for", updatedRef);
                                let $input = $(item).find(":input");
                                if (typeof ($input) !== 'undefined' && $input != null) {
                                    $input.attr("id", updatedRef);
                                    $input.attr("name", updatedRef);
                                }
                            }
                        });
                    });
                });
            });
        }

        function cloneThis(ele) {
            let $lg = $(ele).siblings(".list-group");
            let $li = $lg.find(".list-group-item:first");
            let $clone = $li.clone();
            $lg.append($clone);
            update_names_and_ids($(".list-group:first"));
        }

        function deleteMe(ele) {
            let $li = $(ele).closest(".list-group-item");
            let $lg = $li.closest(".list-group");
            let $children = $lg.children(".list-group-item");
            if ($children.length > 1) {
                $li.remove();
                update_names_and_ids($(".list-group:first"));
            }
        }
    </script>
<?php require(__DIR__ . "/partials/flash.php");
