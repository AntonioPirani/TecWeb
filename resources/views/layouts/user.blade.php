<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >
        <title>{{env('APP_NAME')}} | @yield('title', 'Catalogo')</title>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <div id="logoImg">
                    <a href="{{route('auto')}}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" >
                    </a>
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
                        @if (session('success'))
                            <div class="alert alert-success">
                                <center>{{ session('success') }}</center>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                <center>{{ session('error') }}</center>
                            </div>
                        @endif
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
