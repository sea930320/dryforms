@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Training - Categories
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li><a href="{{ route('categories.index') }}">Categories</a></li>
            <li class="active">Edit {{ $category->name }}</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ route('categories.index') }}"><i class="fa fa-angle-double-left"></i> Back to Categories</a>
            <br>
            <br>
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Edit {{ $category->name }}</div>
                </div>

                <div class="box-body">
                    <form method="post" action="{{ route('categories.update', $category->id) }}">
                        <input type="hidden" name="_method" value="patch">
                        <input type="hidden" id="category_id" name="category_id" value="{{ $category->id }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Menu Name *</label>
                            <input type="text" class="form-control" name="name" @isset($category) value="{{ $category->name }}" @endisset>
                            @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Category Title *</label>
                            <input type="text" class="form-control" name="title" @isset($category) value="{{ $category->title }}" @endisset>
                            @if($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <hr>
                        <label>Video Url</label>
                        <div class="box-body" ng-app="videosApp" ng-controller="videosCtrl">
                        <div ng-if="loading" class="loader">
                        </div>
                        <div ng-if="!loading">
                            <div class="control-panel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-hover videosTable text-center thead-dark" align-v="center">
                                            <tr>
                                                <th> No </th>
                                                <th> Url </th>
                                                <th> Actions </th>
                                            </tr>
                                            <tr ng-repeat='(index, video) in videos'>
                                                <td> <% index+1 %> </td>
                                                <td> <%video.url%> </td>
                                                <td>
                                                    <button class="btn" type="button" ng-click="deleteVideo(video.id)"> 
                                                        <i class="fa fa-trash text-danger"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">

                                            <input type="text" class="form-control" placeholder="Add Video"  ng-model="newVideo">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" ng-click="addVideo()" ng-disabled="newVideo===''">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-sm btn-primary" id="submitForm">Save</button>
                        </div>
                    </form>
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
    <script src="{{ asset('js/videos/app.js') }}"></script>
@endsection