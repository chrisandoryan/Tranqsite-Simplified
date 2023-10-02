<?php
    session_start();
    function map_recipient($recipient_id) {
        switch ($recipient_id) {
            case '1':
                return "Administrator";
                break;
            case '2':
                return "Network Manager";
                break;
            case '3':
                return "IT Support";
                break;
            case '4':
                return "Coworker";
                break;
        }
    }
    require_once(__DIR__ . '/controllers/connection.php');
    if (!isset($_SESSION['is_login'])) {
        $_SESSION['error'][] = "You are not logged in.";
        header('Location: ../login.php');
    }

    $query = "SELECT * FROM communications;";

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $query = "SELECT * FROM communications WHERE title LIKE '%$search%' OR message LIKE '%$search%'";
    }
    $result = $connection->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tranqsite</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/hack.css">
    <link rel="stylesheet" href="assets/dark.css">
    <script src="https://code.jquery.com/jquery-3.6.1.slim.js" integrity="sha256-tXm+sa1uzsbFnbXt8GJqsgi2Tw+m4BLGDof6eUPjbtk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
</head>

<div class="nav">
    <a class="button btn btn-success btn-ghost newq" href="messages.php">Messages</a>
    <a class="button btn btn-primary btn-ghost newq" href="send.php">Send Message</a>
    <a class=" btn btn-default btn-ghost skip" href="./controllers/AuthController.php?logout">Logout</a>
</div>

<body class="hack dark">
    <div class="grid main-form">
        <div>
            <h1>Account</h1>
            <div class="card">
                <header class="card-header"><?= $_SESSION['username']; ?></header>
                <header class="card-header"><?= $_SESSION['email']; ?></header>
            </div>
        </div>
        <br><br>
        <br><br>
        <br><br>
        <form class="form" method="GET">
            <fieldset class="form-group">
                <label for="username">Search</label>
                <input id="search" name="search" type="text" placeholder="Enter search query..." class="form-control">
            </fieldset>
            <div class="form-actions">
                <input type="submit" class="btn btn-primary btn-block btn-ghost" name="send" />
            </div>
        </form>
        <div>
            <h1>Messages</h1>
            <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
            ?>
            <div class="card">
                <header class="card-header">To: <?= map_recipient($row['recipient_id']); ?></header>
                <header class="card-header"><?= $row['title']; ?></header>
                <div class="card-content">
                    <div class="inner"><?= $row['message']; ?></div>
                </div>
            </div>
            <?php
                    }
                }
            ?>
        </div>
        <!-- <div class="alert alert-warning">No messages found.</div> -->
</body>

</html>