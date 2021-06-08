<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Scrambled Game</title>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendors/sweetalert/sweetalert2.min.css">
</head>
<body>
    <div class="game-container">
        @yield('content')
    </div>
</body>

<script src="assets/vendors/jquery/jquery-3.6.0.min.js"></script>
<script src="assets/vendors/sweetalert/sweetalert2.min.js"></script>
@yield('custom-js')
</html>