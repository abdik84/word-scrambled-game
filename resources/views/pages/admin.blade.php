<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Scrambled Game</title>
    
    {{-- <link rel="stylesheet" href="assets/css/style.css"> --}}
    <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendors/sweetalert/sweetalert2.min.css">
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hi, {{ Auth::user()->username }}</a>
            <div>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <button class="btn btn-dark">Logout</button>
                    </li>                  
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">      
        <div class="row mt-3">
            <div class="col">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Player</th>
                            <th class="text-center">Game Played</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($players) > 0)
                            @foreach ($players as $index => $player)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $player->username }}</td>
                                    <td>{{ $player->games_played }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm">Show Detail</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="4"><i>No Data Available</i></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<script src="assets/vendors/jquery/jquery-3.6.0.min.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/sweetalert/sweetalert2.min.js"></script>
@yield('custom-js')
</html>