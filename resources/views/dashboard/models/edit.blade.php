@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Models
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li><a href="{{ route('models.index') }}">Models</a></li>
            <li class="active">Edit Model</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ route('categories.index') }}"><i class="fa fa-angle-double-left"></i> Back to models</a>
            <br>
            <br>
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Edit Model</div>
                </div>

                <div id="edit-model"  class="box-body">
                    {{ Form::model($model, ['route' => ['models.update', $model->id]]) }}
                        {{Form::hidden('_method', 'PUT')}}
                        <div class="form-group">
                            {{Form::label('name', 'Name')}}
                            {{Form::text('name', $model->name, ['class' => 'form-control'])}}
                            @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{Form::label('category', 'Category')}}
                            <div class="col-xs-12">
                                <div class="row">
                                    {{Form::select('category_id', $categories->pluck('name', 'id')->toArray(), null, ['class' => 'form-control'])}}
                                    <a href="{{route('categories.create')}}" class="btn btn-success add-new">Add New</a>
                                </div>
                            </div>
                            @if($errors->has('category'))
                                <span class="text-danger">{{ $errors->first('category') }}</span>
                            @endif
                        </div>
                        <div class="form-actions">
                            <a href="{{route('models.index')}}" class="btn btn-primary cancel">Cancel</a>
                            {{ Form::submit('Edit',['class' => 'btn btn-primary']) }}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
