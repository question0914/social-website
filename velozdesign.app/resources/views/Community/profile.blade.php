@extends('layouts.app')
@section('content')

<script type="text/babel">
	var authid = "{{isset($auth_id)?$auth_id:''}}";

	// console.log("my id: "+authid);
	var arr = document.URL.split('/');
	var last = arr[arr.length-1];
	var id = last;
	if(id.lastIndexOf('#')!=-1)
		id = id.substring(0,id.length-1);
	if(id.lastIndexOf('?')!=-1)
		id = id.substring(0,id.length-1);
	id = id.split('-');
	id = id[id.length-1];
	var canedit = id == authid?true:false;
	// console.log(canedit);
	ReactDOM.render(<Profimg imgSrc="{{$user_profile_data['profile_img']['avatar'][0]}}" canEdit={canedit} authid={authid} />,document.getElementById('prof-img-ctn'));
	ReactDOM.render(<Cover imgSrc="{{$user_profile_data['profile_img']['cover'][0]}}" canEdit={canedit} />,document.getElementById('prof-cover-ctn'));
	ReactDOM.render(<Edit data="Interior Designers & Decorators" contact="Lori Denis"
	location="Los Angeles, CA, 90034" job_cost_lo='15,000' job_cost_hi='25,000' canEdit={canedit}/>,document.getElementById('Onetime'));
	ReactDOM.render(<Proftxt text="{{$user_profile_data['name']}}" fsize={24} classnm={"h1"} canEdit={canedit} />,document.getElementById('profile-t'));
	// ReactDOM.render(<Message name={name} />,document.getElementById('testmsg'));
</script>

<div class="container profile-carded">
	<div class="container">
		<div class="profile-header view">
			<div id="prof-img-ctn" class="profile-pic-container">
			</div>


			<div class="profile-cover">
				<div id="prof-cover-ctn"></div>
						<div class="profile-info">
							<div class="profile-title">
								<div id="profile-t"></div>
								<!-- <span style="display:none" id="hid"></span> -->
								<canvas width="100" height="15" id="myCanvas"></canvas>
								<div  id="revieww"></div>
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
							<div id="Onetime">
														</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
