@extends('layouts.app')
@section('content')
    <div class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <a href="{{url('/start_new_game')}}"   id="new_game" class="btn btn-primary btn-block mt-5 allowcenter">Start New Game</a>
                </div>
            </div>
        </div> <!-- .container -->
    </div> <!-- .page-section -->
@endsection
