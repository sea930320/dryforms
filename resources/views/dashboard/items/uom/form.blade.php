@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Units Of Measure
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li><a href="{{ route('units-of-measure.index') }}">Units Of Measure</a></li>
            <li class="active">{{ isset($uom) ? 'Edit' : 'Create' }} Unit Of Measure</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ route('units-of-measure.index') }}"><i class="fa fa-angle-double-left"></i> Back to Units of measure</a>
            <br>
            <br>
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ isset($uom) ? 'Edit' : 'Create' }} Unit Of Measure</div>
                </div>

                <div class="box-body">
                    <form method="post"
                          action="@if(isset($uom)) {{ route('units-of-measure.update', $uom->id) }} @else {{ route('units-of-measure.store') }} @endif">
                        @isset($uom)
                            <input type="hidden" name="_method" value="patch">
                        @endisset
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Title *</label>
                            <input type="text" class="form-control" name="title" @isset($uom) value="{{ $uom->title }}" @endisset>
                            @if($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-sm btn-primary">{{ isset($uom) ? 'Edit' : 'Create' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
