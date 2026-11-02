<?php
include 'includes/db.php';
session_start();

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search != "") {
    $stmt = $conn->prepare("SELECT * FROM dishes WHERE title LIKE ? OR category LIKE ?");
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM dishes LIMIT 8");
}

// Online High-Quality Default Images Array
$default_images = [
    'Biryani' => 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=500',
    'Pizza'   => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=500',
    'Burger'  => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500',
    'Roll'    => 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500',
    'Chicken' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=500',
    'Samosa'  => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodieHub - Order Food Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #f8f9fa; color: #333; }
        nav { display: flex; justify-content: space-between; align-items: center; padding: 15px 50px; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; }
        .logo { font-size: 24px; font-weight: 700; color: #ff5e00; text-decoration: none; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { text-decoration: none; color: #555; font-weight: 500; }
        .btn-signup { background: #ff5e00; color: #fff !important; padding: 8px 18px; border-radius: 20px; }
        .hero { background: linear-gradient(135deg, #ff5e00, #ff8c00); color: #fff; padding: 50px 20px; text-align: center; }
        .hero h1 { font-size: 36px; margin-bottom: 10px; }
        .search-box { display: inline-flex; background: #fff; padding: 6px; border-radius: 30px; width: 100%; max-width: 500px; margin-top: 15px; }
        .search-box input { flex: 1; border: none; padding: 10px 20px; font-size: 15px; outline: none; border-radius: 30px; }
        .search-box button { background: #ff5e00; color: #fff; border: none; padding: 10px 25px; border-radius: 30px; font-weight: 600; cursor: pointer; }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px; }
        .card { background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); transition: 0.3s; display: flex; flex-direction: column; }
        .card:hover { transform: translateY(-5px); }
        .card-img-container { height: 180px; width: 100%; background: #eee; overflow: hidden; position: relative; }
        .card-img-container img { width: 100%; height: 100%; object-fit: cover; }
        .card-body { padding: 15px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .card-title { font-size: 18px; font-weight: 600; color: #222; }
        .card-category { font-size: 13px; color: #777; margin: 5px 0 15px 0; }
        .card-footer { display: flex; justify-content: space-between; align-items: center; }
        .price { font-size: 18px; font-weight: 700; color: #ff5e00; }
        .btn-cart { background: #ff5e00; color: #fff; padding: 8px 14px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 13px; }
        footer { background: #1a1a1a; color: #fff; text-align: center; padding: 25px; margin-top: 50px; }
    </style>
</head>
<body>

    <nav>
        <a href="index.php" class="logo"><i class="fa-solid fa-utensils"></i> FoodieHub</a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="restaurants.php">Restaurants</a>
            <a href="orders.php">My Orders</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="signup.php" class="btn-signup">Sign Up</a>
            <?php endif; ?>
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
        </div>
    </nav>

    <div class="hero">
        <h1>Discover the Best Food Near You</h1>
        <p>Delicious food under ₹500 delivered fresh to your doorstep</p>
        <form method="GET" action="index.php" class="search-box">
            <input type="text" name="search" placeholder="Search pizza, biryani, chicken, roll..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="container">
        <h2 style="margin-bottom: 20px;"><i class="fa-solid fa-fire" style="color: #ff5e00;"></i> Popular Dishes</h2>
        <div class="grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): 
                    $cat = $row['category'];
                    $img_src = isset($default_images[$cat]) ? $default_images[$cat] : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500';
                ?>
                    <div class="card">
                        <div class="card-img-container">
                            <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="card-title"><?php echo htmlspecialchars($row['title']); ?></div>
                                <div class="card-category">Category: <?php echo htmlspecialchars($row['category']); ?></div>
                            </div>
                            <div class="card-footer">
                                <span class="price">₹<?php echo number_format($row['price'], 2); ?></span>
                                <a href="cart.php?action=add&id=<?php echo $row['id']; ?>" class="btn-cart">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No food found. Try searching Biryani, Pizza, Burger, or Roll.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p>FoodieHub - Good Food, Good Mood!</p>
        <p style="font-size: 12px; margin-top: 5px;">&copy; 2026 FoodieHub. All Rights Reserved.</p>
    </footer>

</body>
</html>