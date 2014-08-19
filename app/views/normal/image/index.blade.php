@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
Images :: @parent
@stop

{{-- Scripts --}}
@section('before_scripts')
    <script>
        $(document).ready(function () {

            $('.swipeboxEx').each(function (i, el) {
                $(el).justifiedGallery({margins: 10,
                                        sizeRangeSuffixes: {'lt100':'', 
                                                            'lt240':'', 
                                                            'lt320':'', 
                                                            'lt500':'', 
                                                            'lt640':'', 
                                                            'lt1024':''},
                                        rel: 'gal' + i}).on('jg.complete', function () { $('.swipeboxEx a').swipebox(); //swipebox, wants to be called only once to work properly
                });
            });
        });
    </script>
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
	<div id="margin0" style="background-color: white;" class="swipeboxEx">
		@foreach($images as $image)
    	<a href="{{asset($image->img_big)}}" title="Banana">
        	<img alt="Banana" src="{{asset($image->img_min)}}">
    	</a>
    	@endforeach
	</div>
@stop