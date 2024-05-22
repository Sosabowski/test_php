<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
<div class="login-container">



    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_POST["user"];
        $password = $_POST["password"];
        if (empty($user) || empty($password)) {
            echo "EMPTY";
        } else if ($user == "foo" && $password == "foo123") {
            echo "OK";
        } else {
            echo "ERROR";
        }



    } else {
        ?>
        <form method="post">
            <label for="user">User:</label>
            <input type="text" id="user" name="user">
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <input type="submit" value="Login">
        </form>
    <?php } ?>
</div>
</body>
