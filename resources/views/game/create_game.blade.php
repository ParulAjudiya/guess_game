@extends('layouts.app')
@section('content')
    <div class="page-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="/new_game">
                        @csrf
                        @method('POST')
                        <label class="text-black">Your Name</label>
                        <input type="text" name="host_player"  class="form-control"/>
                        <button type="submit" class="btn btn-primary btn-block mt-2">Start Game</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
