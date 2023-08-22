<!--use app/Models/Resources/Auto.php-->
@extends('layouts.public')
@section('title', 'Catalogo auto')

@section('contentAuto')
<div id='content'>
    @isset($auto)
        @foreach($auto as $product)
<div class="prod">
        <div class="prod-bgtop">
            <div class="prod-bgbtm">
                <div class="oneitem">
                    <div class="image">
                        @include('helpers/productImg', ['attrs' => 'imagefrm', 'imgFile' => $product->image])
                    </div>
                    <div class="info">
                        <h1 class="title">Modello: {{ $product->modello }}</h1>
                        <p class="meta">Numero porte: 5<br>
                            Cilindrata: 100 cv<br>
                            Tipo cambio: manuale<br>
                            Optional: GPS, bluetooth
                        </p>
                        <p class="price">Prezzo giornaliero: {{ $product->getPrice }}€</p>
                    </div>
                    <!-- <div class="pricebox">
                        @include('helpers/productPrice')
                    </div> -->
                </div>
                <!-- <div class="entry">
                    <p>Descrizione Estesa: {!! $product->descLong !!}</p>
                </div> -->
            </div>
        </div>
    </div>
        @endforeach
        @include('pagination.paginator', ['paginator' => $auto])
    @endisset
</div>
@endsection
