<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodieHub - Food Delivery</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav style="display: flex; justify-content: space-between; align-items: center; padding: 20px 50px; background: #fff; border-bottom: 1px solid #eee;">
        <h2 style="color: #ff5e00;"><a href="index.php" style="text-decoration:none; color:#ff5e00;">FoodieHub</a></h2>
        <div style="display: flex; gap: 20px; align-items: center; font-weight: 500;">
            <a href="index.php" style="text-decoration: none; color: #333;">Home</a>
            <a href="restaurants.php" style="text-decoration: none; color: #333;">Restaurants</a>
            <a href="orders.php" style="text-decoration: none; color: #333;">My Orders</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" style="text-decoration: none; color: red;">Logout</a>
            <?php else: ?>
                <a href="login.php" style="text-decoration: none; color: #333;">Login</a>
                <a href="signup.php" style="text-decoration: none; background: #ff5e00; color: #white; padding: 8px 15px; border-radius: 8px; color:#fff;">Sign Up</a>
            <?php endif; ?>
            <a href="cart.php" style="text-decoration: none; color: #ff5e00; font-size: 18px;"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
        </div>
    </nav>