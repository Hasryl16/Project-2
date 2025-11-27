<?php
include 'connection.php';
session_start();

$hotel_id = isset($_GET['hotel_id']) ? $_GET['hotel_id'] : 'H0001'; 

$conn = getConnection();


$query = "SELECT * FROM hotel WHERE hotel_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $hotel_id);
$stmt->execute();
$result = $stmt->get_result();
$hotel = $result->fetch_assoc();


$query_rooms = "SELECT * FROM room WHERE hotel_id = ? AND availability = 1 ORDER BY price";
$stmt_rooms = $conn->prepare($query_rooms);
$stmt_rooms->bind_param("s", $hotel_id);
$stmt_rooms->execute();
$result_rooms = $stmt_rooms->get_result();
$rooms = [];
while ($row = $result_rooms->fetch_assoc()) {
    $rooms[] = $row;
}

$conn->close();


if (!$hotel) {
    header("Location: hotels.php");
    exit();
}


$min_price = !empty($rooms) ? min(array_column($rooms, 'price')) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($hotel['hotel_name']); ?> - Details</title>
    
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    
    <link rel="stylesheet" href="styles/custom.css">
</head>
<body>
    <div class="bg-light min-vh-100">
       
        <?php include 'header.php'; ?>
        <div class="container mt-4">
            <div class="row g-2">
                <div class="col-md-8">
                    <img
                        id="mainImage"
                        src="<?php echo htmlspecialchars($hotel['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($hotel['hotel_name']); ?>"
                        class="img-fluid w-100 rounded"
                        style="height: 500px; object-fit: cover;"
                    />
                </div>
                <div class="col-md-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <img
                                src="https://images.unsplash.com/photo-1655292912612-bb5b1bda9355?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxob3RlbCUyMHJvb20lMjBtb2Rlcm58ZW58MXx8fHwxNzYwNDk3Njc2fDA&ixlib=rb-4.1.0&q=80&w=1080"
                                alt="Hotel room"
                                class="img-fluid w-100 rounded gallery-thumb"
                                style="height: 120px; object-fit: cover; cursor: pointer;"
                                onclick="changeImage(this.src)"
                            />
                        </div>
                        <div class="col-6">
                            <img
                                src="https://images.unsplash.com/photo-1570214476695-19bd467e6f7a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxob3RlbCUyMHBvb2wlMjByZXNvcnR8ZW58MXx8fHwxNzYwNDY5MDcxfDA&ixlib=rb-4.1.0&q=80&w=1080"
                                alt="Hotel pool"
                                class="img-fluid w-100 rounded gallery-thumb"
                                style="height: 120px; object-fit: cover; cursor: pointer;"
                                onclick="changeImage(this.src)"
                            />
                        </div>
                        <div class="col-6">
                            <img
                                src="https://images.unsplash.com/photo-1543539571-2d88da875d21?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxob3RlbCUyMHJlc3RhdXJhbnQlMjBkaW5pbmd8ZW58MXx8fHwxNzYwNDU0MzkyfDA&ixlib=rb-4.1.0&q=80&w=1080"
                                alt="Hotel restaurant"
                                class="img-fluid w-100 rounded gallery-thumb"
                                style="height: 120px; object-fit: cover; cursor: pointer;"
                                onclick="changeImage(this.src)"
                            />
                        </div>
                        <div class="col-6">
                            <img
                                src="https://images.unsplash.com/photo-1703135387362-4b749023e1e1?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxob3RlbCUyMHNwYSUyMGx1eHVyeXxlbnwxfHx8fDE3NjA0NTkyNjZ8MA&ixlib=rb-4.1.0&q=80&w=1080"
                                alt="Hotel spa"
                                class="img-fluid w-100 rounded gallery-thumb"
                                style="height: 120px; object-fit: cover; cursor: pointer;"
                                onclick="changeImage(this.src)"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container my-5">
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Hotel Header -->
                    <div class="bg-white p-4 rounded shadow-sm mb-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h1 class="mb-2"><?php echo htmlspecialchars($hotel['hotel_name']); ?></h1>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-3">
                                        <?php
                                        $rating = $hotel['star_rating'];
                                        $full_stars = floor($rating);
                                        $half_star = ($rating - $full_stars) >= 0.5 ? 1 : 0;
                                        $empty_stars = 5 - $full_stars - $half_star;
                                        echo str_repeat('<i class="bi bi-star-fill text-warning"></i>', $full_stars);
                                        if ($half_star) echo '<i class="bi bi-star-half text-warning"></i>';
                                        echo str_repeat('<i class="bi bi-star text-warning"></i>', $empty_stars);
                                        ?>
                                    </div>
                                    <span class="badge bg-primary"><?php echo htmlspecialchars($rating); ?> (324 reviews)</span>
                                </div>
                                <div class="d-flex align-items-center text-muted">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    <span><?php echo htmlspecialchars($hotel['address']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white p-4 rounded shadow-sm mb-4">
                        <h3 class="mb-3">About This Hotel</h3>
                        <p>
                            Experience luxury at its finest at the Grand Royale Hotel & Resort. Located on the pristine beaches of Miami, 
                            our 5-star resort offers world-class amenities, breathtaking ocean views, and unparalleled service. 
                            Each room is elegantly designed with modern furnishings and state-of-the-art technology.
                        </p>
                        <p>
                            Indulge in our award-winning restaurants, relax by the infinity pool, or rejuvenate at our full-service spa. 
                            Whether you're here for business or pleasure, we guarantee an unforgettable stay.
                        </p>
                    </div>

                    <!-- Amenities -->
                    <div class="bg-white p-4 rounded shadow-sm mb-4">
                        <h3 class="mb-3">Facilities</h3>
                        <div class="row">
                            
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">✓ Free WiFi</li>
                                <li class="list-group-item">✓ Swimming Pool</li>
                                <li class="list-group-item">✓ Fitness Center</li>
                                <li class="list-group-item">✓ Spa & Wellness</li>
                                <li class="list-group-item">✓ Airport Shuttle</li>
                            </ul>
                            </section>
                        </div>
                    </div>

                    <!-- Room Types -->
                    <div class="bg-white p-4 rounded shadow-sm mb-4">
                        <h3 class="mb-3">Room Types</h3>
                        <div class="row">
                            <?php foreach ($rooms as $room): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($room['room_type']); ?></h5>
                                            <p class="card-text text-muted"><?php echo htmlspecialchars($room['description'] ?? 'Comfortable accommodation'); ?></p>
                                            <ul class="list-unstyled">
                                                <li>✓ <?php echo htmlspecialchars($room['bed_type'] ?? 'Standard Bed'); ?></li>
                                                <li>✓ <?php echo htmlspecialchars($room['view'] ?? 'City View'); ?></li>
                                                <li>✓ <?php echo htmlspecialchars($room['size'] ?? '300'); ?> sq ft</li>
                                            </ul>
                                            <div class="mt-3">
                                                <span class="h4 text-primary">$<?php echo htmlspecialchars($room['price']); ?></span>
                                                <span class="text-muted"> / night</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Reviews -->
                    <div class="bg-white p-4 rounded shadow-sm mb-4">
                        <h3 class="mb-4">Guest Reviews</h3>
                        
                        <!-- Review 1 -->
                        <div class="mb-4 pb-4 border-bottom">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                     style="width: 50px; height: 50px;">
                                    SJ
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="mb-1">Sarah Johnson</h5>
                                            <small class="text-muted">October 10, 2025</small>
                                        </div>
                                        <div>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                        </div>
                                    </div>
                                    <p class="mb-0">Absolutely stunning hotel! The service was impeccable and the room was spacious and clean. The pool area was beautiful and the breakfast buffet had amazing variety.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Review 2 -->
                        <div class="mb-4 pb-4 border-bottom">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                     style="width: 50px; height: 50px;">
                                    MC
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="mb-1">Michael Chen</h5>
                                            <small class="text-muted">October 5, 2025</small>
                                        </div>
                                        <div>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                        </div>
                                    </div>
                                    <p class="mb-0">Perfect location and excellent amenities. Staff went above and beyond to make our stay comfortable. Highly recommend!</p>
                                </div>
                            </div>
                        </div>

                        <!-- Review 3 -->
                        <div class="mb-4 pb-4 border-bottom">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                     style="width: 50px; height: 50px;">
                                    ER
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="mb-1">Emma Rodriguez</h5>
                                            <small class="text-muted">September 28, 2025</small>
                                        </div>
                                        <div>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>
                                        </div>
                                    </div>
                                    <p class="mb-0">Great hotel with beautiful decor. The only minor issue was the wifi speed, but everything else was perfect. Would definitely stay again.</p>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-outline-primary">View All Reviews</button>
                    </div>

                    <!-- Map -->
                    <div class="bg-white p-4 rounded shadow-sm mb-4">
                        <h3 class="mb-3">Location</h3>
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                            <div class="text-center text-muted">
                                <i class="bi bi-geo-alt" style="font-size: 48px;"></i>
                                <p class="mt-2">Map integration would go here</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Booking Card -->
                <div class="col-lg-4">
                    <div class="card shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <h3 class="mb-0 text-primary">$<?php echo htmlspecialchars($min_price); ?></h3>
                                    <small class="text-muted">per night</small>
                                </div>
                                <span class="badge bg-success">Available</span>
                            </div>

                            <form id="bookingForm">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bi bi-calendar me-2"></i>
                                        Check-in
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="checkIn"
                                        required
                                    />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bi bi-calendar me-2"></i>
                                        Check-out
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="checkOut"
                                        required
                                    />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bi bi-house me-2"></i>
                                        Room Type
                                    </label>
                                    <select class="form-control" id="roomType" required>
                                        <option value="">Select Room Type</option>
                                        <?php foreach ($rooms as $room): ?>
                                            <option value="<?php echo htmlspecialchars($room['room_id']); ?>" data-price="<?php echo htmlspecialchars($room['price']); ?>">
                                                <?php echo htmlspecialchars($room['room_type']); ?> - $<?php echo htmlspecialchars($room['price']); ?>/night
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-3">
                                    <i class="bi bi-credit-card me-2"></i>
                                    Reserve Now
                                </button>
                            </form>

                            <hr />
                                <div class="alert alert-info mt-3 mb-0" role="alert">
                                <small>✓ Free cancellation within 24 hours</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include 'footer.php'; ?>

        <!-- Payment Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="bookingSummary">
                            <!-- Summary will be populated by JS -->
                        </div>
                        <form id="paymentForm">
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" value="credit_card" required>
                                    <label class="form-check-label" for="creditCard">
                                        Credit Card
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="debitCard" value="debit_card">
                                    <label class="form-check-label" for="debitCard">
                                        Debit Card
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="cash" value="cash">
                                    <label class="form-check-label" for="cash">
                                        Cash on Arrival
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmPayment">Confirm Payment</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Custom JavaScript -->
    <script>
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const checkIn = document.getElementById('checkIn').value;
            const checkOut = document.getElementById('checkOut').value;
            const roomSelect = document.getElementById('roomType');
            const roomId = roomSelect.value;
            const roomPrice = parseFloat(roomSelect.options[roomSelect.selectedIndex].getAttribute('data-price'));

            if (!checkIn || !checkOut || !roomId) {
                alert('Please fill in all fields.');
                return;
            }

            const checkInDate = new Date(checkIn);
            const checkOutDate = new Date(checkOut);
            const nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
            const totalPrice = nights * roomPrice;

            const roomType = roomSelect.options[roomSelect.selectedIndex].text.split(' - ')[0];

            const summary = `
                <p><strong>Check-in:</strong> ${checkIn}</p>
                <p><strong>Check-out:</strong> ${checkOut}</p>
                <p><strong>Room Type:</strong> ${roomType}</p>
                <p><strong>Nights:</strong> ${nights}</p>
                <p><strong>Price per Night:</strong> $${roomPrice}</p>
                <p><strong>Total Price:</strong> $${totalPrice}</p>
            `;

            document.getElementById('bookingSummary').innerHTML = summary;

            // Store data for payment
            window.bookingData = {
                hotel_id: '<?php echo $hotel_id; ?>',
                room_id: roomId,
                check_in: checkIn,
                check_out: checkOut,
                price_per_night: roomPrice,
                total_price: totalPrice
            };

            const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            modal.show();
        });

        document.getElementById('confirmPayment').addEventListener('click', function() {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
            if (!paymentMethod) {
                alert('Please select a payment method.');
                return;
            }

            const data = {
                ...window.bookingData,
                payment_method: paymentMethod.value
            };

            fetch('process_payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams(data)
            })
            .then(async response => {
                let text = await response.text();
                let result;
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error('Invalid JSON from server:', text);
                    alert('Server error: ' + text);
                    return;
                }
                console.log('Payment response:', result);
                if (result.success) {
                    alert('Payment successful! Booking ID: ' + result.booking_id);
                    bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
                    // Optionally redirect or refresh
                } else {
                    alert('Payment failed: ' + result.message);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('An error occurred during payment (network or server error).');
            });
        });
    </script>
</body>
</html>
