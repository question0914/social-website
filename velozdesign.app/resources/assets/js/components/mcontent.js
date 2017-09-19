import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {Button,Modal,Form,FormGroup,
  Col,CheckBox,FormControl,ControlLabel,InputGroup} from 'react-bootstrap';
// import Popup from 'react-popup';
// import Modal from 'react-modal';


//tab control
var MyTab = React.createClass({
  handleClick:function(event){
    var route = "/project/show_user_project";
    var tab = event.target.getAttribute("data-index");
    var arr = document.URL.split('/');
    var last = arr[arr.length-1];
    var id = last;
    if(id.lastIndexOf('#')!=-1)
      id = id.substring(0,id.length-1);
    if(id.lastIndexOf('?')!=-1)
      id = id.substring(0,id.length-1);
    id = id.split('-');
    id = id[id.length-1];
    // var id="596907999a892006526af752";
    console.log(id);
    var aj = $.ajax({
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType:'JSON',
        // contentType: "application/json",
        url: "/project/show_user_project",
        //"update_profile_name http://velozdesign.app/overview"
        data:{designer_id : id},
        success: function(res) {
          if(document.getElementById('mhome'))
            ReactDOM.render(<Projects tab={tab} name={res[0].title}
              data={res} />, document.getElementById('mhome'));
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
          console.log('sth wrong'+ XMLHttpRequest);
        }
    });

  },
  render:function(){
    var bgstyle = {padding:0,margin:0};
    return(

       <div className="navbar-form">
        <ul className="nav navbar-nav nav-tabs" style={bgstyle}>
            <li id="tab1" className="active sidebar-item"><a href=""  data-index="overview" onClick={this.handleClick} data-toggle="tab">Overview</a></li>
            <li className="sidebar-item"><a href=""  data-index="projects" onClick={this.handleClick} data-toggle="tab">Projects</a></li>
            <li className="sidebar-item"><a href=""  data-index="review" onClick={this.handleClick} data-toggle="tab">Review</a></li>
            <li className="sidebar-item"><a href=""  data-index="activity" onClick={this.handleClick} data-toggle="tab">Activity</a></li>
        </ul>
      </div>
    )
  }
});

//Projects tab panel
var Projects = React.createClass({
  getInitialState() {
    return { cur:-1};
  },
  handleClick(event){
    console.log(event);
    var index = event.target.getAttribute("data-index");
    console.log("mykey: "+ index);
    this.setState({cur:index});
  },
  back(event){
    this.setState({cur:-1});
  },
  render(){
    var img_wd_style ={background:"url('../img/test.jpg') top center no-repeat",
    width:'100%',height:'100%',
    textAlign:'center',
		/*color: '#ff3300',*/
		fontSize:'28px',
    fontWeight:'bold'};

    if(this.state.cur == -1)
    {
      return (
              <div id="projects" style={{wordBreak:'break-all',padding:0, margin:0}}>

            <div style={{padding:0}}>
              <h4>{this.props.tab}</h4>
              <div >{this.props.name}</div>
              <hr />
            </div>

            <div className = "col-md-12 col-sm-12" style={{padding:0}}>

                <div className="row">
                  {this.props.data.map((proj,index)=>{
                    return (
                      <div className = "col-md-4 col-sm-4" key={proj._id}  onClick={this.handleClick}>
                        <div className="proj-photo" >
                          <img src={proj.images[0].link} alt="" data-index={index} style={{width:'100%',height:'100%'}}/>
                          <div className="save-email" data-index={index}>see details</div>
                          <div className="proj-title" data-index={index}>{proj.title}</div>
                        </div>
                      </div>
                    )
                  })}
                </div>

          </div>
        </div>
    );
  }

  else{
    var indx = this.state.cur;
    var pro = this.props.data[indx].title;
    return (<div>Hello, this is {pro}
      <br/>
      <video  src="../img/imageUpload.mp4" width="500" height="400" controls >
          your browser does not support HTML5 video tag
      </video>
      <br />
      <Button onClick={this.back}>back</Button>
      </div>);
  }
  }
});

const Follow = React.createClass({
  render(){
    return (
      <div>
      <div className="follow-section profile-l-sidebar">
        <a className="followers follow-box" href="#">
          <span className="follow-count">1232</span>Followers
        </a>
        <a className="following follow-box" href="#"><span className="follow-count">23423</span>Following</a>
      </div>

      <div className="follow-section profile-l-sidebar">
        <button className="btn btn-secondary followBtn btn-sm btn-block" id="followButton_loridennis" >Follow</button>
        <div id="imageUpload"></div>

      </div>
      <div id="uploadPhoto"></div>
      <div className="profile-l-sidebar clearfix" id="sociallinks">
        <a className="sprite-profile-icons f" href="#"><img className="f" src="https://st.hzcdn.com/res/2573/pic/spacer.gif?v=2573" title="Find me on Facebook" /></a>
        <a className="sprite-profile-icons t" href="#"><img className="t" src="https://st.hzcdn.com/res/2573/pic/spacer.gif?v=2573" title="Find me on Twitter" /></a>
        <a className="sprite-profile-icons g" href="#"><img className="g" src="https://st.hzcdn.com/res/2573/pic/spacer.gif?v=2573" title="Find me on Google+" /></a>
        <a className="sprite-profile-icons l" href="#"><img className="l" src="https://st.hzcdn.com/res/2573/pic/spacer.gif?v=2573" title="Find me on Linkedin" /></a>
        <a className="sprite-profile-icons b" href="#"><img className="b" src="https://st.hzcdn.com/res/2573/pic/spacer.gif?v=2573" title="Find me on my blog or other site" /></a>
      </div>
      </div>
    );
  }
});


// if(typeof window !== 'undefined') {
  if(document.getElementById('leftp'))
  ReactDOM.render(<Follow/>,document.getElementById('leftp'));
  if(document.getElementById('mytab'))
  ReactDOM.render(<MyTab/>, document.getElementById('mytab'));
// }

// ReactDOM.render(<Upload/>, document.getElementById('imageUpload'));

//ReactDOM.render(<MyModal />, document.getElementById('popupContainer'));
