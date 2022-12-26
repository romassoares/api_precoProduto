@extends('adminlte::page')
@section('title', 'Formulário cliente')
@section('content_header')
@stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!--  -->
                <div class="card-header">@if(isset($result)) Editar @else Cadastrar @endif Cliente</div>
                <div class="card-body">
                    @if(isset($result))
                    <form role="form" action="{{route('cliente.update',$result->id)}}" method="post" enctype="multipart/form-data">
                        {!! method_field('PUT') !!}
                        @else
                        <form name="formClient" id="formClient" method="post" action="{{route('cliente.store')}}" enctype="multipart/form-data">
                            @endif
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nome</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Digite o nome" value="{{isset($result->name)?$result->name:old('name')}}" />
                                    @error('name')
                                    <p class="text-danger">{{$message??''}}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="city">cidade</label>
                                    <input type="text" name="city" id="city" class="form-control" placeholder="Digite sua cidade" value="{{isset($result->city)?$result->city:old('city')}}" />
                                    @error('city')
                                    <p class="text-danger">{{$message??''}}</p>
                                    @enderror
                                </div>
                                <div class="form-group  col-md-6">
                                    <label for="district">Bairro</label>
                                    <input type="text" name="district" id="district" class="form-control" placeholder="Digite seu bairro" value="{{isset($result->district)?$result->district:old('district')}}">
                                    @error('district')
                                    <p class="text-danger">{{$message??''}}</p>
                                    @enderror
                                </div>
                                <div class="form-group  col-md-6">
                                    <label for="street">Rua</label>
                                    <input type="text" name="street" id="street" class="form-control" placeholder="Digite a rua" value="{{isset($result->street)?$result->street:old('street')}}">
                                    @error('street')
                                    <p class="text-danger">{{$message??''}}</p>
                                    @enderror
                                </div>
                                <div class="form-group  col-md-6">
                                    <label for="number">Nº</label>
                                    <input type="text" name="number" id="number" class="form-control" value="{{isset($result->number)?$result->number:old('number')}}">
                                    @error('street')
                                    <p class="text-danger">{{$message??''}}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="contact">Contato</label>
                                    <input type="text" name="contact" id="contact" class="form-control" value="{{isset($result->contact)?$result->contact:old('contact')}}">
                                    @error('contact')
                                    <p class="text-danger">{{$message??''}}</p>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-{{($result??'')?'warning':'info'}}" type="submit">@if($result??'') Editar @else Cadastrar @endif</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection