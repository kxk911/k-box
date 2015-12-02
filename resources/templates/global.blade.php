<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
        	@if( isset($pagetitle) ) {{ $pagetitle }} &ndash; @endif 
        	K&middot;Link DMS
        </title>
        <meta name="description" content="The K-Link Document Management System">
        <meta name="viewport" content="width=device-width, initial-scale=1">




		<link rel="stylesheet" href="{{ url(elixir("css/all.css")) }}">

		<!--[if lt IE 9]>
			<link rel="stylesheet" href="{{ url(elixir("css/ie8.css")) }}">
			<script src="{{ url("js/ie8-shivm.js") }}"></script>    
		<![endif]-->

		
		<script type="text/javascript" src="{{ url(elixir("js/vendor.js")) }}"></script>
		
		@include('require-config')
                
		<meta name="token" content="{{{ csrf_token() }}}">

		<meta name="base" content="{{ url('/') }}/">
		
		<link rel="apple-touch-icon" sizes="57x57" href="{{ url('/') }}/apple-touch-icon-57x57.png?v=1">
		<link rel="apple-touch-icon" sizes="60x60" href="{{ url('/') }}/apple-touch-icon-60x60.png?v=1">
		<link rel="apple-touch-icon" sizes="72x72" href="{{ url('/') }}/apple-touch-icon-72x72.png?v=1">
		<link rel="apple-touch-icon" sizes="76x76" href="{{ url('/') }}/apple-touch-icon-76x76.png?v=1">
		<link rel="apple-touch-icon" sizes="114x114" href="{{ url('/') }}/apple-touch-icon-114x114.png?v=1">
		<link rel="apple-touch-icon" sizes="120x120" href="{{ url('/') }}/apple-touch-icon-120x120.png?v=1">
		<link rel="apple-touch-icon" sizes="144x144" href="{{ url('/') }}/apple-touch-icon-144x144.png?v=1">
		<link rel="apple-touch-icon" sizes="152x152" href="{{ url('/') }}/apple-touch-icon-152x152.png?v=1">
		<link rel="apple-touch-icon" sizes="180x180" href="{{ url('/') }}/apple-touch-icon-180x180.png?v=1">
		<link rel="icon" type="image/png" href="{{ url('/') }}/favicon-32x32.png?v=1" sizes="32x32">
		<link rel="icon" type="image/png" href="{{ url('/') }}/android-chrome-192x192.png?v=1" sizes="192x192">
		<link rel="icon" type="image/png" href="{{ url('/') }}/favicon-96x96.png?v=1" sizes="96x96">
		<link rel="icon" type="image/png" href="{{ url('/') }}/favicon-16x16.png?v=1" sizes="16x16">
		<link rel="manifest" href="{{ url('/') }}/manifest.json">
		<meta name="apple-mobile-web-app-title" content="K-Link DMS">
		<meta name="application-name" content="K-Link DMS">
		<meta name="msapplication-TileColor" content="#603cba">
		<meta name="msapplication-TileImage" content="{{ url('/') }}/mstile-144x144.png?v=1">
		<meta name="theme-color" content="#ffffff">

	</head>
	<body class="{{$body_classes}}">

		<div class="long-running-message" id="long-running-message">
			{!! trans('notices.long_running_msg') !!}
		</div>

		@yield('header')

		<!-- Content -->
		<div class="container page-content" id="page" role="content">

			@if(Session::has('flash_message'))

				<div class="alert success">
					{{session('flash_message')}}
				</div>

			@endif


			@yield('content')

		</div>
		<!-- /Content -->

		@yield('footer')

		@yield('panels')

	

	@yield('scripts')
	
	
	
	<script>
		
		UserVoice=window.UserVoice||[];(function(){var uv=document.createElement('script');uv.type='text/javascript';uv.async=true;uv.src='//widget.uservoice.com/{{\Config::get("dms.feedback_api_key")}}.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(uv,s)})();

		UserVoice.push(['set', {
		  accent_color: '#448dd6',
		  trigger_color: 'white',
		  trigger_background_color: '#448dd6',
		  ticket_custom_fields: {
		    'Product': 'DMS',
		    'Type': 'Support Request',
			'Version':'{{\Config::get("dms.version")}}',
			'Institution':'{{\Config::get("dms.institutionID")}}',
			@if(isset($context))
				'context': '{{$context}} @if(isset($context_group)) group: {{$context_group}}, @endif @if(isset($current_visibility)) visibility: {{$current_visibility}}, @endif @if(isset($search_terms)) search: {{$search_terms}} @endif'
			@endif
		  },
		}]);
		
		@if(isset($feedback_loggedin) && $feedback_loggedin)
		UserVoice.push(['identify', {
		  email:      '{{$feedback_user_mail}}',
		  name:       '{{$feedback_user_name}}',
		}]);
		
		@endif
		
		UserVoice.push(['addTrigger', { mode: 'contact', trigger_position: 'bottom-right' }]);
		UserVoice.push(['addTrigger', '#support_trigger', { }]);
		UserVoice.push(['autoprompt', {}]);
	</script>

	</body>
	
</html>
		