@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Categories
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Categories</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Categories {{$categories->count() > 0 ? '(' . $categories->count() . ')' : ''}}</div>
                    <a class="btn btn-xs btn-primary pull-right" href="{{ route('categories.create') }}">
                        <i class="fa fa-plus-circle"></i> Create new
                    </a>
                </div>

                <div class="box-body">

                    @if($categories->count())
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Prefix</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->prefix }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-danger pull-right remove" data-href="{{ route('categories.destroy', $category->id) }}">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                        <a class="btn btn-xs btn-default pull-right" href="{{ route('categories.edit', $category->id) }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <h2>There is no categories in database</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
