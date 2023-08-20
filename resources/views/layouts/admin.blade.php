<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        @section('link')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >
        @show
        @section('scripts')
        @show
        <title>LaProj6 | @yield('title', 'Catalogo')</title>
    </head>
    <body id="bodyadmin">
        <div id="wrapper">
            <div id="menu">
                @include('layouts/_navadmin')
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
            <div id="footer">
                <p><br> Guida verso il tuo destino con stile e comfort.<br>Scopri la libertà su strada con i nostri veicoli di qualità.
                <br> Scegli <i>Nolleggiauto</i> per un viaggio senza confini e senza pensieri.<br><br>
                &copy; 2023 No rights reserved.<br> </p>
            </div>
            <!-- end #footer -->
        </div>
    </body>
</html>