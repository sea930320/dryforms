@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Teams
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li><a href="{{ route('teams.index') }}">Teams</a></li>
            <li class="active">Create Team</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ route('teams.index') }}"><i class="fa fa-angle-double-left"></i> Back to teams</a>
            <br>
            <br>
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Create Team</div>
                </div>

                <div class="box-body">
                    {{ Form::open(['route' => 'teams.store']) }}
                    <div class="form-group">
                        {{Form::label('name', 'Name')}}
                        {{Form::text('name', null, ['class' => 'form-control'])}}
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-actions">
                        <a href="{{route('teams.index')}}" class="btn btn-primary cancel">Cancel</a>
                        {{ Form::submit('Create',['class' => 'btn btn-primary']) }}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
