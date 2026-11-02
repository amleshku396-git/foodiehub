<?php
include 'includes/db.php';
$restaurant_id = isset($_GET['restaurant_id']) ? intval($_GET['restaurant_id']) : 0;
$rest = $conn->query("SELECT * FROM restaurants WHERE id = $restaurant_id")->fetch_assoc();
$dishes = $conn->query("SELECT * FROM dishes WHERE restaurant_id = $restaurant_id");
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title><?php echo $rest ? $rest['name'] : 'Menu'; ?> - FoodieHub</title><link rel="stylesheet" href="css/style.css"></head>
<body style="padding: 30px;">
    <h2><a href="index.php" style="color:#ff5e00; text-decoration:none;">&larr; Home</a> <?php echo $rest ? $rest['name'] : 'Restaurant Menu'; ?></h2>
    <div class="dishes-grid" style="margin-top:20px;">
        <?php while($dish = $dishes->fetch_assoc()): ?>
            <div class="card">
                <img src="images/<?php echo $dish['image']; ?>" class="card-img" alt="<?php echo $dish['title']; ?>">
                <div class="card-title"><?php echo $dish['title']; ?></div>
                <div class="card-info"><span>$<?php echo $dish['price']; ?></span><span><?php echo $dish['prep_time']; ?></span></div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>