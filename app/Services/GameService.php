<?php

namespace App\Services;

use App\Models\GameSession;
use App\Models\Players;
use Exception;
use Illuminate\Http\Request;
use App\Entities\GameParameters;

class GameService
{
    public function saveGame(GameParameters $gameParameters)
    {
        try {
            $game_session = new GameSession;
            $game_session->token = uniqid();
            $game_session->target = rand(10, 100);;
            $game_session->save();
            $game_session_id = $game_session->id;
            return $game_session_id;
        } catch (Exception $e) {
        }
        return "";
    }

    public function savePlayer(GameParameters $player_parameter)
    {
        try {
            $player_data = new Players();
            $player_data->player_name = $player_parameter->getPlayerName();
            $player_data->game_session_id = $player_parameter->getGameSessionId();
            $player_data->is_host = $player_parameter->getHost();
            $player_data->save();

            $last_player_id = $player_data->id;
            return $last_player_id;
        } catch (Exception $e) {
        }
        return "";
    }

    public function getToken(GameParameters $token_parameter)
    {
        $default_data = ['is_error' => 1, 'data' => []];
        try {
            $tokenData = GameSession::select('token')->where(['id' => $token_parameter->getGameSessionId()])->first();
            $default_data =  ['is_error' => 0, 'data' => $tokenData];
            return $default_data;
        }catch (Exception $e){
        }
        return $default_data;
    }

    public function get_players(GameParameters $session_parameter){
        $default_data = ['is_error' => 1, 'data' => []];
        try {
            $gamesession_parameter = new GameParameters();
            $game_session_idval = $session_parameter->getGameSessionId();
            $players_data = GameSession::select('game_session.id as game_session_id', 'p.player_name', 'p.id as player_id', 'p.is_host', 'p.win_status')
                ->join("players as p", "p.game_session_id", "=", "game_session.id")
                ->where('game_session.id', $game_session_idval)->get()->toArray();
            $default_data = ['is_error' => 0, 'data' => $players_data];
            return $default_data;
        }catch (Exception $e){
        }
        return $default_data;
    }

    public function check_rule(Request $request)
    {

    }

    public function get_token(GameParameters $token_parameter){
        $default_data = ['is_error' => 1, 'data' => [], 'msg' => 'Not found token'];
        try {
            $rs_tokenData = GameSession::select('game_session.id as game_session_id', 'p.player_name', 'p.is_host')
                ->join("players as p", "p.game_session_id", "=", "game_session.id")
                ->where(['game_session.token' => $token_parameter->getToken(), 'is_host' => 1])->get();
            return ['is_error' => 0, 'data' => $rs_tokenData, 'msg' => 'found token'];
        }catch (Exception $e){
        }
        return $default_data;
    }

    public function get_target(GameParameters $parameter){
        $target = GameSession::select('target')->where('id', $parameter->getGameSessionId())->first();
        return $target;
    }

    public function get_win_status(GameParameters $parameter){
        $check_winstatus = Players::select('win_status')->where(['game_session_id' => $parameter->getGameSessionId(), 'win_status' => 1])->first();
        return $check_winstatus;
    }

    public function update_win_status(GameParameters $parameter){
        $status = Players::where(['game_session_id' => $parameter->getGameSessionId(), 'id'=>$parameter->getPlayerId()])->update(['win_status' => 1]);
        return $status;
    }
}
