<?php
session_start();

$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "";      // Your MySQL password
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        header("Location: map.html");
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body style="background-image: url('images/lock.jpg'); background-size: cover; background-position: center; margin: 0; padding: 0; height: 100vh; display: flex; justify-content: center; align-items: center; font-family: Arial, sans-serif; color: #f0e6a1;">
    <form method="post" action="" style="background-color: rgba(0, 0, 0, 0.7); padding: 20px; border-radius: 8px; width: 300px; text-align: center;">
        <label for="username" style="color: #f0e6a1; display: block; margin-bottom: 8px;">Username:</label>
        <input type="text" name="username" required style="padding: 8px; margin: 5px 0 15px 0; border: 1px solid #ccc; border-radius: 4px; width: calc(100% - 16px);"><br><br>
        <label for="password" style="color: #f0e6a1; display: block; margin-bottom: 8px;">Password:</label>
        <input type="password" name="password" required style="padding: 8px; margin: 5px 0 15px 0; border: 1px solid #ccc; border-radius: 4px; width: calc(100% - 16px);"><br><br>
        <input type="submit" value="Login" style="padding: 10px; border: none; border-radius: 4px; background-color: #4CAF50; color: white; cursor: pointer; width: 100%;"><br><br>
        <a href="signup.php" style="color: #e6f0ff; text-decoration: none; display: block; margin-top: 10px;">Signup</a>
    </form>
</body>
</html>
