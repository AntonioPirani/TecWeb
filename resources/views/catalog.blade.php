@extends('layouts.public')
@section('scripts')
    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        // Add a click event handler for the "filtroPrezzo" button
        document.getElementById('bottonePrezzo').addEventListener('auxclick', function () {
            // Add your code to perform the "filtroPrezzo" action here
            $.ajax({
                type: "GET",
                url: "{{ route('prezzo')}}",
                data: document.getElementById('formPrezzo').serialize(),
                success: function (response) {
                    // Handle the success response for "filtroPrezzo"
                    alert('Filter by Price action success');
                },
                error: function (error) {
                    // Handle the error response for "filtroPrezzo"
                    alert('Filter by Price action error');
                }
            });
            alert('Filter by Price action');
        });

        // Add a click event handler for the "filtroPosti" button
        document.getElementById('bottonePosti').addEventListener('auxclick', function () {
            // Add your code to perform the "filtroPosti" action here
            $.ajax({
                type: "GET",
                url: "{{ route('posti')}}",
                data: document.getElementById('formPosti').serialize(),
                success: function (response) {
                    // Handle the success response for "filtroPosti"
                    alert('Filter by Seats action success');
                },
                error: function (error) {
                    // Handle the error response for "filtroPosti"
                    alert('Filter by Seats action error');
                }
            });
            alert('Filter by Seats action');
        });
    </script>
@endsection

@section('title', 'Catalogo Prodotti')

<!-- inizio sezione prodotti -->
@section('content')
    <div id="content">
        @isset($products)
            @foreach ($products as $product)
                <!-- $products è un array di oggetti di tipo Auto passati da PublicController-->
                <div class="prod">
                    <div class="prod-bgtop">
                        <div class="prod-bgbtm">
                            <div class="oneitem">
                                <div class="image">
                                    @include('helpers/productImg', ['attrs' => 'imagefrm', 'imgFile' => $product->foto])
                                </div>
                                <div class="info">
                                    <h1 class="title">Modello: {{ $product->marca }} {{ $product->modello }}</h1>
                                    <p class="meta">Numero posti: {{ $product->posti }}<br>
                                        Potenza: {{ $product->potenza }} cv<br>
                                        Tipo cambio: {{ $product->tipoCambio }}<br>
                                        Optional: {{ $product->optional }}<br>
                                        <!-- Targa: {{ $product->targa }} -->
                                        Targa: {{ $product->targa }}

                                    </p>
                                    <p class="price">Prezzo giornaliero: {{ $product->prezzoGiornaliero }} €</p>
                                </div>

                                @can('isUser')
                                    <button><a href="{{ route('addPrenotazione', ['targa' => $product->targa])}}"
                                               class="highlight" title="Prenota questa macchina">Prenota</a>
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!--Paginazione-->
            @include('pagination.paginator', ['paginator' => $products])

        @endisset()
    </div>

    <!-- fine sezione prodotti -->
    <div id="sidebar">
        <form id="formPrezzo" action="{{route('prezzo')}}">
            @csrf

            <h2>Filtro prezzo</h2>
            <p>Inserisci il minimo e il massimo prezzo giornaliero che desideri</p>
            <div class="filter">
                <label>
                    <input type="number" name="minPrice" min="0" class="form-control" placeholder="Inserisci prezzo minimo"
                    required>
                </label>
            </div>

            <div class="filter">
                <label>
                    <input type="number" name="maxPrice" class="form-control" placeholder="Inserisci prezzo massimo" required>
                </label>
            </div>
            <br>
            <button  id="bottonePrezzo">Applica Filtro Prezzo</button>
        </form>


        <form id="formPosti" action="{{route('posti')}}">
            @csrf

            <br>
            <h2>Filtro posti</h2>
            <p>Inserisci il numero di posti che desideri nella tua auto a nolleggio</p>
            <div class="filter">
                <label for="posti">Numero di posti:
                    <input type="number" name="posti" class="form-control" placeholder="esempio: 4" required>
                </label>
            </div>

            <br>
            <button id="bottonePosti">Applica Filtro Posti</button>
        </form>
    </div>
    <!-- fine sezione laterale -->
@endsection


