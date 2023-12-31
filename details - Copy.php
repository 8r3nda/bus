<?php

include 'include/header.php';
if(isset($_GET['id'])){
    $bus_id_get = $_GET['id'];

    $bus_check_query = "SELECT * FROM _all_bus WHERE id='$bus_id_get' LIMIT 1";
    $result = mysqli_query($conn, $bus_check_query);
    $bus = mysqli_fetch_assoc($result);
    $booked_seat_query = "SELECT * FROM invoice_temp WHERE bus_id='$bus_id_get'";
    $all_data = mysqli_query($conn, $bus_check_query);
}

if(isset($_POST['book']) && isset($_GET['date'])){
    $jdate =  date('Y-m-d', strtotime($_GET['date']));
    $seat_count = $_POST['count'];
    $selected_seats = $_POST['selected'];
    $remove_comma = str_replace(',', '', $selected_seats);
    $booking_time = $_POST['time'];
    $selected_seat = str_split($remove_comma, 2);
    $bus_id = $bus['id'];
    $user_id = $user['id'];
    $ticket_id = uniqid();
    $invoice_numb_q = "SELECT MAX(invoice_numb) FROM all_invoice LIMIT 1";
    $max_result = mysqli_query($conn, $invoice_numb_q);
    $max_invoice_numb = mysqli_fetch_assoc($max_result);
    $invoice_numb = $max_invoice_numb['MAX(invoice_numb)']+1;
    for($i = 0; $i<$seat_count; $i++){
        $invoice_temp = "INSERT INTO invoice_temp (bus_id,user_id,seat_number,reserving_time,date_journey,ticket_id,invoice_numb) VALUES('$bus_id','$user_id','$selected_seat[$i]','$booking_time','$jdate','$ticket_id','$invoice_numb')";
        mysqli_query($conn, $invoice_temp);
        $all_invoice = "INSERT INTO all_invoice (bus_id,user_id,seat_number,reserving_time,date_journey,ticket_id,invoice_numb) VALUES('$bus_id','$user_id','$selected_seat[$i]','$booking_time','$jdate','$ticket_id','$invoice_numb')";
        mysqli_query($conn, $all_invoice);
    }
    header('location: invoice.php?invoice='.$invoice_numb);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="vendor/css/style.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.css">
</head>
<body>

<!-- Primary Navigation
             ============================================= -->
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light bd-navbar shadow p-3 mb-5 bg-primary rounded">
    <div class="container">
        <div class="logo">
            <a href="index.html" title="EBus"><img src="img/logo.png" alt="" width="85" ></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <h6><a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a></h6>
                </li>
                <li class="nav-item">
                    <h6><a class="nav-link " href="#">All Bus Route</a></h6>
                </li>
                <li class="nav-item">
                    <h6><a class="nav-link " href="#">Login</a></h6>
                </li>
            </ul>
        </div>
    </div>
</nav>
<br>
<br>
<br>
<!-- Primary Navigation end -->
<br>
<br>
<br>
<section class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="bg-light shadow-md rounded p-3 p-sm-4 confirm-details">
                <h2 class="text-6 mb-3">Confirm Bus Details</h2>
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center trip-title">
                            <div class="col-5 col-sm-auto text-center text-sm-left">
                                <h5 class="m-0 trip-place">Mumbai</h5>
                            </div>
                            <div class="col-2 col-sm-auto text-8 text-black-50 text-center trip-arrow">➝</div>
                            <div class="col-5 col-sm-auto text-center text-sm-left">
                                <h5 class="m-0 trip-place">Surat</h5>
                            </div>
                            <div class="col-12 mt-1 d-block d-md-none"></div>
                            <div class="col-6 col-sm col-md-auto text-3 date">01 July 18, Sun</div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-sm-center flex-row">
                            <div class="col-12 col-sm-3 mb-3 mb-sm-0"> <span class="text-3 text-dark operator-name">AK Tour &amp; Travels</span> <span class="text-muted d-block">AC Sleeper</span> </div>
                            <div class="col col-sm-3 text-center time-info"> <span class="text-5 text-dark">12:00</span> <small class="text-muted d-block">Mumbai</small> </div>
                            <div class="col col-sm-3 text-center d-none d-sm-block time-info"> <span class="text-3 duration">18h 55m</span> <small class="text-muted d-block">12 Stops</small> </div>
                            <div class="col col-sm-3 text-center time-info"> <span class="text-5 text-dark">05:15</span> <small class="text-muted d-block">Surat</small> </div>
                            <div class="col-12 mt-3 text-dark">Seat No(s): <span class="bg-success text-light rounded px-2">B1</span> <span class="bg-success text-light rounded px-2">B2</span></div>
                        </div>

                    </div>
                </div>
                <h2 class="text-6 mb-3 mt-5">Traveller Details - <span class="text-3"><a data-toggle="modal" data-target="#login-signup" href="#" title="Login / Sign up">Login</a> to book faster</span></h2>
                <p class="font-weight-600">Contact Details</p>
                <div class="form-row">
                    <div class="col-sm-6 form-group">
                        <input class="form-control" id="email" required="" placeholder="Enter Email" type="text">
                    </div>
                    <div class="col-sm-6 form-group">
                        <input class="form-control" data-bv-field="number" id="mobileNumber" required="" placeholder="Enter Mobile Number" type="text">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-4 form-group">
                        <input class="form-control" id="firstName" required="" placeholder="Enter First Name" type="text">
                    </div>
                    <div class="col-sm-4 form-group">
                        <input class="form-control" id="lastName" required="" placeholder="Enter Last Name" type="text">
                    </div>
                    <div class="col-sm-4 form-group">
                        <input class="form-control" id="age" required="" placeholder="Age" type="text">
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Panel (Fare Details)
        ============================================= -->
        <aside class="col-lg-4 mt-4 mt-lg-0">
            <div class="bg-light shadow-md rounded p-3">
                <h3 class="text-5 mb-3">Fare Details</h3>
                <ul class="list-unstyled">
                    <li class="mb-2">Base Fare <span class="float-right text-4 font-weight-500 text-dark">$250</span></li>
                    <li class="mb-2">Taxes &amp; Fees <span class="float-right text-4 font-weight-500 text-dark">$30</span></li>
                </ul>
                <div class="text-dark bg-light-4 text-4 font-weight-600 p-3"> Total Amount <span class="float-right text-6">$350</span> </div>
                <button class="btn btn-primary btn-block" onclick="location.href='payment.html';" type="submit">Proceed To Payment</button>
            </div>
        </aside><!-- Side Panel -->
    </div>
    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.js"></script>
    <script src="vendor/font-awesome/font-awesome.js"></script>
</section>
</body>
</html>