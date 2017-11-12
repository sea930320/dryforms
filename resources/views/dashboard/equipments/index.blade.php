@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{$model->name}} equipments for category {{$model->category->name   }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">{{$model->name}} equipments for category {{$model->category->name   }}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" id="equipments-index">
                <div class="box-header with-border">
                    <div class="box-title">Equipments <span id="count">{{$model->equipments->count() > 0 ? '(' . $model->equipments->count() . ')' : ''}}</span></div>
                </div>

                <div class="box-body">

                    @if($model->equipments->count())
                        <button id="select-all-equipments" class="btn btn-success pull-right">Select all</button>
                        <button id="bulk-delete-button" class="btn btn-danger pull-right" disabled="disabled">Delete selected</button>
                        <table id="model-equipments" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">#Equipment</th>
                                <th class="text-center">Crew\Team</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($model->equipments as $equipment)
                                <tr data-equipment-id = "{{$equipment->id}}">
                                    <td>
                                        {{ $equipment->serial }}
                                    </td>
                                    <td>
                                        {{Form::select('team', $teams->pluck('name', 'id')->toArray(), $equipment->team->id, ['class' => 'form-control'])}}
                                    </td>
                                    <td class="location-wrapper">
                                        <input class="form-control" type="text" name="location" value="{{$equipment->location}}" data-equipment-id="{{ $equipment->id }}"
                                               {{$equipment->status->name == "Set" || $equipment->status->name == "Loan" ? '' : 'disabled'}}/>
                                        <button class="change-location btn btn-success"
                                                {{$equipment->status->name == "Set" || $equipment->status->name == "Loan" ? '' : 'disabled'}}>Change</button>
                                    </td>
                                    <td>
                                        {{Form::select('status', $statuses->pluck('name', 'id')->toArray(), $equipment->status->id, ['class' => 'form-control'])}}
                                    </td>
                                    <td class="text-center">
                                        {{Form::checkbox('delete[]', $equipment->id, false)}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <h2>There is no equipments related with model {{$model->name}}  </h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
