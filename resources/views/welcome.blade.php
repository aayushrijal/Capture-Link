<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Link Pirates</title>

	<style>
		html, body {
			background-color: #fff;
			color: #636b6f;
			font-family: 'Raleway', sans-serif;
			font-weight: 100;
			height: 100vh;
			margin: 0;
		}

		.full-height {
			height: 100vh;
		}

		.flex-center {
			align-items: center;
			display: flex;
			justify-content: center;
		}

		.position-ref {
			position: relative;
		}

		.top-right {
			position: absolute;
			right: 10px;
			top: 18px;
		}

		.content {
			text-align: center;
		}

		.title {
			font-size: 84px;
		}

		.links > a {
			color: #636b6f;
			padding: 0 25px;
			font-size: 12px;
			font-weight: 600;
			letter-spacing: .1rem;
			text-decoration: none;
			text-transform: uppercase;
		}

		.m-b-md {
			margin-bottom: 30px;
		}
	</style>
</head>
<body>
<div class="flex-center position-ref full-height">
	@if (Route::has('login'))
		<div class="top-right links">
			@if (Auth::check())
				<a href="{{ url('/home') }}">Home</a>
			@else
				<a href="{{ url('/login') }}">Login</a>
				<a href="{{ url('/register') }}">Register</a>
			@endif
		</div>
	@endif

	<div class="content">
		<div class="title m-b-md">
			L
		</div>

		<ul>
			@foreach($apis as $api)
				@if($api->type == 'message')
					<?php
					preg_match_all(
							'#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#',
							$api->message,
							$match
					);
					?>
					@if(!empty($match[0]))
						<li>{{ $api->from->name }} shared a link <a href='{{ $match[0][0] }}'
																	target="_blank">{{$match[0][0]}}</a></li>
					@endif
				@endif
			@endforeach
		</ul>
	</div>
</div>
</body>
</html>
