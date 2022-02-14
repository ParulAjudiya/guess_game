@extends('layouts.app')
@section('content')
    <div class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 ">
                    <div id="wrapper_invite_people">
                        <p>Please send invitation to players to join the game using below link</p>
                        <input type="hidden"  readonly  id="invite_url" value="{{ url('/').'/joingame/'.$tokenData->token }}"/>
                        <button type="button"  id="invite_players" class="btn btn-primary btn-block mt-5">Copy link for Invite players</button>
                    </div>

                    <div id="result_wrapper"></div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <a href="{{url('/play')}}"   id="play_game" class="btn btn-primary btn-block mt-5  play_game_button" style="margin: 0 auto;">Play Game</a>
                </div>
            </div>

        </div> <!-- .container -->
    </div> <!-- .page-section -->
    <script type="text/javascript" src="{{ asset('assets/js/game/play.js') }}"></script>
@endsection
