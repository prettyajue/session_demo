<?php
session_start();
require_once "db.php";

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password_hash"])) {

        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SessionAuthSystem</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f9eefa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .login-card {
            width: 420px;
            background: #f7a9e3;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .brand {
            color: #e26ef1;
            font-weight: bold;
        }

        .btn-primary {
            background: #f05edc;
            border: none;
        }

        .btn-primary:hover {
            background: #b453af;
        }
    </style>
</head>
<body>

<div class="login-card">

    <div class="text-center mb-4">
        <h3 class="brand">SessionAuthSystem</h3>
        <p class="text-secondary">Sign in to your account</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label class="form-label">Username</label>
        <input
            type="text"
            name="username"
            class="form-control mb-3"
            required
        >

        <label class="form-label">Password</label>
        <input
            type="password"
            name="password"
            class="form-control mb-4"
            required
        >

        <button type="submit" class="btn btn-primary w-100">
            Login
        </button>

    </form>

    <p class="text-center mt-4">
        Don't have an account?
        <a href="register.php">Register here</a>
    </p>

</div>

</body>
</html>