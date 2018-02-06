@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Units Of Measure
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Units Of Measure</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">

                <div class="box-header with-border">
                    <div class="box-title">Units Of Measure ({{ $uoms->total() }})</div>
                    <a class="btn btn-xs btn-primary pull-right" href="{{ route('units-of-measure.create') }}">
                        <i class="fa fa-plus-circle"></i> Create new
                    </a>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($uoms as $uom)
                            <tr>
                                <td>{{ $uom->title }}</td>
                                <td>
                                    <a class="btn btn-xs btn-danger pull-right remove" data-href="{{ route('units-of-measure.destroy', $uom->id) }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                    <a class="btn btn-xs btn-default pull-right" href="{{ route('units-of-measure.edit', $uom->id) }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $uoms->links() }}
            </div>
        </div>
    </div>
@endsection
