<?php
include '../includes/db.php';
session_start();
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $res = $conn->query("SELECT * FROM users WHERE email='$email' AND role='admin'");
    if($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = 'admin';
            header("Location: dashboard.php");
            exit();
        } else { $msg = "Invalid password!"; }
    } else { $msg = "Admin not found!"; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Admin Login</title><link rel="stylesheet" href="../css/style.css"></head>
<body style="justify-content: center; align-items: center; display: flex; height: 100vh;">
    <div style="background:#fff; padding:30px; border-radius:20px; width:380px; box-shadow:0 4px 15px rgba(0,0,0,0.05);">
        <h2 style="color:#ff5e00; margin-bottom:15px;">Admin Login</h2>
        <?php if($msg != "") echo "<p style='color:red; font-size:13px;'>$msg</p>"; ?>
        <form method="POST" style="display:flex; flex-direction:column; gap:12px;">
            <input type="email" name="email" placeholder="Admin Email" required style="padding:10px; border:1px solid #ddd; border-radius:8px;">
            <input type="password" name="password" placeholder="Password" required style="padding:10px; border:1px solid #ddd; border-radius:8px;">
            <button type="submit" style="background:#ff5e00; color:#fff; padding:12px; border:none; border-radius:8px; cursor:pointer; font-weight:600;">Login</button>
        </form>
    </div>
</body>
</html>