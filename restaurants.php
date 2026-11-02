<?php
include 'includes/db.php';
session_start();

$result = $conn->query("SELECT * FROM restaurants");

$rest_images = [
    "Domino's Pizza" => 'https://images.unsplash.com/photo-1590947132387-155cc02f3212?w=500',
    "Pizza Hut"      => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=500',
    "Burger King"    => 'https://images.unsplash.com/photo-1550547660-d9450f859349?w=500',
    "KFC"            => 'https://images.unsplash.com/photo-1513639776629-7b61b0ac49cb?w=500'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurants - FoodieHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #f8f9fa; color: #333; }
        nav { display: flex; justify-content: space-between; align-items: center; padding: 15px 50px; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .logo { font-size: 24px; font-weight: 700; color: #ff5e00; text-decoration: none; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { text-decoration: none; color: #555; font-weight: 500; }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 25px; }
        .card { background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); }
        .card-img-container { height: 160px; width: 100%; background: #eee; }
        .card-img-container img { width: 100%; height: 100%; object-fit: cover; }
        .card-body { padding: 15px; }
        .card-title { font-size: 18px; font-weight: 600; color: #222; margin-bottom: 5px; }
        .info { font-size: 13px; color: #666; display: flex; justify-content: space-between; margin-top: 10px; }
    </style>
</head>
<body>

    <nav>
        <a href="index.php" class="logo"><i class="fa-solid fa-utensils"></i> FoodieHub</a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="restaurants.php" style="color: #ff5e00;">Restaurants</a>
            <a href="orders.php">My Orders</a>
            <a href="cart.php">Cart</a>
        </div>
    </nav>

    <div class="container">
        <h2 style="margin-bottom: 25px;">All Restaurants</h2>
        <div class="grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): 
                    $rname = $row['name'];
                    $rimg = isset($rest_images[$rname]) ? $rest_images[$rname] : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=500';
                ?>
                    <div class="card">
                        <div class="card-img-container">
                            <img src="<?php echo $rimg; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        </div>
                        <div class="card-body">
                            <div class="card-title"><?php echo htmlspecialchars($row['name']); ?></div>
                            <div style="font-size: 13px; color: #888;"><?php echo htmlspecialchars($row['cuisine'] ?? 'Fast Food'); ?></div>
                            <div class="info">
                                <span><i class="fa-solid fa-star" style="color: #ffc107;"></i> <?php echo htmlspecialchars($row['rating']); ?></span>
                                <span><i class="fa-solid fa-location-dot" style="color: #ff5e00;"></i> <?php echo htmlspecialchars($row['distance']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>