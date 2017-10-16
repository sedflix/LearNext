<?php
$mysqli = new mysqli("localhost", "root", "", "hack");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//user_creation
//INSERT INTO users (name,password,class,board,school)VALUES ($name,$password,$class,$board,$school);

//task_creation
//INSERT INTO task (subject_id, parent_task_id, name, link, description, board) VALUES($subject_id, $parent_task_id, $name, $link, $description, $board)


//revisiontime_creator
//INSERT INTO timeline (task_id, user_id, revision_id) VALUES ($task_id, $user_id, $revision_id)

//difficulty-creatot
//INSERT INTO difficulty (teacher_id, task_id, importance, difficulty) VALUES($teacher_id, $task_id, $importance, $difficulty)




//information retrial
//input $user_id and $task_id
//output revison array
    $result = $mysqli->query("SELECT revision FROM timeline WHERE task_id=\"$task_id\" AND user_id=\"$user_id\" ORDER BY revision");
    $row = $result->fetch_assoc();
    $output=array();
    while($row = $result->fetch_assoc())
        array_push($output,$row);

/**
 *
 */
$result = $mysqli->query("SELECT duedate,task_if FROM timeline WHERE  user_id=\"$user_id\" ORDER BY duedate ASC LIMIT 4");
$row = $result->fetch_assoc();
$output=array();
while($row = $result->fetch_assoc())
    array_push($output,$row);



//UPDATE

function getTaskDetails($task_id)
{
    $mysqli = new mysqli("localhost", "root", "", "hack");
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    $result = $mysqli->query("SELECT * FROM task WHERE task_id=\"$task_id\"");
    $row = $result->fetch_assoc();
    return $row;
}
?>