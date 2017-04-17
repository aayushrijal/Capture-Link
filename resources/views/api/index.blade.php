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
				<button id="reset-btn" onclick="resetFilter()">Reset</button>
				<button id="sort-btn" sort_order="desc" onclick="linkSort(this)">Sort</button>


				<div class="view_options">
					<span class="grid_icon active"></span>
					<span class="list_icon"></span>
				</div>
			</div>
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
									@if(isset($notification->attach_to))
										@if($api->id == $notification->attach_to)
											<?php $title = json_decode($notification->card)->title ?>
											<?php $card = json_decode($notification->card)->icon->url ?>
										@endif
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
	<p class="copiedConfirm">Links copied to clipboard</p>
	<span class="copy_icon" title="Copy links to clipboard" data-clipboard-target="#copy_text">
		{{--<span class="copiedConfirm">Links copied to clipboard</span>--}}
	</span>
	<script src="http://listjs.com/assets/javascripts/list.min.js"></script>
	<script>
		var options = {
			valueNames: ['shared_date']
		};
		var hackerList = new List('link-list', options);
		function search() {
			var sDate = document.getElementById("start-date").value,
					eDate = document.getElementById("end-date").value,
					cDate;

			if((sDate.length != 0 && eDate.length == 0) || (sDate.length == 0 && eDate.length != 0) ) {
				alert('missing datefield value');
				return;
			}

			if(Date.parse(sDate) > Date.parse(eDate)) {
				alert('start date cannot be more than end Date');
				return;
			}

			sDate = (sDate.length == 0) ? null : Date.parse(sDate);
			eDate = (eDate.length == 0) ? null : Date.parse(eDate);

			hackerList.filter(function (item) {
				sDate = document.getElementById("start-date").value;
				eDate = document.getElementById("end-date").value;
				sDate = (sDate.length == 0) ? null : Date.parse(sDate);
				eDate = (eDate.length == 0) ? null : Date.parse(eDate);
				cDate = item._values.shared_date.replace(/[{()}]/g, '');
				cDate = (cDate.length == 0) ? null : Date.parse(cDate);

				if ((sDate == null && eDate == null) || (cDate <= eDate && cDate >= sDate)) {
					return true;
				}
			});
		}

		function resetFilter() {
			if(document.getElementById("start-date").value.length != 0) {
				document.getElementById("start-date").value = '';
			}
			if(document.getElementById("end-date").value) {
				document.getElementById("end-date").value = '';
			}
			search();
		}
		
		function linkSort(btn) {
			var sort_order;
			if(btn.getAttribute('sort_order')=='desc') {
				sort_order = btn.getAttribute('sort_order');
				btn.setAttribute('sort_order','asc');
			}
			else {
				sort_order = btn.getAttribute('sort_order');
				btn.setAttribute('sort_order','desc')
			}
			var options = {
				valueNames: ['shared_date']
			};
			var sortList = new List('link-list', options);
			sortList.sort('shared_date', {
				order: sort_order,
				insensitive: true,
			});
		}
	</script>


@endsection