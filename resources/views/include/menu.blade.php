<div class="back-to-top"></div>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky" data-offset="500">
        <div class="container">
            <a href="#" class="navbar-brand">Guess the number <span class="text-primary">Game</span></a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto">
                    @if(Session::has('is_host') && Session::get('is_host') !='' && Session::get('is_host')==1)
                        <li class="nav-item mr-2"><a href="{{url('/invite')}}">Invite Players</a></li>
                    @endif
                    <li class="nav-item"><a href="{{url('/')}}">Start New Game</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
