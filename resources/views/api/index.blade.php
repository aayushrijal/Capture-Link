@extends('layout')

@section('content')

	<section class="upper">
		<header>
			<div class="container">
				<div class="logo">
					<h3><span>LINK</span> PIRATES</h3>
				</div>
			</div>
		</header>
		<div class="hero">
			<div class="container">
				<h1 class="hero_title">CRADLE OF LINKS</h1>
				<p class="hero_description">A Repo For All Links Shared In YIPL Hipchat Room</p>
			</div>
		</div>
	</section>
	<section class="collection">
		<div class="container">
			<div class="filters">
				<span class="from">From: <input type="date" id="start-date"/></span>
				<span class="to">To: <input type="date" id="end-date"/></span>
				<button id="search-btn" onclick="search()">Search</button>

				<div class="view_options">
					<span class="grid_icon active"></span>
					<span class="list_icon"></span>
				</div>
			</div>
			<p class="links_shared_title">Links Shared Within - This Week</p>
			<div class="row" id="link-list">
				<ul class="shared_links_list list">

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
								<?php $title = '';
								$card = ''
								?>
								@foreach($notifications as $notification)
									@if($api->id == $notification->attach_to)
										<?php $title = json_decode($notification->card)->title ?>
										<?php $card = json_decode($notification->card)->icon->url ?>
									@endif
								@endforeach
								<li class="shared_link">
									<div class="card">
										<div class="media">
											<img src="{{ empty($card) ? asset('images/placehoder_icon.svg') : $card }}"
												 height='35' alt="">
											<a href="{{ $match[0][0] }}" class="media_title"
											   target="_blank">{{ empty($title) ? $match[0][0] : $title }}</a>
											<small class="from">{{ $api->from->name }} <span
														class="shared_date">({{ substr($api->date, 0,10) }})</span>
											</small>
											<div class="select_box">
												<input type="checkbox" class="select_link">
												<span class="select_icon"></span>
											</div>
										</div>
										<div class="mentions">
											Mentioned:
											@if(!empty($api->mentions))
												<span>{{ '@'.($api->mentions[0]->mention_name) }}</span>
											@else
												<span>{{ '@all' }}</span>
											@endif
										</div>
									</div>
								</li>
							@endif
						@endif
					@endforeach
				</ul>
			</div>
		</div>
	</section>

	<p id="copy_text"></p>
	<span class="copy_icon" title="Copy links to clipboard" data-clipboard-target="#copy_text"></span>
	<script src="http://listjs.com/assets/javascripts/list.min.js"></script>
	<script>
		function search() {
			var options = {
				valueNames: ['shared_date']
			};
			var hackerList = new List('link-list', options),
					sDate, eDate, cDate;

			hackerList.filter(function(item) {
				sDate = document.getElementById("start-date").value;
				eDate = document.getElementById("end-date").value;
				cDate = item._values.shared_date.replace(/[{()}]/g, '');
				sDate = (sDate.length==0) ? null : Date.parse(sDate);
				eDate = (eDate.length==0) ? null : Date.parse(eDate);
				cDate = (cDate.length==0) ? null : Date.parse(cDate);

				if((sDate == null && eDate == null) || (cDate <= eDate && cDate >= sDate)) {
					return true;
				}
			});
		}
	</script>


@endsection