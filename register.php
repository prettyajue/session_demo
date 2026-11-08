<?php
require_once "db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (
        empty($username) ||
        empty($email) ||
        empty($password) ||
    ){
        $error = "All fields are required."; 
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    }
    else {

        $stmt = $pdo->prepare(
            "SELECT id FROM users
             WHERE username = ? OR email = ?"
        );

        $stmt->execute([$username, $email]);

        if ($stmt->fetch()) {
            $error = "Username or Email already exists.";
        }
        else {

            $password_hash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $pdo->prepare(
                "INSERT INTO users
                (username, email, password_hash)
                VALUES (?, ?, ?)"
            );

            if (
                $stmt->execute([
                    $username,
                    $email,
                    $password_hash
                ])
            ) {
                $success =
                    "Registration successful! You may now login.";
            }
            else {
                $error = "Registration failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Register | SessionAuthSystem</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
      rel="stylesheet">

<style>

body{
    background: #f0b5f0;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Arial,sans-serif;
}

.register-card{
    width:480px;
    background: #06c1fa;
    padding:40px;
    border-radius:20px;
    box-shadow:0 20px 40px rgba(0,0,0,.15);
}

.brand{
    font-size:30px;
    font-weight:700;
    color: #d95ff1;
}

.subtitle{
    color:#6b7280;
}

.form-control{
    height:50px;
}

.form-control:focus{
    box-shadow:none;
    border-color: #f060f0;
}

.input-group-text{
    width:50px;
    justify-content:center;
    background: #d47aeb;
}

.btn-primary{
    height:50px;
    background: #2259ee;
    border:none;
    font-weight:600;
}

.btn-primary:hover{
    background: #f128f1;
}

.login-link{
    text-decoration:none;
}

</style>
</head>

<body>

<div class="register-card">

    <div class="text-center mb-4">

        <i class="bi bi-shield-lock-fill text-primary"
           style="font-size:50px;"></i>

        <h2 class="brand mt-2">
            SessionAuthSystem
        </h2>

        <p class="subtitle">
            Create your account
        </p>

    </div>

    <?php if(!empty($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">
                Username
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-person"></i>
                </span>

                <input
                    type="text"
                    name="username"
                    class="form-control"
                    placeholder="Enter username"
                    required>

            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">
                Email Address
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Enter email address"
                    required>

            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">
                Password
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Enter password"
                    required>

            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">
            </label>

            <div class="input-group">

            </div>
        </div>

        <button
            type="submit"
            class="btn btn-primary w-100">

            <i class="bi bi-person-plus-fill"></i>
            Create Account

        </button>

    </form>

    <div class="text-center mt-4">

        Already have an account?

        <a href="index.php"
           class="login-link">
           Login Here
        </a>

    </div>

</div>

</body>
</html>