@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Forms
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Forms</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Forms</div>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($forms as $form)
                            @if($form->default_statements->count() > 0)
                                <tr>
                                    <td>{{ $form->name }}</td>
                                    <td>{{ $form->title }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-default pull-right" href="{{ route('forms.edit', $form->id) }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @elseif($form->form->name==='Project Scope')
                                <?php?>
                                <tr>
                                    <td>{{ $form->name }}</td>
                                    <td>{{ $form->title }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-default pull-right" href="{{ route('scopes.index') }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @elseif($form->form->name==='Moisture Map')
                                <?php?>
                                <tr>
                                    <td>{{ $form->name }}</td>
                                    <td>{{ $form->title }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-default pull-right" href="{{ route('moisture-map') }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                            <tr>
                                <td> Affected Areas </td>
                                <td> Affected Areas </td>
                                <td>
                                    <a class="btn btn-xs btn-default pull-right" href="{{ route('areas-page') }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{ $forms->links() }}
            </div>
        </div>
    </div>
@endsection
