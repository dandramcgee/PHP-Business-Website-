<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../");
    exit;
}

include '../../config.php';
$query = new Database();

if (!empty($_COOKIE['username']) && !empty($_COOKIE['session_token'])) {
    session_write_close();
    session_id($_COOKIE['session_token']);
    session_start();

    $username = htmlspecialchars($_COOKIE['username'], ENT_QUOTES, 'UTF-8');
    $result = $query->select('users', 'id', "username = '$username'");

    if (!empty($result)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $result[0]['id'];

        header("Location: ../");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $username = strtolower(trim($_POST['username']));
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $user = $query->login($username, $password, 'users');

        if ($user) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            setcookie('username', $username, time() + (86400 * 30), "/", "", true, true);
            setcookie('session_token', session_id(), time() + (86400 * 30), "/", "", true, true);
            echo "<script>window.location.href = '../';</script>";
            exit;
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../assets/css/login_signup.css">
    <script src="../../assets/js/sweetalert2.js"></script>
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (!empty($error_message)) {
            echo "<p style='color:red;'>$error_message</p>";
        } ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required maxlength="30">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required maxlength="255">
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Login</button>
            </div>
        </form>
        <p>Don't have an account? <a href="../signup/">Sign Up</a></p>
    </div>
</body>

</html>