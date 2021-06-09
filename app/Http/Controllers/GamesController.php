<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Player;
use App\Models\Games;
use App\Models\GamesDetail;

class GamesController extends Controller
{
    public function index() {
        // getQuestion is function from App\Traits\Question (Load in main Controller)
        $questions = $this->getQuestions();
        $data = [
            'questions' => $questions
        ];

        return view('pages.play', $data);
    }
    
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'result' => 'required|array' 
        ]);

        if($validator->fails())
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => $validator->errors()->first()
            ], 400);
        
        DB::beginTransaction();
        try {
            $player = Player::firstOrNew(['username' => $request->username]);
            $player->save(); // Should be save to get ID for new data

            $game = new Games();
            $game->player_id = $player->id;
            $game->save();

            foreach($request->result as $result) {
                $game_detail = new GamesDetail();
                $game_detail->games_id = $game->id;
                $game_detail->question = $result['question'];
                $game_detail->scrambled_question = $result['scrambled_question'];
                $game_detail->answer = $result['answer'];
                $game_detail->score = $result['score'];
                $game_detail->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'data' => null,
                'message' => 'Result submitted successfully'
            ]);

        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getGamesByPlayer($player_id) {
        $data = Games::where('player_id', $player_id)
                    ->withCount(['details as total_score' => function($q) {
                        $q->select(DB::raw("SUM(score)"));
                    }])
                    ->orderBy('created_at', 'asc')
                    ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => null
        ]);
    }

    public function getGamesDetail($game_id) {
        $data = GamesDetail::where("games_id", $game_id)->get();

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => null
        ]);
    }
}
