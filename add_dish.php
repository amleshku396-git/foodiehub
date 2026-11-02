<?php
include '../includes/db.php';
session_start();

$msg = "";
// Restaurants ki list fetch karenge dropdown ke liye
$restaurants = $conn->query("SELECT * FROM restaurants");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $restaurant_id = $_POST['restaurant_id'];
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $price = trim($_POST['price']);
    $prep_time = trim($_POST['prep_time']);
    $offer_tag = trim($_POST['offer_tag']);
    $image = trim($_POST['image']);

    $sql = "INSERT INTO dishes (restaurant_id, title, category, price, prep_time, offer_tag, image) 
            VALUES ('$restaurant_id', '$title', '$category', '$price', '$prep_time', '$offer_tag', '$image')";
    
    if ($conn->query($sql) === TRUE) {
        $msg = "Dish added successfully!";
    } else {
        $msg = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Dish - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body style="justify-content: center; align-items: center;">
    <div style="background: #fff; padding: 30px; border-radius: 20px; width: 450px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px; color: #ff5e00;">Add Food Dish</h2>
        <?php if($msg != "") { echo "<p style='color:green; font-size:13px; margin-bottom:10px;'>$msg</p>"; } ?>
        <form method="POST" style="display: flex; flex-direction: column; gap: 12px;">
            <select name="restaurant_id" required style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                <option value="">Select Restaurant</option>
                <?php while($r = $restaurants->fetch_assoc()): ?>
                    <option value="<?php echo $r['id']; ?>"><?php echo $r['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <input type="text" name="title" placeholder="Dish Title (e.g. Zing N Fries Meal)" required style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="text" name="category" placeholder="Category (e.g. Burger, Pizza)" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="number" step="0.01" name="price" placeholder="Price (e.g. 12.99)" required style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="text" name="prep_time" placeholder="Prep Time (e.g. 45-55 min)" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="text" name="offer_tag" placeholder="Offer Tag (e.g. $1.99 Delivery)" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="text" name="image" placeholder="Image Filename (e.g. zing_fries.jpg)" required style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <button type="submit" style="background: #ff5e00; color: #fff; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer;">Add Dish</button>
        </form>
        <p style="margin-top: 15px; font-size: 13px;"><a href="../index.php" style="color: #ff5e00;">&larr; Back to Home</a></p>
    </div>
</body>
</html>