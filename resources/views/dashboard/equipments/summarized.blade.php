@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Summarized equipment
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Summarized equipment</li>
        </ol>
    </section>
@endsection

@section('after_scripts')
    <script src="{{ asset('js') }}/dashboard.js"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" id="equipments-summarized">
                <div class="box-header with-border">
                    <div class="box-title">Categories {{$categories->count() > 0 ? '(' . $categories->count() . ')' : ''}}</div>
                    <a class="btn btn-xs btn-primary pull-right" href="#"  data-toggle="modal" data-target="#add-equipment">
                        <i class="fa fa-plus-circle"></i> Add Equipment
                    </a>
                </div>

                <div class="box-body">

                    @if($categories->count())
                        @foreach($categories as $category)
                            <h3 class="text-center">{{$category->name}}</h3>

                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 300px;">Make\Model</th>
                                    <th>Total</th>
                                    @foreach($statuses as $status)
                                        <th>{{$status->name}}</th>
                                    @endforeach
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($category->models as $model)
                                    <tr>
                                        <td>{{ $model->name }}</td>
                                        @if($model->equipments)
                                            <td>{{ $model->equipments->count() }}</td>
                                            @foreach($statuses as $status)
                                                <th>{{ $model->equipments->where('status_id', $status->id)->count() }}</th>
                                            @endforeach
                                        @else
                                            @foreach($statuses as $status)
                                                <th></th>
                                            @endforeach
                                        @endif
                                        <td>
                                            <a class="btn btn-xs btn-primary pull-right" href="{{ route('equipments.index', $model->id) }}">
                                                <i class="fa fa-edit"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    @else
                        <h2>There is no categories in database</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal {{$errors->getMessages() ? 'open' : '' }}" tabindex="-1" role="dialog" id="add-equipment">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {{ Form::open(['route' => 'equipments.store']) }}
                    <div class="modal-header">
                        <h5 class="modal-title">Add Equipment
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {{Form::label('category', 'Category')}}
                            <div class="col-xs-12">
                                <div class="row">
                                    {{Form::select('category', $categories->pluck('name', 'id')->toArray(), null, ['class' => 'form-control',
                                     'style' => 'width: calc(100% - 79px);float: left;'])}}
                                    <a href="{{route('categories.create')}}" style="border-radius: 0;" class="btn btn-success">Add New</a>
                                </div>
                            </div>
                            @if($errors->has('category'))
                                <span class="text-danger">{{ $errors->first('category') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{Form::label('model', 'Make\Model')}}
                            <div class="col-xs-12">
                                <div class="row">
                                    {{Form::select('model', [], null, ['class' => 'form-control',
                                     'style' => 'width: calc(100% - 79px);float: left;'])}}
                                    <a href="{{route('models.create')}}" style="border-radius: 0;" class="btn btn-success">Add New</a>
                                </div>
                            </div>
                            @if($errors->has('model'))
                                <span class="text-danger">{{ $errors->first('model') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{Form::label('team', 'Team')}}
                            <div class="col-xs-12">
                                <div class="row">
                                    {{Form::select('team', $teams->pluck('name', 'id')->toArray(), null, ['class' => 'form-control',
                                     'style' => 'width: calc(100% - 79px);float: left;'])}}
                                    <a href="{{route('teams.create')}}" style="border-radius: 0;" class="btn btn-success">Add New</a>
                                </div>
                            </div>
                            @if($errors->has('team'))
                                <span class="text-danger">{{ $errors->first('team') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{Form::label('status', 'Status')}}
                            <div class="col-xs-12">
                                <div class="row">
                                    {{Form::select('status', $statuses->pluck('name', 'id')->toArray(), null, ['class' => 'form-control',
                                     'style' => 'width: calc(100% - 79px);float: left;'])}}
                                    <a href="{{route('statuses.create')}}" style="border-radius: 0;" class="btn btn-success">Add New</a>
                                </div>
                            </div>
                            @if($errors->has('team'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{Form::label('quantity', 'Quantity')}}
                            {{Form::number('quantity', null, ['class' => 'form-control', 'required' => 'true', 'min' => '1'])}}
                            @if($errors->has('quantity'))
                                <span class="text-danger">{{ $errors->first('quantity') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-actions">
                            <button class="btn btn-secondary cancel" data-dismiss="modal">Cancel</button>
                            {{ Form::submit('Create',['class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
