@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
Images :: @parent
@stop

@section('content')

    {{ Form::open(array('url' => 'normal/images/upload', 'method' => 'post', 'id' => 'upload-image', 'enctype' => 'multipart/form-data', 'files' => true)) }}
        {{ Form::file('file[]', array('multiple' => 'multiple', 'id' => 'multiple-files', 'accept' => 'image/*')) }}

        <div id="files"></div>

        <div class="form-group" id="form-buttons">
            {{ Form::submit('Upload images', array('class' => 'btn btn-block')) }}

            {{ Form::reset('Reset', array('class' => 'btn btn-block', 'id' => 'reset')) }}
        </div>

    {{ Form::close() }}

    <div id="notifications">

        @if (Session::has('image-message'))
            <div class="alert {{ Session::get('status') }} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('image-message') }}
            </div>
        @endif

        @if (Session::has('files'))

            @foreach (Session::get('files') as $file)
                <div class="alert alert-info">{{ HTML::link('show/' . $file, 'Link to your image.') }}</div>
            @endforeach

        @endif

    </div>
@stop