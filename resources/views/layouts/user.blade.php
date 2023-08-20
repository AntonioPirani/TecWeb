<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >
        <title>LaProj6 | @yield('title', 'Catalogo')</title>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <div id="logo">
                    <h1><a href=""> Nolleggiauto  </a></h1>
                    <p>Le migliori auto per te</p>
                </div>
            </div>

            <!-- end #header -->
            <div id="menu">
                @include('layouts/_navuser')
            </div>

            <!-- end #menu -->
            <div id="page">
                <div id="page-bgtop">
                    <div id="page-bgbtm">
                        @yield('content')
                        <div style="clear: both;">&nbsp;</div>
                    </div>
                </div>
            </div>

            <!-- end #content -->
            <footer>
                <div class="container">
                    <div class="footer-content">
                        </div>
                            <center>
                                <p> Guida verso il tuo destino con stile e comfort.<br>Scopri la libertà su strada con i nostri veicoli di qualità.<br> Scegli <i>Nolleggiauto</i> per un viaggio senza confini e senza pensieri.</p>
                            </center>
                        </div>

                        <div class="footer-logo">
                            <img src="logo.png" alt="todo: qui ci va il logo salvato come logo.png">
                        </div>

                        <div class="footer-links">
                            <ul>
                                <li><a href="{{ route('catalog1') }}" title="Home">Catalogo</li>
                                <li><a href="{{ route('who') }}" title="Il nostro profilo aziendale">Chi siamo</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="{{ route('who')}}" title="Il nostro profilo aziendale">Contatti</li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-bar">
                        <p>&copy; 2023 No rights reserved. </p>
                    </div>
                </div>
            </footer>
            <!-- end #footer -->
        </div>
    </body>
</html>
