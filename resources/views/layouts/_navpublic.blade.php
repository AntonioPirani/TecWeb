<ul>

    <!-- rotte pubbliche-->
    <li><a href="{{ route('auto') }}" title="Home">Catalogo</a></li>
    <li><a href="{{ route('where') }}" title="Dove trovarci">Dove Siamo</a></li>
    <li><a href="{{ route('who') }}" title="Il nostro profilo aziendale">Chi siamo</a></li>
    <li><a href="mailto:info@acme.it" title="Mandaci un messaggio">Contattaci</a></li> <!-- la messaggistica va su questa rotta-->
    <li><a href="{{ route('faqs') }}" title="Le domande più frequenti">FAQs</a></li>
    <!-- rotte per user admin e staff-->

    @can('isAdmin')
        <li><a href="{{ route('admin') }}" class="highlight" title="Home Admin">Home Admin</a></li>
    @endcan
    @can('isStaff')
        <li><a href="{{ route('staff') }}" class="highlight" title="Home Staff">Home Staff</a></li>
    @endcan
    @can('isUser')
        <li><@can('isUser')
            <li><a href="{{ route('user') }}" class="highlight" title="Home User">Home User</a></li>
        @endcan
    @endcan
    @auth
        <li><a href="" title="Esci dal sito" class="highlight" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    @endauth
    @guest
        <li><a href="{{ route('login') }}" class="highlight" title="Accedi all'area riservata del sito">Accedi</a></li>
    @endguest
</ul>
