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
            <h1 class="hero_title">WE STEAL EVERY LINK</h1>
            <p class="hero_description">A Repo For All Links Shared In YIPL Hipchat Room</p>
        </div>
    </div>
</section>
<section class="collection">
    <div class="container">
        <div class="filters">
            <span class="from">From: <input type="date" /></span>
            <span class="to">To: <input type="date" /></span>
            <button class="view_all">All</button>
            
            <div class="view_options">
                <span class="grid_icon active"></span>
                <span class="list_icon"></span>
            </div>
        </div>
        <p class="links_shared_title">Links Shared Within - This Week</p>
        <div class="row">
            <ul class="shared_links_list">
                
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
    						<!-- <li>{{ $api->from->name }} shared a link <a href='{{ $match[0][0] }}'
    																	target="_blank">{{$match[0][0]}}</a></li>-->

    				<li class="shared_link">
                        <div class="card">
                            <div class="media">
                                <img src="placholder_image.png" alt="">
                                <a href="{{ $match[0][0] }}" class="media_title" target="_blank">{{$match[0][0]}}</a>
                                <small class="from">{{ $api->from->name }} <span class="shared_date">({{ substr($api->date, 0,10) }})</span></small>
                                <div class="select_box">
                                    <input type="checkbox" class="select_link">
                                    <span class="select_icon"></span>
                                </div>
                            </div>
                            <div class="mentions">
                                Mentions: <span>@Manish Lal Shrestha</span><span>@Saugat Maharjan</span>
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

<span class="copy_icon" title="Copy links to clipboard"></span>


@endsection