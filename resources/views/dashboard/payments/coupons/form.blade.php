@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Coupons
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li><a href="{{ route('coupons.index') }}">Coupons</a></li>
            <li class="active">{{ isset($coupon) ? 'Edit' : 'Create' }} Coupon</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ route('coupons.index') }}"><i class="fa fa-angle-double-left"></i> Back to coupons</a>
            <br>
            <br>
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ isset($coupon) ? 'Edit' : 'Create' }} Plan</div>
                </div>

                <div class="box-body">
                    <form method="post"
                          action="@if(isset($coupon)) {{ route('coupons.update', $coupon->id) }} @else {{ route('coupons.store') }} @endif">
                        @isset($coupon)
                            <input type="hidden" name="_method" value="patch">
                        @endisset
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>ID *</label>
                            <input type="text" class="form-control" name="id">
                            @if($errors->has('id'))
                                <span class="text-danger">{{ $errors->first('id') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Duration *</label>
                            <select class="form-control" name="duration">
                                <option value="">-- Please select --</option>
                                <option value="forever">Forever</option>
                                <option value="once">Once</option>
                                <option value="repeating">Repeating</option>
                            </select>
                            @if($errors->has('duration'))
                                <span class="text-danger">{{ $errors->first('duration') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Amount Off (USD)</label>
                            <input type="number" class="form-control" name="amount_off">
                            @if($errors->has('amount_off'))
                                <span class="text-danger">{{ $errors->first('amount_off') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Percent Off (%)</label>
                            <input type="number" class="form-control" name="percent_off" max="100">
                            @if($errors->has('percent_off'))
                                <span class="text-danger">{{ $errors->first('percent_off') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Max redemptions</label>
                            <input type="number" class="form-control" name="max_redemptions" max="100">
                            @if($errors->has('max_redemptions'))
                                <span class="text-danger">{{ $errors->first('max_redemptions') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Duration in months</label>
                            <input type="number" class="form-control" name="duration_in_months">
                            @if($errors->has('duration_in_months'))
                                <span class="text-danger">{{ $errors->first('duration_in_months') }}</span>
                            @endif
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-sm btn-primary">{{ isset($coupon) ? 'Edit' : 'Create' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
