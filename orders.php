<?php
include '../includes/db.php';
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../login.php"); exit(); }
if(isset($_POST['update_status'])) {
    $oid = $_POST['order_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE orders SET status='$status' WHERE id=$oid");
}
$orders = $conn->query("SELECT orders.*, users.name FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Manage Orders</title><link rel="stylesheet" href="../css/style.css"></head>
<body style="padding: 30px;">
    <h2><a href="dashboard.php" style="color:#ff5e00; text-decoration:none;">&larr; Dashboard</a> Manage Orders</h2>
    <table style="width:100%; margin-top:20px; border-collapse:collapse; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.02);">
        <tr style="background:#ff5e00; color:#fff; text-align:left;">
            <th style="padding:12px;">ID</th><th>User</th><th>Total</th><th>Address</th><th>Status</th><th>Action</th>
        </tr>
        <?php while($o = $orders->fetch_assoc()): ?>
        <tr style="border-bottom:1px solid #eee;">
            <td style="padding:12px;">#<?php echo $o['id']; ?></td>
            <td><?php echo $o['name']; ?></td>
            <td>$<?php echo $o['total_price']; ?></td>
            <td><?php echo $o['delivery_address']; ?></td>
            <td><?php echo $o['status']; ?></td>
            <td>
                <form method="POST" style="display:flex; gap:5px;">
                    <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
                    <select name="status" style="padding:5px; border-radius:4px; border:1px solid #ddd;">
                        <option value="Pending">Pending</option>
                        <option value="Processing">Processing</option>
                        <option value="Delivered">Delivered</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                    <button type="submit" name="update_status" style="background:#ff5e00; color:#fff; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>