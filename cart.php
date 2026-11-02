<?php
include 'includes/db.php';
session_start();

// Temporary user check (Agar login na ho toh test user ID 1 maan lete hain)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

// Handle item addition or deletion if required
$cart_query = "SELECT cart.id, dishes.title, dishes.price, dishes.image, cart.quantity 
               FROM cart JOIN dishes ON cart.dish_id = dishes.id 
               WHERE cart.user_id = $user_id";
$cart_result = $conn->query($cart_query);
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart - FoodieHub</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="dashboard-container" style="width: 800px; margin: auto; padding: 30px;">
    <div style="width: 100%;">
        <h2><a href="index.php" style="color: #ff5e00; text-decoration: none;"><i class="fa-solid fa-arrow-left"></i></a> Your Food Cart</h2>
        <hr style="margin: 15px 0; border: 0; border-top: 1px solid #eee;">
        
        <?php if($cart_result->num_rows > 0): ?>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <?php while($item = $cart_result->fetch_assoc()): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; background: #fafafa; padding: 15px; border-radius: 12px;">
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <img src="images/<?php echo $item['image']; ?>" width="60" height="60" style="object-fit:cover; border-radius: 8px;" onerror="this.src='https://via.placeholder.com/60';">
                            <div>
                                <h4><?php echo $item['title']; ?></h4>
                                <p style="color: #777; font-size: 13px;">$<?php echo $item['price']; ?> x <?php echo $item['quantity']; ?></p>
                            </div>
                        </div>
                        <strong>$<?php echo number_format($subtotal, 2); ?></strong>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <div style="margin-top: 30px; display: flex; justify-content: space-between; align-items: center;">
                <h3>Total Amount: <span style="color: #ff5e00;">$<?php echo number_format($total, 2); ?></span></h3>
                <a href="checkout.php" style="background: #ff5e00; color: #fff; padding: 12px 25px; border-radius: 10px; text-decoration: none; font-weight: 600;">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <p style="color: #777; text-align: center; padding: 40px;">Your cart is empty! <a href="index.php" style="color: #ff5e00;">Go explore food</a></p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>