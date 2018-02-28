@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Forms
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li><a href="{{ route('forms.index') }}">Forms</a></li>
            <li class="active">Edit {{ $form->name }}</li>
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
                    <div class="box-title">Edit {{ $form->name }}</div>
                </div>

                <div class="box-body">
                    <form method="post" action="{{ route('forms.update', $form->id) }}">
                        <input type="hidden" name="_method" value="patch">
                        <input type="hidden" name="form_id" value="{{ $form->form_id }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Menu Name *</label>
                            <input type="text" class="form-control" name="name" @isset($form) value="{{ $form->name }}" @endisset>
                            @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Form Title *</label>
                            <input type="text" class="form-control" name="title" @isset($form) value="{{ $form->title }}" @endisset>
                            @if($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <hr>
                        <label>Form Statements</label>
                        @foreach($form->default_statements as $defaultStatement)                            
                            <div class="form-group">
                                @isset($form)
                                    <input type="hidden" name="statement_ids[]" value="{{$defaultStatement->id}}">
                                @endisset
                                <input type="text" class="form-control" name="statement_titles[]" @isset($form) value="{{$defaultStatement->title}}" @endisset>                                
                                <textarea class="form-control statements" name="statement_texts[]">
                                @isset($form)
                                    {{ $defaultStatement->statement }}
                                @endisset
                                </textarea>
                            </div>
                        @endforeach

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
        .fr-view p{
            font-size: inherit;
        }
    </style>
@endsection
@section('after_scripts')
    <script>
        $(document).ready(function() {
            $('.statements').froalaEditor({
                key: "{{ config('constants.froala_key') }}",
                height: 400,
                fontSizeDefaultSelection: '14',
                fontSizeSelection: true 
            })
        });
    </script>
@endsection