@extends('layouts.public')
@section('scripts')
    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        <form id="bigForm" action="{{route('bigFilter')}}">
            <br>
            <h2>Filtro BIG</h2>
            <p class="sm:items-center">In questo fitro puoi selezionare le auto in base sia al prezzo che alla data di prenotazione</p>
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
            </div><br>
{{--            <p>Inserisci data di inizio e fine nolleggio per filtrare le auto in base a esse</p>--}}
            <div class="filter">
                <label>
                    <input type="date" name="dataInizio" class="form-control"  required>
                </label>
            </div>


            <div class="filter">
                <label>
                    <input type="date" name="dataFine" class="form-control"  required>
                </label>
            </div>

            <br>
            <button id="bottoneBig">Applica Filtro BIG</button>
        </form>

        <form id="formPrezzo" action="{{route('prezzo')}}">
            @csrf
            <br>
            <h2>Filtro prezzo</h2><br>
{{--            <p>Inserisci il minimo e il massimo prezzo giornaliero che desideri</p>--}}
            <div class="filter">
                <label for="minPrice">
                    <input type="number" name="minPrice" class="form-control" placeholder="Inserisci prezzo minimo"
                    required>
                </label>
            </div>


            <div class="filter">
                <label for="maxPrice">
                    <input type="number" name="maxPrice" class="form-control" placeholder="Inserisci prezzo massimo" required>
                </label>
            </div>
            <br>
            @if (session('success-prezzo'))
                <span class="formerror">{{ session('success-prezzo') }}</span>
            @endif
            @if (session('error-prezzo'))
                <span class="formerror">{{ session('error-prezzo') }}</span>
            @endif
            <button  id="bottonePrezzo">Applica Filtro Prezzo</button>
        </form>
        <form id="formPosti" action="{{route('posti')}}">
            @csrf

            <br>
            <h2>Filtro posti</h2><br>
{{--            <p>Inserisci il numero di posti che desideri nella tua auto a nolleggio</p>--}}
            <div class="filter">
                <label for="posti">Numero di posti:
                    <input type="number" name="posti" class="form-control" placeholder="esempio: 4" required>
                </label>
            </div>

            <br>
            @if (session('success-posti'))
                <span class="formerror">{{ session('success-posti') }}</span>
            @endif
            @if (session('error-posti'))
                <span class="formerror">{{ session('error-posti') }}</span>
            @endif
            <button id="bottonePosti">Applica Filtro Posti</button>
        </form>
        <form id="AndForm" action="{{route('andFilter')}}">
            <br>
            <h2>Filtro mixed</h2>
            <p>In questo fitro puoi selezionare le auto in base sia al prezzo che al numero di posti</p>
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
            </div><br>

            <div class="filter">
                <label for="posti">Numero di posti:
                    <input type="number" name="posti" class="form-control" placeholder="esempio: 4" required>
                </label>
            </div>
            @if (session('success-mixed'))
                <span class="formerror">{{ session('success-mixed') }}</span>
            @endif
            @if (session('error-mixed'))
                <span class="formerror">{{ session('error-mixed') }}</span>
            @endif
            <br>
            <button id="bottoneAnd">Applica Filtro Posti e Prezzo</button>
        </form>

        <form id="formDate" action="{{route('data')}}">
            @csrf
            <br>
            <h2>Filtro Data</h2>
            <p>Inserisci data di inizio e fine nolleggio per filtrare le auto in base a esse</p>
            <div class="filter">
                <label>
                    <input type="date" name="dataInizio" class="form-control"  required>
                </label>
            </div>


            <div class="filter">
                <label>
                    <input type="date" name="dataFine" class="form-control"  required>
                </label>
            </div>
            <br>
            @if (session('success-data'))
                <span class="formerror">{{ session('success-data') }}</span>
            @endif
            @if (session('error-data'))
                <span class="formerror">{{ session('error-data') }}</span>
            @endif
            <br>
            <button  id="bottoneData">Applica Filtro Data</button>
        </form>


    </div>
    <!-- fine sezione laterale -->
@endsection


