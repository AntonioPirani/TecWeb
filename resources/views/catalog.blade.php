@extends('layouts.public')
@section('scripts')
    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#FiltersForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: "GET",
                    url: "{{ route('filtri')}}",
                    data: $(this).serialize(),
                    success: function (response) {
                        // Display the success message
                        $('#resultMessage').html('<div class="alert alert-success">Filters applied successfully</div>');

                        window.location.href = "{{ route('auto') }}";
                    },
                    error: function (error) {
                        // Display the error message
                        $('#resultMessage').html('<div class="alert alert-danger">Failed to apply filters</div>');
                        window.location.href = "{{ route('auto') }}";
                    }
                });
            });
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
            <form id="FiltersForm" method="GET" action="{{ route('filtri') }}">
                @csrf

                <h2>Filtro prezzo</h2>
                <p>Inserisci il minimo e il massimo prezzo giornaliero che desideri</p>
                <div class="filter">
                    {{--            <label for="minPrice"></label>--}}
                    <label>
                        <input type="number" name="minPrice" class="form-control" placeholder="Inserisci prezzo minimo">
                    </label>
                </div>
                <div class="filter">
                    {{--            <label for="maxPrice"></label>--}}
                    <label>
                        <input type="number" name="maxPrice" class="form-control"
                               placeholder="Inserisci prezzo massimo">
                    </label>
                </div>

                <h2>Filtro posti</h2>
                <p>Inserisci il numero di posti che desideri nella tua auto a nolleggio</p>
                <div class="filter">
                    {{--            <label for="posti">Numero di posti:</label>--}}
                    <label>
                        <input type="number" name="posti" class="form-control" placeholder="esempio: 4">
                    </label>
                </div>

                <br>
                <button type="submit">Applica i Filtri</button>
            </form>
        </div>
        <!-- fine sezione laterale -->
    @endsection


