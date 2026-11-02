<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$msg = "";

// Direct Database Connection
$conn = new mysqli("localhost", "root", "", "foodiehub");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = trim($_POST['address']);

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if($check && $check->num_rows > 0) {
        $msg = "Email already registered!";
    } else {
        $sql = "INSERT INTO users (name, email, phone, password, address, role) VALUES ('$name', '$email', '$phone', '$password', '$address', 'user')";
        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            $msg = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - FoodieHub</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background: #f4f5f7; font-family: sans-serif; margin: 0;">
    <div style="background: #fff; padding: 30px; border-radius: 15px; width: 400px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px; color: #ff5e00;">Create Account</h2>
        <?php if($msg != "") { echo "<p style='color:red; font-size:13px; margin-bottom:10px;'>$msg</p>"; } ?>
        <form method="POST" style="display: flex; flex-direction: column; gap: 12px;">
            <input type="text" name="name" placeholder="Full Name" required style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="email" name="email" placeholder="Email Address" required style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="text" name="phone" placeholder="Mobile Number" required style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="password" name="password" placeholder="Password" required style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <textarea name="address" placeholder="Delivery Address" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;"></textarea>
            <button type="submit" style="background: #ff5e00; color: #fff; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer;">Sign Up</button>
        </form>
        <p style="margin-top: 15px; font-size: 13px;">Already have an account? <a href="login.php" style="color: #ff5e00; text-decoration: none; font-weight: 600;">Login</a></p>
    </div>
</body>
</html>