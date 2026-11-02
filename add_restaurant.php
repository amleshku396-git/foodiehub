<?php
include '../includes/db.php';
session_start();

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $cuisine = trim($_POST['cuisine']);
    $rating = trim($_POST['rating']);
    $reviews_count = trim($_POST['reviews_count']);
    $offer_tag = trim($_POST['offer_tag']);
    $distance = trim($_POST['distance']);
    $image = trim($_POST['image']); // Image filename e.g., 'dominos.jpg'

    $sql = "INSERT INTO restaurants (name, cuisine, rating, reviews_count, offer_tag, distance, image) 
            VALUES ('$name', '$cuisine', '$rating', '$reviews_count', '$offer_tag', '$distance', '$image')";
    
    if ($conn->query($sql) === TRUE) {
        $msg = "Restaurant added successfully!";
    } else {
        $msg = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Restaurant - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body style="justify-content: center; align-items: center;">
    <div style="background: #fff; padding: 30px; border-radius: 20px; width: 450px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px; color: #ff5e00;">Add New Restaurant</h2>
        <?php if($msg != "") { echo "<p style='color:green; font-size:13px; margin-bottom:10px;'>$msg</p>"; } ?>
        <form method="POST" style="display: flex; flex-direction: column; gap: 12px;">
            <input type="text" name="name" placeholder="Restaurant Name (e.g. Domino's Pizza)" required style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="text" name="cuisine" placeholder="Cuisine Type (e.g. Pizza, Burger)" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="text" name="rating" placeholder="Rating (e.g. 4.8)" value="4.5" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="number" name="reviews_count" placeholder="Reviews Count (e.g. 500)" value="100" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="text" name="offer_tag" placeholder="Offer Tag (e.g. Buy 2 get 1 free)" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="text" name="distance" placeholder="Distance (e.g. 2.8 km)" style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <input type="text" name="image" placeholder="Image Filename (e.g. dominos.jpg)" required style="padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            <button type="submit" style="background: #ff5e00; color: #fff; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer;">Add Restaurant</button>
        </form>
        <p style="margin-top: 15px; font-size: 13px;"><a href="../index.php" style="color: #ff5e00;">&larr; Back to Home</a></p>
    </div>
</body>
</html>