<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand text-white profile " style="margin-left: 2rem;" href="./profile1.php"><strong><?php session_start(); echo $_SESSION["uname"]; ?></strong></a>
    
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white friends" style="margin-right: 2rem;" href="./friends.php">Friends</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" style="margin-right: 1rem;" href="./logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</body>
</html>