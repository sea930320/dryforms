@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Teams Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li><a href="{{ route('forms.index') }}">Forms</a></li>
            <li class="active">Edit Teams</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ route('forms.index') }}"><i class="fa fa-angle-double-left"></i> Back to Forms</a>
            <br>
            <br>
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Edit Teams</div>
                </div>
                <div class="box-body" ng-app="teamsApp" ng-controller="teamsCtrl">
                    <div ng-if="loading" class="loader">
                    </div>
                    <div ng-if="!loading">
                        <div class="control-panel">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-hover teamsTable text-center thead-dark" align-v="center">
                                        <tr>
                                            <th> No </th>
                                            <th> Name </th>
                                            <th> Actions </th>
                                        </tr>
                                        <tr ng-repeat='(index, team) in teams'>
                                            <td> <% index+1 %> </td>
                                            <td> <%team.name%> </td>
                                            <td>
                                                <button class="btn" ng-click="deleteTeam(team.id)"> 
                                                    <i class="fa fa-trash text-danger"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Add Team"  ng-model="newTeam">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" ng-click="addTeam()" ng-disabled="newTeam===''">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_styles')
    <style>
        .box-body {
            min-height: 500px;
        }
        .loader {
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 1;
            width: 80px;
            height: 80px;
            margin: -40px 0 0 -40px;
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #3498db;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }
        .input-group {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -webkit-box-align: stretch;
            -ms-flex-align: stretch;
            align-items: stretch;
            width: 100%;
        }
        .input-group>.form-control {
            position: relative;
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            width: 1%;
            margin-bottom: 0;
        }
        .input-group-append, .input-group-prepend {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }
    </style>
@endsection
@section('after_vendor_scripts')
    <script src="{{ asset('js/teams/app.js') }}"></script>
@endsection