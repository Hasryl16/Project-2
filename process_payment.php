<?php
session_start();
include 'connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in. Please log in to proceed.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $hotel_id = $_POST['hotel_id'] ?? '';
    $room_id = $_POST['room_id'] ?? '';
    $check_in = $_POST['check_in'] ?? '';
    $check_out = $_POST['check_out'] ?? '';
    $price_per_night = $_POST['price_per_night'] ?? 0;
    $total_price = $_POST['total_price'] ?? 0;
    $payment_method = $_POST['payment_method'] ?? '';

    if (empty($hotel_id) || empty($room_id) || empty($check_in) || empty($check_out) || empty($payment_method)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit();
    }

    $conn = getConnection();
    if (!$conn) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
        exit();
    }

    // Generate booking_id
    $query = "SELECT MAX(CAST(SUBSTRING(booking_id, 2) AS UNSIGNED)) AS max_id FROM booking";
    $result = $conn->query($query);
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Failed to generate booking ID.']);
        exit();
    }
    $row = $result->fetch_assoc();
    $next_id = ($row['max_id'] ?? 0) + 1;
    $booking_id = 'B' . str_pad($next_id, 4, '0', STR_PAD_LEFT);

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO booking (booking_id, user_id, hotel_id, status) VALUES (?, ?, ?, 'confirmed')");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare statement failed for booking.']);
        exit();
    }
    $stmt->bind_param("sss", $booking_id, $user_id, $hotel_id);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to insert booking: ' . $stmt->error]);
        exit();
    }

    // Generate detail_id
    $query = "SELECT MAX(CAST(SUBSTRING(detail_id, 2) AS UNSIGNED)) AS max_id FROM booking_detail";
    $result = $conn->query($query);
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Failed to generate detail ID.']);
        exit();
    }
    $row = $result->fetch_assoc();
    $next_id = ($row['max_id'] ?? 0) + 1;
    $detail_id = 'D' . str_pad($next_id, 4, '0', STR_PAD_LEFT);

    // Insert booking_detail
    $stmt = $conn->prepare("INSERT INTO booking_detail (detail_id, booking_id, room_id, check_in, check_out, price_per_night, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare statement failed for booking detail.']);
        exit();
    }
    $stmt->bind_param("sssssdd", $detail_id, $booking_id, $room_id, $check_in, $check_out, $price_per_night, $total_price);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to insert booking detail: ' . $stmt->error]);
        exit();
    }

    // Generate payment_id
    $query = "SELECT MAX(CAST(SUBSTRING(payment_id, 2) AS UNSIGNED)) AS max_id FROM payment";
    $result = $conn->query($query);
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Failed to generate payment ID.']);
        exit();
    }
    $row = $result->fetch_assoc();
    $next_id = ($row['max_id'] ?? 0) + 1;
    $payment_id = 'P' . str_pad($next_id, 4, '0', STR_PAD_LEFT);

    // Insert payment
    $stmt = $conn->prepare("INSERT INTO payment (payment_id, booking_id, amount, payment_method, status) VALUES (?, ?, ?, ?, 'paid')");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare statement failed for payment.']);
        exit();
    }
    $stmt->bind_param("ssds", $payment_id, $booking_id, $total_price, $payment_method);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to insert payment: ' . $stmt->error]);
        exit();
    }

    $conn->close();

    echo json_encode(['success' => true, 'booking_id' => $booking_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
