<!-- Error panel -->

<a href="#close" title="{{trans('panels.close_btn')}}" class="close icon-navigation-black icon-navigation-black-ic_close_black_24dp"></a>

<div class="header">

	<h4 class="title">
		@if(isset($error_title))
			{{$error_title}}
		@else
			{{ trans('errors.panels.title') }}
		@endif</h4>

</div>

<p>{{$message}}</p>
