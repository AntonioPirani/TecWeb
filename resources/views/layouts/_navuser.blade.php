<ul>
    <li><a href="{{ route('user') }}" title="Va alla Home di User">Home</a></li>
    <li><a href="{{ route('auto') }}" title="Visualizza il Catalogo Prodotti">Catalogo</a></li>
    <li><a href="{{ route('edituser') }}" title="Modifica il tuo Profilo">Modifica Profilo</a></li>
    {{--@can('isUser')
        <li><@can('isUser')
            <li><a href="{{ route('user') }}" class="highlight" title="Home User">Home User</a></li>
        @endcan
    @endcan--}}
    <li><a href="{{ route('messaging') }}" title="Chiedi all Admin">Scrivi una Domanda</a></li>
    @auth
        <li><a href="" class="highlight" title="Esci dal sito" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    @endauth
</ul>
