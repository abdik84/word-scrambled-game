@extends('../main')

@section('content')
    <div id="quiz">
        Your Score: <span class="score">0</span>
        @foreach($questions as $index => $item)
            <div id="question-{{ $index+1 }}" data-answer="{{ $item['question'] }}" class="{{ $index == 0 ? '' : 'd-none' }}">
                <div class="row justify-content-center mt-5 mb-3">
                    <div class="col-8">
                        <span class="main-title mb-5">#Question {{ $index+1 }}</span>
                    </div>
                </div>

                <div class="row justify-content-center mt-3">
                    <div class="col-8 text-center">
                        <span class="question text-primary">{{ $item['scrambled'] }}</span>
                    </div>
                </div>

                <div class="row justify-content-center mt-4" style="padding: 0px 30px;">
                    @for($x = 0; $x < strlen($item['scrambled']); $x++)
                        <div class="col">
                            <input type="text" class="my-input" id="{{ $index*10+$x }}" maxlength="1">
                        </div>
                    @endfor
                </div>
            </div>
        @endforeach


        <div class="row justify-content-center mt-5">
            <div class="col-8">
                <button class="btn btn-success col-12" onclick="answer()">Submit</button>
            </div>
        </div>
    </div>

    <div id="result" class="d-none">
        <div class="row justify-content-center mt-5">
            <div class="col-8">
                <span class="main-title mb-5">Well Done</span>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-8">
                <div class="final-score-container">
                    <div class="final-score text-center">
                        <p><strong>Final Score</strong></p>
                        <span class="score">100</span>
                    </div>
                </div> 
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col">
                <button class="btn btn-primary col-12" onclick="playAgain()">Play Again</button>
            </div>
            <div class="col">
                <button class="btn btn-danger col-12" onclick="exit()">Exit</button>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        var question = 1
        var score = 0
        var result = []
        var finish = false

        // Confirm on reload page
        $( window ).bind('beforeunload', function() {
            if(!finish) return 'Score will be reset'; 
        });

        $(function() {
            let username = localStorage.getItem('playerUsername')
            if(!username) window.location.href = '/'

            // create auto move pointer
            $(".my-input").keyup(function (e) {
                let value = $(this).val()
                let maxlength = $(this).attr('maxlength')
                let id = $(this).attr('id')

                if(e.keyCode == 8 && id%10 != 0) {
                    $(`#${parseInt(id)-1}`).val("")
                    $(`#${parseInt(id)-1}`).focus()
                } else if(value.length == maxlength) {
                    $(`#${parseInt(id)+1}`).focus()
                }
            });
        })

        function answer() {
            let clear = true
            let activeInput = $(".my-input:not(div.d-none .my-input)")
            let realAnswer = $('#question-'+question).data('answer')

            let userAnswer = ''

            activeInput.each(function() {
                let _this = $(this)
                let value = _this.val()

                if(!value) {
                    _this.css('border-color', 'red')
                    clear = false
                } 

                userAnswer += value.toUpperCase()

                setTimeout(function() {
                    _this.css('border-color', 'black')
                }, 3000)
            })

            if(clear) {
                // go to next question
                let liveScore
                if(userAnswer === realAnswer) {
                    liveScore = 10
                    swal.fire("Woow", "Correct Answer", "success").then(function() {
                        nextQuestion(liveScore)
                    })
                } else {
                    liveScore = -10
                    swal.fire("Ooops", "Wrong Answer", "error").then(function() {
                        nextQuestion(liveScore)
                    })
                }

                result.push({
                    question: realAnswer,
                    scrambled_question:  $(`#question-${question}`).find('.question').html(),
                    answer: userAnswer,
                    score: liveScore
                })
            }
        }

        function nextQuestion(liveScore) {
                
            score += liveScore;
            $(".score").html(score)

            if(question <= 9) {
                $(`#question-${question}`).remove()
                $(`#question-${question+1}`).removeClass('d-none')
                question++                    
            } else {
                $.post('/api/games/add', {
                    username: localStorage.getItem('playerUsername'),
                    result: result
                }).then(function(res) {
                    if(res.status) {
                        $("#quiz").addClass('d-none')
                        $("#result").removeClass('d-none')
                    }
                }).fail(function(error) {
                    if(error.responseJSON) {
                        alert(error.responseJSON.message)
                    } else {
                        alert("Internal server error")
                    }
                })
            }
        }

        function playAgain() {
            finish = true
            window.location.reload()
        }

        function exit() {
            finish = true
            localStorage.removeItem('playerUsername')
            window.location.href = '/'
        }
    </script>
@endsection