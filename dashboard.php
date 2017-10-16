<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>LearNext</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="images/android-desktop.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="LearNext">
    <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <link rel="shortcut icon" href="images/favicon.png">

    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
    <link rel="canonical" href="http://www.example.com/">
    -->

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.2.0/material.deep_purple-pink.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style>
        #view-source {
            position: fixed;
            display: block;
            right: 0;
            bottom: 0;
            margin-right: 40px;
            margin-bottom: 40px;
            z-index: 900;
        }
    </style>
</head>
<body class="mdl-demo mdl-color--grey-100 mdl-color-text--grey-700 mdl-base">
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header mdl-layout__header--scroll mdl-color--primary">
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
        </div>
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
            <h3>LearNext</h3>
        </div>
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
        </div>
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect mdl-color--primary-dark">
            <a href="#" class="mdl-layout__tab is-active">Dashboard</a>
            <a href="join.php" class="mdl-layout__tab">Join</a>
            <a href="login.php" class="mdl-layout__tab">Log In</a>
            <a href="toDo.php" class="mdl-layout__tab">To - Do</a>

        </div>
    </header>
    <main class="mdl-layout__content">
        <div class="mdl-layout__tab-panel is-active" id="overview">
            <?php
            $mysqli = new mysqli("localhost", "root", "", "hack");
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }

            if(!isset($_COOKIE['user_id'])) {
                header("Location: http://localhost/hack/login.php");
            } else {
                $user_ID = $_COOKIE['user_id'];
                $result11 = $mysqli->query("SELECT * FROM users WHERE user_id=\"$user_ID\"");
                echo '<h3 style="text-align: center;"> Hi '. ($result11->fetch_assoc())['name'] ."</h3>";
            }

            ?>

            <?php
            if (isset($_GET)) {
                if (!isset($_COOKIE['user_id'])) {
                    header("Location: http://localhost/hack/login.php");
                } else {
                    $user_ID = $_COOKIE['user_id'];
                }
                $task_id = $_GET['t'];
                $mysqli = new mysqli("localhost", "root", "", "hack");
                if ($mysqli->connect_errno) {
                    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                }
                $result = $mysqli->query("SELECT * FROM task WHERE parent_task_id=\"$task_id\"");
                while ($row = $result->fetch_assoc()) {
                        $this_task_id=$row['task_id'];
                        $resultOfDiff = $mysqli->query("SELECT * FROM difficulty WHERE task_id=\"$this_task_id\"");
                        $rowOfDiff = $resultOfDiff->fetch_assoc();
                        $importance = $rowOfDiff['importance'];
                        $difficulty = $rowOfDiff['difficulty'];
                    ?>
                    <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
                        <header
                            class="section__play-btn mdl-cell mdl-cell--3-col-desktop mdl-cell--2-col-tablet mdl-cell--4-col-phone mdl-color--teal-100 mdl-color-text--white">
                        </header>
                        <div
                            class="mdl-card mdl-cell mdl-cell--9-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone">
                            <div class="mdl-card__supporting-text">
                                <h4><?= $row['name'] ?></h4>
                                <h6>Difficulty: <?=$difficulty?>  |  Importance: <?=$importance?></h6>
                                <h5>Description</h5>
                                <?= $row['description'] ?>
                                <h6>Extra Resources</h6>
                                <p>
                                <?= $row['link'] ?>
                                </p>
                            </div>

                            <?php
                            $this_task_id = $row['task_id'];
                            $result2 = $mysqli->query("SELECT * FROM task WHERE parent_task_id=\"$this_task_id\"");
                            if ($result2->num_rows > 0) {
                                ?>
                                <div class="mdl-card__actions">
                                    <a href="dashboard.php?t=<?= $row['task_id']; ?>" class="mdl-button">See more
                                        detailed
                                        tasks in <?= $row['name'] ?></a>
                                </div>
                                <?php
                            } else {
                                $result3 = $mysqli->query("SELECT * FROM timeline WHERE task_id=\"$this_task_id\" ORDER BY revision");
                                if ($result3->num_rows == 0) {

                                    ?>
                                    <div class="mdl-card__actions">
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect"
                                               for="checkbox<?= $row['task_id'] ?>">
                                            <input type="checkbox" id="checkbox<?= $row['task_id'] ?>"
                                                   class="mdl-checkbox__input">
                                            <span class="mdl-checkbox__label">Did you complete it?</span>
                                        </label>

                                        <script>
                                            $(document).ready(function () {

                                                $('#checkbox<?=$row['task_id']?>').change(function () {
                                                    if ($(this).is(":checked")) {
                                                        $(this).attr("disabled", true);
                                                        $.ajax({
                                                            url: 'http://localhost/hack/taskDone.php?t=<?=$row['task_id'];?>&u=<?=$user_ID?>',
                                                            error: function () {
                                                                $('#info').html('<p>An error has occurred</p>');
                                                            }
                                                        })
                                                    }
                                                });
                                            });

                                        </script>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="mdl-card__actions">
                                        You have already completed the task on <?=($result3->fetch_assoc())['revision']?>
                                    </div>
                            <?php
                                }
                            }
                            ?>

                        </div>
                    </section>
                    <?php
                }
            }
            ?>


        </div>

        </section>
</div>

</main>
</div>

</body>
</html>
