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
        <div>
            <h1>Account</h1>
            <div class="card">
                <header class="card-header">Someone</header>
                <header class="card-header">someone.ao@gmail.com</header>
            </div>
        </div>
        <br><br>
        <div>
            <h1>Messages</h1>
            <div class="card">
                <header class="card-header">To: Someone</header>
                <header class="card-header">Lorem Ipsum</header>
                <div class="card-content">
                    <div class="inner">Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio iure vitae dicta rerum natus, vero laudantium veritatis. Laboriosam iste unde quis alias dignissimos aliquam dolorum officia suscipit. Eius, fugit tenetur.</div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="alert alert-warning">No messages found.</div> -->
</body>

</html>