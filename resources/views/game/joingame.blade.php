@extends('layouts.app')
@section('content')
<div class="page-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="post-content">
                    <p>You are invited by <b>{{ $token_value_rs['host_name'] }}  </b>. <br/>Please enter your name to join the game.</p>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="col-lg-4">
                    <form method="POST" action="{{ url('/process_to_join_game') }}">
                        @csrf
                        @method('POST')
                        <input type="text" name="player_name"  class="form-control"/>
                        <input type="hidden" name="token" value="{{ $token_value_rs['token']}}" />
                        <button type="submit" class="btn btn-primary btn-block mt-2">Join the Game</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
