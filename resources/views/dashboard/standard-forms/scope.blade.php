@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Default Project Scopes
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li><a href="{{ route('forms.index') }}">Forms</a></li>
            <li class="active">Edit Project Scopes</li>
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
                    <div class="box-title">Edit Project Scopes</div>
                </div>

                <div class="box-body" ng-app="scopesApp" ng-controller="scopesCtrl">
                    <div ng-if="loading" class="loader">
                    </div>
                    <div ng-if="!loading">
                        <div class="form-group">
                            <label>Menu Name *</label>
                            <input type="text" class="form-control" ng-model="form.name" ng-change="saveForm()">
                        </div>

                        <div class="form-group">
                            <label>Form Title *</label>
                            <input type="text" class="form-control" ng-model="form.title" ng-change="saveForm()">
                        </div>
                        <hr>
                        <div infinite-scroll='nextPage()' infinite-scroll-disabled='busy || endPageFetch' infinite-scroll-distance='1'>
                            <div ng-repeat="page_index in _.range(curPageNum)">
                                <scope-list
                                    left-page-scopes="left_scopes[page_index]"
                                    right-page-scopes="right_scopes[page_index]"
                                    page-index="page_index"
                                    uoms="uoms"
                                    max-page="max_page"
                                >
                                </scope-list>
                            </div>
                            <div ng-show='busy' class="loader" ></div>
                        </div>
                        <div ng-if="endPageFetch">
                            <div class="row" align-h="center">
                                <div cols="6" class="text-center">
                                    <button ng-click="addNewPage()">
                                        Add New Page
                                    </button>
                                    <hr/>
                                </div>
                            </div>
                            <scope-list
                                left-page-scopes="leftMiscScopes"
                                right-page-scopes="rightMiscScopes"
                                page-index="'misc'"
                                uoms="uoms"
                            >
                            </scope-list>
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
        .list-group-item {
            padding: 0px !important;
        }
        .list-group-item table {
            margin-bottom: 1px !important;
        }
        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .checkbox {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            height: 36px !important;
        }
        .checkbox label {
            height: 36px;
            padding-left: 0 !important;
        }
        .checkbox label:after {
            content: '';
            display: table;
            clear: both;
        }

        .checkbox .cr {
            position: relative;
            display: inline-block;
            border: 1px solid #a9a9a9;
            border-radius: .25em;
            width: 1.3em;
            height: 1.3em;
            float: left;
            margin-right: 0;
            margin-top: 9px;
        }
        .checkbox .cr .cr-icon {
            position: absolute;
            font-size: .8em;
            line-height: 0;
            top: 50%;
            left: 20%;
        }

        .checkbox label input[type="checkbox"] {
            display: none;
        }

        .checkbox label input[type="checkbox"] + .cr > .cr-icon {
            transform: scale(3) rotateZ(-20deg);
            opacity: 0;
            transition: all .3s ease-in;
        }

        .checkbox label input[type="checkbox"]:checked + .cr > .cr-icon {
            transform: scale(1) rotateZ(0deg);
            opacity: 1;
        }

        .checkbox label input[type="checkbox"]:disabled + .cr {
            opacity: .5;
        }        
        .fr-quick-insert {
            margin-left: -15px;
            padding: 0px !important;
            display: none;
            background: rgba(0, 0, 0, 0.5);
            width: 20px;
            text-align: center;
        }
        .fr-visible {
            display: block;
        }
        .fr-quick-right {
            right: -10px;
        }
        a.fr-floating-btn {
            text-decoration: none;
            color: white;
        }
        a.fr-floating-btn i {
            line-height: 26px;
        }
        .header-x {
            width: 31px;
        }
        .header-service {
            width: calc(100% - 221px);
        }
        .header-uom {
            width: 100px;
        }
        .header-qty {
            width: 90px;
        }
        .grey {
            background: #cccccc;
            font-weight: bold;            
        }
        .grey div {
            line-height: 36px;
        }
    </style>
@endsection
@section('after_vendor_scripts')
    <script src="{{ asset('js/scopes/app.js') }}"></script>
    <script src="{{ asset('js/scopes/scope-list.js') }}"></script>
@endsection