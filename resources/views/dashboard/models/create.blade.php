@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Models
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li><a href="{{ route('models.index') }}">Models</a></li>
            <li class="active">Create Model</li>
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
                    <div class="box-title">Create Model</div>
                </div>

                <div class="box-body">
                    {{ Form::open(['route' => 'models.store']) }}
                    <div class="form-group">
                        {{Form::label('name', 'Name')}}
                        {{Form::text('name', null, ['class' => 'form-control'])}}
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group" style="overflow: hidden">
                        {{Form::label('category', 'Category')}}
                        <div class="col-xs-12">
                            <div class="row">
                                {{Form::select('category_id', $categories->pluck('name', 'id')->toArray(), null, ['class' => 'form-control',
                                 'style' => 'width: calc(100% - 79px);float: left;'])}}
                                <a href="{{route('categories.create')}}" style="border-radius: 0;" class="btn btn-success">Add New</a>
                            </div>
                        </div>
                        @if($errors->has('category'))
                            <span class="text-danger">{{ $errors->first('category') }}</span>
                        @endif
                    </div>
                    <div class="form-actions">
                        <a href="{{route('models.index')}}" class="btn btn-primary cancel">Cancel</a>
                        {{ Form::submit('Create',['class' => 'btn btn-primary']) }}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
