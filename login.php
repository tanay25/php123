<link rel="stylesheet" href="style.css">
<?php
session_start();
require "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE email = :email"
    );

    $stmt->execute([":email" => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {

        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["name"] = $user["name"];

        header("Location: dashboard.php");
        exit;

    } else {

        $message = "Invalid email or password.";

    }
}
?>

<h2>User Login</h2>

<p><?= htmlspecialchars($message) ?></p>

<form method="POST">

    <input type="email" name="email"
           placeholder="Email" required>

    <br><br>

    <input type="password" name="password"
           placeholder="Password" required>

    <br><br>

    <button type="submit">Login</button>

</form>

<a href="register.php">Create Account</a>