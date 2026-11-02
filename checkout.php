<?php
include 'includes/db.php';
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = trim($_POST['address']);
    
    // Cart se items fetch karein
    $cart_query = "SELECT cart.dish_id, cart.quantity, dishes.price FROM cart JOIN dishes ON cart.dish_id = dishes.id WHERE cart.user_id = $user_id";
    $cart_result = $conn->query($cart_query);
    
    if ($cart_result->num_rows > 0) {
        $total_price = 0;
        $items = [];
        while($row = $cart_result->fetch_assoc()) {
            $total_price += $row['price'] * $row['quantity'];
            $items[] = $row;
        }
        
        // Orders table me insert karein
        $conn->query("INSERT INTO orders (user_id, total_price, delivery_address, status) VALUES ($user_id, $total_price, '$address', 'Pending')");
        $order_id = $conn->insert_id;
        
        // Order items table me insert karein
        foreach($items as $item) {
            $dish_id = $item['dish_id'];
            $qty = $item['quantity'];
            $price = $item['price'];
            $conn->query("INSERT INTO order_items (order_id, dish_id, quantity, price) VALUES ($order_id, $dish_id, $qty, $price)");
        }
        
        // Cart ko clear kar dein
        $conn->query("DELETE FROM cart WHERE user_id = $user_id");
        
        header("Location: orders.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - FoodieHub</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="justify-content: center; align-items: center;">
    <div style="background: #fff; padding: 30px; border-radius: 20px; width: 400px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px; color: #ff5e00;">Checkout</h2>
        <form method="POST" style="display: flex; flex-direction: column; gap: 12px;">
            <textarea name="address" placeholder="Enter Delivery Address" required style="padding: 10px; border: 1px solid #ddd; border-radius: 8px; height: 100px;"></textarea>
            <button type="submit" style="background: #ff5e00; color: #fff; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer;">Place Order</button>
        </form>
        <p style="margin-top: 15px; font-size: 13px;"><a href="cart.php" style="color: #ff5e00;">&larr; Back to Cart</a></p>
    </div>
</body>
</html>