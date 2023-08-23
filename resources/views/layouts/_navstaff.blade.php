<ul>
    <li><a href="{{ route('staff') }}" title="Va alla Home di Staff">Home</a></li>
    <li><a href="{{ route('auto') }}" title="Visualizza il Catalogo Prodotti">Catalogo</a></li>
    <li><a href="{{ route('aggiungi') }}" title="Aggiungi">Aggiungi</a></li>
    <li><a href="{{ route('modifica') }}" title="Modifica">Modifica</a></li>
    <li><a href="{{ route('elimina') }}" title="Elimina">Elimina</a></li>
    @auth
        <li><a href="" class="highlight" title="Esci dal sito" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    @endauth    
</ul>