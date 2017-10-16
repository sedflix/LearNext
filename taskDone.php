<?php
    if(isset($_GET))
    {
        $task_id = $_GET['t'];
        $user_id = $_GET['u'];
        $mysqli = new mysqli("localhost", "root", "", "hack");
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        if(! $mysqli->query("INSERT INTO timeline (task_id, user_id) VALUES (\"$task_id\", \"$user_id\")"))
        {
            echo "MEGA ERROR";
        }
    }
    else
    {

    }
?>