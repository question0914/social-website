@extends('layouts.app')
@section('content')

<div class="container profile-carded">

	<div class="container">
		<div class="profile-header view">
			<div class="profile-cover">

				<div class="profile-pic-container">
					<a class="profile-pic-border" href="#">
						<img class="profile-pic" width="173" height="173" src="https://st.hzcdn.com/fimgs/21d32eae0f91d56e_7422-w173-h173-b0-p0--loridennis.jpg">
					</a>
				</div>
				<img id="coverImage" class="cover-image custom-cover offset-cover" src="https://st.hzcdn.com/simgs/bd91d4b002fbf2b0_14-3483/contemporary-living-room.jpg"></div>

				<div class="profile-info">

					<div class="profile-title">
						<div id="profile-t"></div>

						<div class="profile-pro-reviews">
							<span class="sprite-profile-icons pi-pro-badge-green"></span>
							<span itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating"><div class="pro-rating"><a class="review-star-link colorLink" compid="review" href="#"><span class="rate-star"><span class="hzi-font hzi-Star fill"></span><span class="hzi-font hzi-Star"></span></span><span class="rate-star"><span class="hzi-font hzi-Star fill"></span><span class="hzi-font hzi-Star"></span></span><span class="rate-star"><span class="hzi-font hzi-Star fill"></span><span class="hzi-font hzi-Star"></span></span><span class="rate-star"><span class="hzi-font hzi-Star fill"></span><span class="hzi-font hzi-Star"></span></span><span class="rate-star"><span class="hzi-font hzi-Star fill"></span><span class="hzi-font hzi-Star"></span></span><span class="pro-review-string"><span itemprop="reviewCount">58</span> Reviews</span></a><meta itemprop="ratingValue" content="5"></div></span>
							<a class="pro-review-string">Review Me<span class="more-icon">></span></a>
							<span class="rate-star"><span class="hzi-font hzi-Star fill">*</span><span class="hzi-font hzi-Star"></span></span>
							<span class="rate-star"><span class="hzi-font hzi-Star fill">*</span><span class="hzi-font hzi-Star"></span></span>
							<span class="rate-star"><span class="hzi-font hzi-Star fill">*</span><span class="hzi-font hzi-Star"></span></span>
							<span class="rate-star"><span class="hzi-font hzi-Star fill">*</span><span class="hzi-font hzi-Star"></span></span>
							<span class="rate-star"><span class="hzi-font hzi-Star fill">*</span><span class="hzi-font hzi-Star"></span></span>
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

				<div class="profile-pro-actions">
					<button class="btn btn-primary" onclick="contactPop();">Contact Me</button>
				</div>
        <div id="contactPopup"></div>

				<div class="sidebar-group-inline sidebar profile-tabs">
					<div class="navbar-form">

						<ul class="list-inline list-unstyled touch-scroll-list ">
							<!-- <li><div class="profile-pic-placeholder"></li> -->
							<li id="mytab" class="sidebar-item" style="width:56%;margin-left:20%;float:left;/*background-color:pink*/"></li>

							<li id="call" class="sidebar-item" > <!--pull-right-->

								<div class="pro-contact-methods on-line">
									<a>Click to Call</a>
									<a>Website</a>
								</div>
							</li>

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

					<div class="leftSideBar">
						<div class="follow-section profile-l-sidebar">
							<a class="followers follow-box" href="#">
								<span class="follow-count">1232</span>Followers
							</a>
							<a class="following follow-box" href="#"><span class="follow-count">23423</span>Following</a>
						</div>
						<div class="follow-section profile-l-sidebar">
							<button class="btn btn-secondary followBtn btn-lg btn-block" id="followButton_loridennis" onclick="uploadphoto();">Follow</button>
						</div>
						<div id="uploadPhoto"></div>

						<div class="profile-l-sidebar clearfix" id="sociallinks">
							<a class="sprite-profile-icons f" href="#"><img class="f" src="https://st.hzcdn.com/res/2573/pic/spacer.gif?v=2573" title="Find me on Facebook"></a>
							<a class="sprite-profile-icons t" href="#"><img class="t" src="https://st.hzcdn.com/res/2573/pic/spacer.gif?v=2573" title="Find me on Twitter"></a>
							<a class="sprite-profile-icons g" href="#"><img class="g" src="https://st.hzcdn.com/res/2573/pic/spacer.gif?v=2573" title="Find me on Google+"></a>
							<a class="sprite-profile-icons l" href="#"><img class="l" src="https://st.hzcdn.com/res/2573/pic/spacer.gif?v=2573" title="Find me on Linkedin"></a>
							<a class="sprite-profile-icons b" href="#"><img class="b" src="https://st.hzcdn.com/res/2573/pic/spacer.gif?v=2573" title="Find me on my blog or other site"></a>
						</div>
					</div>
					<div class="rightSideContent">
						<div class="profile-content-wrapper">

							<div class="profile-content-wide about-section" >
								<div class="profile-about profile-about--regular mbs hzPeekabled" >
										<div id="mhome"></div>
								</div>

							</div>

							<div class="profile-content-narrow">
								<div class="profile-about-right">
									<div class="pro-info-horizontal-list text-m text-dt-s">
										<div id="Onetime"></div>
										<div class="info-list-label">
											<i class="hzi-font hzi-Man-Outline"></i>
											<div class="info-list-text"><b>Contact </b><span id="ctt"></span></div>
										</div>
										<div class="info-list-label">
											<i class="hzi-font hzi-Location"></i>
											<div class="info-list-text">
												<b>Location</b>
												<span ><a href="#">Los Angeles</a></span>
												<span>CA</span>
												<span>90034</span>
											</div>
										</div>
										<div class="info-list-label">
											<i class="hzi-font hzi-Cost-Estimate"></i>
											<div class="info-list-text">
												<b>Typical Job Costs </b><span id="jobcost"></span>
											</div>

										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

</div>

@endsection
