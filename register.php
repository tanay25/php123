<link rel="stylesheet" href="style.css">
<?php
session_start();
require "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email address.";
    } elseif (strlen($password) < 8) {
        $message = "Password must contain at least 8 characters.";
    } else {

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        try {
            $sql = "INSERT INTO users (name,email,password)
                    VALUES (:name,:email,:password)";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ":name" => $name,
                ":email" => $email,
                ":password" => $hashedPassword
            ]);

            $message = "Registration successful!";

        } catch(PDOException $e) {
            $message = "Email already registered or registration failed.";
        }
    }
}
?>

<h2>User Registration</h2>

<p><?= htmlspecialchars($message) ?></p>

<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <br><br>

    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <input type="password" name="password"
           placeholder="Password" required>
    <br><br>

    <button type="submit">Register</button>
</form>

<a href="login.php">Already registered? Login</a>