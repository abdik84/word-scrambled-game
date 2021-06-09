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
                        <button class="btn btn-dark" onclick="logout()">Logout</button>
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
                        @if (count($players) > 0)
                            @foreach ($players as $index => $player)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $player->username }}</td>
                                    <td>{{ $player->games_played }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm" onclick="detail({{ $player->id }})">Show Games</button>
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

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Game List</h5>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Played at</th>
                                <th class="text-center">Total Score</th>
                                <th class="text-center">Show Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Game Details</h5>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Question</th>
                                <th class="text-center">Scrambled</th>
                                <th class="text-center">Answer</th>
                                <th class="text-center">Score</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#modal').modal({ backdrop: 'static', keyboard: false })">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="assets/vendors/jquery/jquery-3.6.0.min.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/sweetalert/sweetalert2.min.js"></script>

<script>    
    function detail(user_id) {
        $.get('/api/games/' + user_id).then(function(res) {
            let data = res.data
            let content = ''

            if (data.length) {
                data.map((item, index) => {
                    content += `
                            <tr>
                                <td>${index+1}</td>
                                <td>${dateFormat(item.created_at)}</td>
                                <td>${item.total_score}</td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm" onclick="gameDetail(${item.id})">Detail</button>
                                </td>
                            </tr>
                    `
                })
            } else
                content = `<tr><td class="text-center" colspan="4"><i>No Data Available</i></td></tr>`

            $("#modal .modal-body table tbody").html(content)
            $("#modal").modal({
                backdrop: 'static',
                keyboard: false
            })
        })
    }

    function gameDetail(game_id) {
        $.get('/api/games/detail/' + game_id).then(res => {
            let data = res.data
            let content = ''

            if (data.length) {
                data.map((item, index) => {
                    content += `
                            <tr>
                                <td>${index+1}</td>
                                <td>${item.question}</td>
                                <td>${item.scrambled_question}</td>
                                <td class="${item.question === item.answer ? `text-success` : `text-danger`}">${item.answer}</td>
                                <td>${item.score}</td>
                            </tr>
                    `
                })
            } else
                content = `<tr><td class="text-center" colspan="5"><i>No Data Available</i></td></tr>`

            $("#modal").modal('hide')

            $("#modal2 .modal-body table tbody").html(content)
            $("#modal2").modal({
                backdrop: 'static',
                keyboard: false
            })
        })
    }

    function dateFormat(date) {
        date = new Date(date)
        return date.getFullYear() + "-" + appendLeadingZeroes(date.getMonth() + 1) + "-" + appendLeadingZeroes(date.getDate()) + " " + appendLeadingZeroes(date.getHours()) + ":" + appendLeadingZeroes(date.getMinutes()) + ":" + appendLeadingZeroes(date.getSeconds())
    }

    function appendLeadingZeroes(n) {
        if (n <= 9) {
            return "0" + n;
        }
        return n
    }

    function logout() {
        $.post('/api/logout').then(() => {
            window.location.reload()
        })
    }

</script>

</html>
