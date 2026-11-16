<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<h1>Welcome to Dashboard</h1>

<h2>
    Hello, <?= htmlspecialchars($_SESSION["name"]) ?>
</h2>

<p>You have successfully logged in.</p>

<a href="logout.php">Logout</a>