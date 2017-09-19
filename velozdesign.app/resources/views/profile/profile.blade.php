@extends('layouts.layout')
@section('content')

<div class="container profile-carded">
	<div class="container">
		<div class="profile-header view">
			<div class="profile-pic-container">
				<a class="profile-pic-border" href="#">
					<img class="profile-pic" width="173" height="173" src="{{$user_profile_data['profile_img']['avatar'][0]}}">
					<div class="edit-prof-photo" id="changePhoto">Change your cover</div>
				</a>
			</div>
			<div class="profile-cover">
				<img id="coverImage" class="cover-image custom-cover offset-cover" src="{{$user_profile_data['profile_img']['cover'][0]}}">
				<div class="edt-cover" id="changeCover">Change your avatar</div>
			</div>
			<div class="profile-info">
				<div class="profile-title">
					<div id="profile-t">{{$user_profile_data['name']}}</div>
					<span style="display:none" id="hid"></span>
					<div class="profile-pro-reviews">
						<span class="sprite-profile-icons pi-pro-badge-green"></span>
						@if ($review_brief['num_rate'] > 0)
						<span itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
							<div class="pro-rating">
								<a class="review-star-link colorLink" compid="review" href="#">
									<span>
										<span class="glyphicon glyphicon-star-empty"></span>
										<span class="glyphicon glyphicon-star-empty"></span>
										<span class="glyphicon glyphicon-star-empty"></span>
										<span class="glyphicon glyphicon-star-empty"></span>
										<span class="glyphicon glyphicon-star-empty"></span>
									</span>
									{{$review_brief['average_rate']}}
									<span class="pro-review-string">
										<span itemprop="reviewCount">{{$review_brief['num_rate']}}</span> Reviews
									</span>
								</a>
								<meta itemprop="ratingValue" content="5">
							</div>
						</span>
						@endif
						@if ($show_review_btn)
							<a class="pro-review-string pro-review-btn" ">Review Me<span class="more-icon">></span></a>
						@endif
					</div>
					<div class="profile-pro-actions">
						<button class="btn btn-primary btn-sm" onclick="contactPop();">Contact Me</button>
					</div>
				</div>
			</div>
			<div id="shareListWrapper">
				<div class="social-share-list">
					<div id="shareTable" class="shareTable">
						<span>FB</span>
						<span>Twitter</span>
						<span>G+</span>
					</div>
				</div>
			</div>
			
			<div id="contactPopup"></div>
			<div class="sidebar-group-inline sidebar profile-tabs">
				<div class="navbar-form">
					<ul class="list-inline list-unstyled touch-scroll-list ">
						<li id="mytab" class="sidebar-item" style="width:56%;margin-left:20%;float:left;"></li>
					</ul>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="container">
	<div class="hz-main-contents">
		<div id="profileMainContent" class="comp-box">
			<div class="container pro-profile profile-meta">
				<div style="float:left;width:20%;height:100%;padding:0;">
					<div id="leftp"></div>
				</div>
				<div style="float:left;width:55%;height:100%;">
					<div id="mhome"></div>
				</div>
				<div class="rightsideBar" style="float:right;width:25%;height:100%;/*background-color:yellow;*/">
					<div class="profile-about-right">
						<div class="pro-info-horizontal-list text-m text-dt-s">
							<div id="Onetime"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
