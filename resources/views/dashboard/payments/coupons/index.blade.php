@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Coupons
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Coupons</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Coupons ({{ count($coupons->data) }})</div>
                    <a class="btn btn-xs btn-primary pull-right" href="{{ route('coupons.create') }}">
                        <i class="fa fa-plus-circle"></i> Create new
                    </a>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Amount Off</th>
                            <th>Duration</th>
                            <th>Duration in months</th>
                            <th>Times redeemed/Max redemptions</th>
                            <th>Percent Off</th>
                            <th>Valid</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($coupons->data as $coupon)
                            <tr>
                                <td>{{ $coupon->id }}</td>
                                <td>{{ $coupon->amount_off ? '$' . $coupon->amount_off / 100 : 'n/a' }}</td>
                                <td>{{ $coupon->duration }}</td>
                                <td>{{ $coupon->duration_in_months ?? 'n/a' }}</td>
                                <td>{{ $coupon->max_redemptions ? ($coupon->times_redeemed . '/' . $coupon->max_redemptions) : 'n/a' }}</td>
                                <td>{{ $coupon->percent_off ? $coupon->percent_off . '%' : 'n/a' }}</td>
                                <td>{{ $coupon->valid ? 'yes' : 'no' }}</td>
                                <td>
                                    <a class="btn btn-xs btn-danger pull-right remove" data-href="{{ route('coupons.destroy', $coupon->id) }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                    <a class="btn btn-xs btn-default pull-right" href="{{ route('coupons.edit', $coupon->id) }}">
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
