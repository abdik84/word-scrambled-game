@extends('../main')

@section('content')
    <div class="row justify-content-center mt-5 mb-3">
        <div class="col-8">
            <span class="main-title mb-5">Word Scrambled Game</span>
        </div>
    </div>

    <div class="row justify-content-center mt-5 mb-3">
        <div class="col-8">
            <input type="text" class="form-control" placeholder="Input Your Username" autocomplete="off" id="username">
            <small class="text-danger" id="username-alert"></small>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-6">
            <button class="btn btn-success col-12" onclick="startgame()">Start Game</button>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        $(function() {
            let username = localStorage.getItem('playerUsername')
            if(username) window.location.href = '/play'
        })

        function startgame() {
            let username = $('#username').val()

            if(!username.length) $("#username-alert").html("Please insert your username")
            else {
                $("#username-alert").html("")
                localStorage.setItem('playerUsername', username)
                window.location.href = '/play'
            }
        }
    </script>
@endsection