@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Plans
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Plans</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Plans ({{ count($plans->data) }})</div>
                    <a class="btn btn-xs btn-primary pull-right" href="{{ route('plans.create') }}">
                        <i class="fa fa-plus-circle"></i> Create new
                    </a>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Interval</th>
                            <th>Trial period length</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($plans->data as $plan)
                            <tr>
                                <td>{{ $plan->name }}</td>
                                <td>$ {{ $plan->amount / 100 }}</td>
                                <td>{{ $plan->interval }}</td>
                                <td>{{ $plan->trial_period_days }}</td>
                                <td>
                                    <a class="btn btn-xs btn-default pull-right" href="{{ route('plans.edit', $plan->id) }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
