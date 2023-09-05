<ul>
    <li><a href="{{ route('admin') }}" title="Va alla Home di Admin">Home</a></li>
    <li><a href="{{ route('auto') }}" title="Visualizza il Catalogo Prodotti">Catalogo</a></li>
    <li><a href="{{ route('inboxAdmin') }}" title="Chiedi all Admin">Controlla le domande</a></li>
    @auth
        <li><a href="" class="highlight" title="Esci dal sito" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    @endauth
</ul>

