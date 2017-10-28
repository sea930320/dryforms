@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Users
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
                    {{--<div class="box-title">Plans ({{ $users->total() }})</div>--}}
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created at</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--@foreach($users as $user)--}}
                            {{--<tr>--}}
                                {{--<td>{{ $user->name }}</td>--}}
                                {{--<td>{{ $user->email }}</td>--}}
                                {{--<td>{{ $user->created_at }}</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                        </tbody>
                    </table>
                </div>
{{--                {{ $users->links() }}--}}
            </div>
        </div>
    </div>
@endsection
