<?php
include '../includes/db.php';
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
$rest_count = $conn->query("SELECT COUNT(*) as count FROM restaurants")->fetch_assoc()['count'];
$dish_count = $conn->query("SELECT COUNT(*) as count FROM dishes")->fetch_assoc()['count'];
$order_count = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - FoodieHub</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body style="padding: 30px;">
    <h2>Admin Dashboard</h2>
    <div style="display: flex; gap: 20px; margin-top: 20px;">
        <div style="background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); width:200px;">
            <h4>Total Restaurants</h4>
            <p style="font-size:24px; color:#ff5e00; font-weight:bold;"><?php echo $rest_count; ?></p>
        </div>
        <div style="background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); width:200px;">
            <h4>Total Dishes</h4>
            <p style="font-size:24px; color:#ff5e00; font-weight:bold;"><?php echo $dish_count; ?></p>
        </div>
        <div style="background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); width:200px;">
            <h4>Total Orders</h4>
            <p style="font-size:24px; color:#ff5e00; font-weight:bold;"><?php echo $order_count; ?></p>
        </div>
    </div>
    <div style="margin-top: 30px; display: flex; gap: 15px;">
        <a href="add_restaurant.php" style="background:#ff5e00; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none;">Add Restaurant</a>
        <a href="add_dish.php" style="background:#ff5e00; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none;">Add Dish</a>
        <a href="orders.php" style="background:#333; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none;">Manage Orders</a>
        <a href="../logout.php" style="background:red; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none;">Logout</a>
    </div>
</body>
</html>