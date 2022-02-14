<?php

namespace App\Http\Controllers;

use App\Services\GameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Entities\GameParameters;

class GameController extends Controller
{
    private $gameService;

    public function __construct()
    {
        $this->gameService = new GameService();
    }

    public function index(Request $request)
    {
        $data_host = $request->session()->get('player_id');
        if (!empty($data_host)) {
            return redirect()->route('play');
        } else {
            return view('game.start_new_game');
        }
    }

    /**
     * start the new game
     *
     * @param string $request
     * @return view
     *
     */
    public function start_new_game(Request $request)
    {
        $data_host = $request->session()->get('player_id');
        if (!empty($data_host)) {
            return redirect()->route('play');
        } else {
            return view('game.create_game');
        }
    }

    /**
     * process the game and create host.
     *
     * @param array $request
     * @return to invite players window
     *
     */
    public function new_game(Request $request)
    {
        $request->validate([
            'host_player' => 'required',
        ]);
        $host_name = $request->input('host_player');
        $game_parameters = new GameParameters();
        $game_parameters->setRequestData($request->all());
        $game_session_id = $this->gameService->saveGame($game_parameters);

        if ($game_session_id > 0) {
            $request->session()->put('game_session_id', $game_session_id);
            $player_parameters = new GameParameters();
            $player_parameters->setPlayerName($host_name);
            $player_parameters->setGameSessionId($game_session_id);
            $player_parameters->setHost(1);
            $saved_player_id = $this->gameService->savePlayer($player_parameters);

            $request->session()->put('player_id', $saved_player_id);
            $request->session()->put('is_host', 1);
        }
        return redirect()->route('invite');
    }

    /**
     * Invite the players
     *
     * @param string $request
     * @return token data
     *
     */
    public function invite(Request $request)
    {
        $token_parameter = new GameParameters();
        $token_parameter->setGameSessionId($request->session()->get('game_session_id'));
        $data = $this->gameService->getToken($token_parameter);
        if ($data['is_error'] == 0) {
            $tokenData = $data['data'];
            return view('game.invite', compact('tokenData'));
        }
    }

    /**
     * check rule of game - game should function with 3 members
     *
     * @param array $request
     * @return true/false
     *
     */
    public function check_game_rule(Request $request)
    {
        try {
            $rule_parameter = new GameParameters();
            $rule_parameter->setGameSessionId($request->session()->get('game_session_id'));

            $rs_players = $this->gameService->get_players($rule_parameter);
            if (!empty($rs_players) && $rs_players['is_error'] == 0 && count($rs_players['data']) >= 3) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * check rule of game - game should function with 3 members
     *
     * @param array $request
     * @return rander the play window
     *
     */
    public function play(Request $request)
    {
        $players_data = [];

        $play_parameter = new GameParameters();
        if (empty($request->session()->get('game_session_id'))) {
            return redirect()->route('home');
        }
        //check win status
        $status = $this->check_win_status($request);
        if ($status) {
            $already_game_won['already_play'] = 1;
        }
        $play_parameter->setGameSessionId($request->session()->get('game_session_id'));
        $rs_players = $this->gameService->get_players($play_parameter);
        if (!empty($rs_players) && $rs_players['is_error'] == 0) {
            $players_data = $rs_players['data'];
        }
        $result_data['players_data'] = $players_data;
        $result_data['win_status'] = $status;
        return view('game.play', compact('result_data'));
    }

    /**
     * get players of current game
     *
     * @param array $request
     * @return array of players
     *
     */
    public function get_players(Request $request)
    {
        $gamesession_parameter = new GameParameters();
        $gamesession_parameter->setGameSessionId($request->session()->get('game_session_id'));
        $rs_players = $this->gameService->get_players($gamesession_parameter);
        if ($rs_players['is_error'] == 0) {
            return $rs_players['data'];
        }
    }

    /**
     * Invited players can join the game using token.
     *
     * @param string token, array $request
     * @return rander view of join game
     *
     */
    public function join_game($token, Request $request)
    {
        if (!empty($token)) {
            $data_playerid = $request->session()->get('player_id');
            if (!empty($data_playerid)) {
                return redirect()->route('play');
            }
            $join_parameter = new GameParameters();
            $join_parameter->setToken($token);
            $rs_token = $this->gameService->get_token($join_parameter);
            if ($rs_token['is_error'] == 0) {
                $tokenData = $rs_token['data'];
                $token_value_rs = ['token' => $token, 'host_name' => $tokenData[0]->player_name];
                $request->session()->put('token', $token);
                return view('game.joingame', compact('token_value_rs'));
            } else {
                return $rs_token['msg'];
            }
        }
        return "";
    }

    /**
     * process of join game for Invited players.
     *
     * @param array $request
     * @return play window of game
     *
     */
    public function process_to_join_game(Request $request)
    {
        $request->validate([
            'player_name' => 'required',
            'token' => 'required'
        ]);
        $join_game = new GameParameters();
        $join_game->setToken($request->input('token'));
        $result_set = $this->gameService->get_token($join_game);
        if ($result_set['is_error'] == 0) {
            $tokenData = $result_set['data'];
            if (!empty($tokenData)) {
                $join_player = new GameParameters();
                $join_player->setPlayerName($request->input('player_name'));
                $join_player->setGameSessionId($tokenData[0]->game_session_id);
                $join_player->setHost(0);
                $last_player_id = $this->gameService->savePlayer($join_player);
                $request->session()->put('player_id', $last_player_id);
                $request->session()->put('game_session_id', $tokenData[0]->game_session_id);

                return redirect()->route('play');
            } else {
                echo 'Token not found to join game';
            }
        } else {
            return redirect()->route('join/' . $request->session()->get('player_id'));
        }

    }

    /**
     * guess the number
     *
     * @param array $request
     * @return json response for result
     *
     */
    public function guess_number(Request $request)
    {
        $requestData = $request->all();
        $default_response = ['message' => 'something went wrong while playing game.', 'is_error' => 1];
        $number_input = $request->input('number_input');
        $validatorRules = [
            'number_input' => "required",
        ];
        $validatorRulesMessages = [
            'number_input.required' => 'Input is requird',
        ];
        $validator = Validator::make($requestData, $validatorRules, $validatorRulesMessages);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'is_error' => 1], 400);
        }

