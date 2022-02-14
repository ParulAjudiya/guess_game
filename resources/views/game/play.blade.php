@extends('layouts.app')
@section('content')
    <div class="page-section">
        <div class="container">
            <div class="row">
                @if(!empty($result_data['win_status']) && $result_data['win_status'] == 1)
                    <div id="result_wrapper_play" class="alert-danger ">This Game is already played.</div>
                    <div class="modal fade" id="win_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="win_title"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_game">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="game_result_body">
                                    <img src="{{ asset('assets/img/win.png') }}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                @if(!empty($result_data['players_data']))
                    @foreach($result_data['players_data'] as $player)
                <div class="col-lg-4">
                    <div class="card-service wow fadeInUp">
                        <div class="header">
                            <img src="{{ asset('assets/img/services/service-1.svg') }}" alt="">
                        </div>
                        <div class="body">
                            <h5 class="text-secondary">{{$player['player_name']}}  @if(Session::get('player_id') == $player['player_id']) (You) @endif
                                @if($player['is_host'] == 1) (Host) @endif</h5>
                            @if(Session::get('player_id') == $player['player_id'])
                                <form method="POST" id="guess_form">
                                    @csrf
                                    @method('POST')
                                    <input type="number" id="number_input" name="number_input" class="form-control"  min=1 max=100  maxlength="3"  onKeyPress="if(this.value.length==3) return false;">
                                    <button type="button" class="btn btn-primary btn-block mt-5 allowcenter"  id="guess_button" @if(count($result_data['players_data']) <3) disabled  @endif
                                    @if($result_data['win_status'] == 1) disabled @endif >Guess Number</button>
                                </form>
                                <div id="error" class="error"></div>
                            @else
                                <span type="text" disabled readonly class="form-control"></span>
                                <button type="button" class="btn btn-primary btn-block mt-5 allowcenter"  id="processbutton{{$player['player_id']}}" disabled>Guess Number</button>
                            @endif
                            <input type="hidden" id="win_status" value="{{ $result_data['win_status']  }}"/>
                        </div>
                        <div class="error @if(Session::get('player_id') == $player['player_id']) active_player @else result_notification @endif"></div>

                        @if($player['win_status'] == 1)
                            <div class="alert-success win_result hidden form-control">{{ $player['player_name'] }} won the Game</div>
                        @endif
                    </div>
                </div>
                @endforeach

                @endif
            </div>

        </div> <!-- .container -->
    </div> <!-- .page-section -->
    <!-- Modal -->
    <div class="modal fade" id="win_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="win_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_game">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="game_result_body">
                    <img src="{{ asset('assets/img/win.png') }}"/>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/game/play.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
@endsection
