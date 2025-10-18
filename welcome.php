<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome</title>
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #6dd5ed, #2193b0);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.container {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    padding: 40px;
    text-align: center;
}
button {
    background: #e53935;
    border: none;
    color: white;
    padding: 12px 25px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
}
button:hover {
    background: #c62828;
}
</style>
</head>
<body>
<div class="container">
    <h1>🎉 Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
    <p>You’ve successfully logged in.</p>
    <form action="logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>
</div>
</body>
</html>
