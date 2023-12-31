@extends('layouts.admin')

@section('title', 'Area Admin')

@section('scripts')

@parent
<script src="{{ asset('js/functions.js') }}" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(function () {
    var actionUrl = "{{ route('newproduct.store') }}";
    var formId = 'addproduct';
    $(":input").on('blur', function (event) {
        var formElementId = $(this).attr('id');
        doElemValidation(formElementId, actionUrl, formId);
    });
    $("#addproduct").on('submit', function (event) {
        event.preventDefault();
        doFormValidation(actionUrl, formId);
    });
});
</script>

@endsection

@section('content')
<div class="static">
    <h3>Aggiungi Prodotti</h3>
    <p>Utilizza questa form per inserire un nuovo prodotto nel Catalogo</p>

    <div class="container-contact">
        <div class="wrap-contact">
            {{ Form::open(array('route' => 'newproduct.store', 'id' => 'addproduct', 'files' => true, 'class' => 'contact-form')) }}
            <div  class="wrap-input  rs1-wrap-input">
                {{ Form::label('name', 'Nome Prodotto', ['class' => 'label-input']) }}
                {{ Form::text('name', '', ['class' => 'input', 'id' => 'name']) }}
            </div>

            <div  class="wrap-input  rs1-wrap-input">
                {{ Form::label('catId', 'Categoria', ['class' => 'label-input']) }}
                {{ Form::select('catId', $cats, '', ['class' => 'input','id' => 'catId']) }}
            </div>

            <div  class="wrap-input  rs1-wrap-input">
                {{ Form::label('image', 'Immagine', ['class' => 'label-input']) }}
                {{ Form::file('image', ['class' => 'input', 'id' => 'image']) }}
            </div>

            <div  class="wrap-input  rs1-wrap-input">
                {{ Form::label('descShort', 'Descrizione Breve', ['class' => 'label-input']) }}
                {{ Form::text('descShort', '', ['class' => 'input', 'id' => 'descShort']) }}
            </div>

            <div  class="wrap-input  rs1-wrap-input">
                {{ Form::label('price', 'Prezzo', ['class' => 'label-input']) }}
                {{ Form::text('price', '', ['class' => 'input', 'id' => 'price']) }}
            </div>

            <div  class="wrap-input  rs1-wrap-input">
                {{ Form::label('discountPerc', 'Sconto (%)', ['class' => 'label-input']) }}
                {{ Form::text('discountPerc', '', ['class' => 'input', 'id' => 'discountPerc']) }}
            </div>

            <div  class="wrap-input  rs1-wrap-input">
                {{ Form::label('discounted', 'In Sconto', ['class' => 'label-input']) }}
                {{ Form::select('discounted', ['1' => 'Si', '0' => 'No'], 1, ['class' => 'input','id' => 'discounted']) }}
            </div>

            <div  class="wrap-input  rs1-wrap-input">
                {{ Form::label('descLong', 'Descrizione Estesa', ['class' => 'label-input']) }}
                {{ Form::textarea('descLong', '', ['class' => 'input', 'id' => 'descLong', 'rows' => 2]) }}
            </div>

            <div class="container-form-btn">
                {{ Form::submit('Aggiungi Prodotto', ['class' => 'form-btn1']) }}
            </div>

            {{ Form::close() }}
        </div>
    </div>

</div>
@endsection


