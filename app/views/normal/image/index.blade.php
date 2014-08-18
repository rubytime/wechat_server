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


    <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
	<div id="blueimp-gallery" class="blueimp-gallery">
    	<!-- The container for the modal slides -->
    	<div class="slides"></div>
    	<!-- Controls for the borderless lightbox -->
   		<h3 class="title"></h3>
    	<a class="prev">‹</a>
   		<a class="next">›</a>
    	<a class="close">×</a>
    	<a class="play-pause"></a>
    	<ol class="indicator"></ol>
    	<!-- The modal dialog, which will be used to wrap the lightbox content -->
    	<div class="modal fade">
        	<div class="modal-dialog">
            	<div class="modal-content">
                	<div class="modal-header">
                    	<button type="button" class="close" aria-hidden="true">&times;</button>
                    	<h4 class="modal-title"></h4>
                	</div>
                	<div class="modal-body next"></div>
                	<div class="modal-footer">
                    	<button type="button" class="btn btn-default pull-left prev">
                        	<i class="glyphicon glyphicon-chevron-left"></i>
                        	Previous
                    	</button>
                    	<button type="button" class="btn btn-primary next">
                        	Next
                        	<i class="glyphicon glyphicon-chevron-right"></i>
                    	</button>
                	</div>
            	</div>
        	</div>
    	</div>
	</div>

	<div id="links">
		@foreach($images as $image)
    	<a href="{{asset($image->img_big)}}" title="Banana" data-gallery>
        	<img src="{{asset($image->img_min)}}" alt="Banana">
    	</a>
    	@endforeach
	</div>
@stop