        if ($number_input < 1 || $number_input > 100) {
            $default_response = ['message' => 'Input should be between 1 to 100.', 'is_error' => 1];
            return response()->json($default_response, 400);
        }
        if (!($this->check_game_rule($request))) {
            return response()->json(['message' => 'You Loose', 'is_error' => 1, 'is_won' => 0], 400);
        }

        //check win status
        if ($this->check_win_status($request)) {
            return response()->json(['message' => 'You Loose', 'is_error' => 1, 'is_won' => 0], 200);
        }

        $parameter = new GameParameters();
        $parameter->setGameSessionId($request->session()->get('game_session_id'));
        $target = $this->gameService->get_target($parameter);
        if ($target['target'] == $number_input) {
            $default_response = ['message' => 'You Won', 'is_error' => 0, 'is_won' => 1];
            $win_parameter = new GameParameters();
            $win_parameter->setGameSessionId($request->session()->get('game_session_id'));
            $win_parameter->setPlayerId($request->session()->get('player_id'));

            // change the status of player.
            $status = $this->gameService->update_win_status($win_parameter);
        } elseif ($target['target'] < $number_input) {
            $default_response = ['message' => 'Lower!', 'is_error' => 0, 'is_won' => 0];
        } elseif ($target['target'] > $number_input) {
            $default_response = ['message' => 'Higher!', 'is_error' => 0, 'is_won' => 0];
        }
        return response()->json($default_response, 200);
    }

    /**
     * close the game
     *
     * @param array $request
     * @return json response for close game
     *
     */
    public function close_game(Request $request)
    {
        $request->session()->flush();
        $default_response = ['message' => 'new game stat', 'is_error' => 0];
        return response()->json($default_response, 200);
    }

    /**
     * process to check win status of game
     *
     * @param array $request
     * @return true/false
     *
     */
    public function check_win_status(Request $request)
    {
        $parameter = new GameParameters();
        $parameter->setGameSessionId($request->session()->get('game_session_id'));
        $check_winstatus = $this->gameService->get_win_status($parameter);
        if ($check_winstatus['win_status'] == 1) {
            return true;
        } else {
            return false;
        }
    }
}
