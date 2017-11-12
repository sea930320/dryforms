@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Models
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Models</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Models {{$models->count() > 0 ? '(' . $models->count() . ')' : ''}}</div>
                    <a class="btn btn-xs btn-primary pull-right" href="{{ route('models.create') }}">
                        <i class="fa fa-plus-circle"></i> Create new
                    </a>
                </div>

                <div class="box-body">

                    @if($models->count())
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($models as $model)
                                <tr>
                                    <td>{{ $model->name }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-danger pull-right remove" data-href="{{ route('models.destroy', $model->id) }}">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                        <a class="btn btn-xs btn-default pull-right" href="{{ route('models.edit', $model->id) }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <h2>There is no models in database</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
