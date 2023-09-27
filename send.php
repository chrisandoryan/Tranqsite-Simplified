<?php
    session_start();

    if ($_SESSION['is_login'] !== true) {
      header("Location: login.php");  
    }

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
        <form class="form" method="POST" action="./controllers/MessageController.php">
            <fieldset class="form-group">
                <label for="username">Title:</label>
                <input id="title" name="title" type="text" placeholder="" class="form-control">
            </fieldset>
            <fieldset class="form-group">
                <label for="recipient">To:</label>
                <select id="recipient" name="recipient" class="form-control">
                    <option value="1">Administrator</option>
                    <option value="2">Network Manager</option>
                    <option value="3">IT Support</option>
                    <option value="4">Coworker</option>
                </select>
            </fieldset>
            <fieldset class="form-group form-textarea">
                <label for="message">Message:</label>
                <textarea id="message" rows="5" class="form-control" name="message"></textarea>
            </fieldset>
            <div class="form-actions">
                <input type="submit" class="btn btn-primary btn-block btn-ghost" name="send" />
            </div>
        </form>
    </div>
    <div class="footer">
        O le ale strontos, vi gaskar magheda
    </div>
</body>

</html>