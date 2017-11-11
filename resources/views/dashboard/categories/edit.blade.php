@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Categories
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li><a href="{{ route('categories.index') }}">Categories</a></li>
            <li class="active">Edit Category</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ route('categories.index') }}"><i class="fa fa-angle-double-left"></i> Back to categories</a>
            <br>
            <br>
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Edit Category</div>
                </div>

                <div class="box-body">
                    {{ Form::model($category, ['route' => ['categories.update', $category->id]]) }}
                        {{Form::hidden('_method', 'PUT')}}
                        <div class="form-group">
                            {{Form::label('name', 'Name')}}
                            {{Form::text('name', $category->name, ['class' => 'form-control'])}}
                            @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{Form::label('prefix', 'Prefix')}}
                            {{Form::text('prefix', $category->name,, ['class' => 'form-control'])}}
                            @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('prefix') }}</span>
                            @endif
                        </div>
                        <div class="form-actions">
                            <a href="{{route('categories.index')}}" class="btn btn-primary cancel">Cancel</a>
                            {{ Form::submit('Edit',['class' => 'btn btn-primary']) }}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
