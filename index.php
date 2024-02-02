<?php
    session_start();
    if (!empty($_SESSION['google_is_logged_in'])):
        $user = $_SESSION['google_user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?= $user->name ?></title>
</head>
<body>
    <br><br><br><br>
    <center>
        <img src="<?= $user->picture ?>" alt="" width="200" style="border-radius: 50%;">
        <h3>Welcome <?= $user->name ?></h3>
        <p>Welcome <?= $user->email ?></p>
        <button onclick="window.location.href = '/gauth.php?logout=true';">Logout</button>
    </center>
</body>
</html>    
<?php
    exit;
    endif;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login With Google</title>
</head>
<body>
    <br><br><br><br>
    <center>
        <button onclick="window.location.href = '/gauth.php';" style="font-size:16px; padding:8px;">Login With Google</button>
    </center>
</body>
</html>
