@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Training - Category
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Training - Category</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Training - Category</div>
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
                        @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-default pull-right" href="{{ route('categories.edit', $item->id) }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                    
                </div>
                <div class="row" align-h="center">
                    <div cols="6" class="text-center">
                        <button class="btn btn-success" data-toggle="modal" data-target="#addCategory">+&nbsp; Add Category</button>
                        <hr/>
                    </div>
                </div>
                <!-- Modal -->
                <div id="addCategory" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Category</h4>
                      </div>
                      <div class="modal-body">
                        <div class="input-group mb-1">
                            <label for="verify">
                                    Menu Name : 
                            </label>
                            <input id="newname" type="text" class="form-control" name="newname" value="" style="width:550px;" placeholder="name" required autofocus>

                        </div>
                        <div class="input-group mb-1">
                            <label for="verify">
                                    Category Title :
                            </label>
                            <input id="newetitle" type="text" class="form-control" name="newtitle" value="" style="width:550px;" placeholder="title" required >
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" onclick="addNewCategory()" class="btn btn-default" data-dismiss="modal">Add Category</button>
                      </div>
                    </div>

                  </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function addNewCategory()
        {
            newname = $("#newname").val();
            newtitle = $("#newetitle").val();
            $.ajax({ 
                type: 'GET', 
                url: "{{ route('categories.create') }}", 
                data: {
                        name: newname,
                        title: newtitle,
                      },
                dataType: 'json',
                success: function (data) {
                    alert(data["id"]);
                    innerhtml = "<tr>";
                    innerhtml += "<td>"; innerhtml += data["name"]; innerhtml += "</td>";
                    innerhtml += "<td>"; innerhtml += data["title"]; innerhtml += "</td>";
                    innerhtml += "<td>";
                    innerhtml += "<a class=\"btn btn-xs btn-default pull-right\" href=\"/admin/training/categories/" + data["id"] +"/edit\"><i class=\"fa fa-edit\"></i> Edit</a>";
                    innerhtml += "</td>";
                    innerhtml += "</tr>";
                    $("tbody").append(innerhtml);
                }
            });
        }
    </script>
@endsection
