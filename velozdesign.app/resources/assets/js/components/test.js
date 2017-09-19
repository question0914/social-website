import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {Button,Modal,Form,FormGroup,
  Col,CheckBox,FormControl,ControlLabel,InputGroup} from 'react-bootstrap';
// import Popup from 'react-popup';
// import Modal from 'react-modal';


// var Upload = React.createClass({
//     handleClick: function(event){
//         $.ajax({
//             url: '/uploadPhoto',
//             type: 'get',
//             success: function(resp) {
//                 //alert(resp);
//                 document.getElementById('uploadPhoto').innerHTML = resp;
//
//                 $("#upload").modal('show');
//                 var $imageupload = $('.imageupload');
//                 $imageupload.imageupload();
//
//             }
//         });
//     },
//     render:function(){
//         return(
//             <div>
//                 <button className="btn btn-primary followBtn btn-lg btn-block" onClick={this.handleClick}>Upload Image</button>
//             </div>
//         )
//     }
// });



var Proftxt = React.createClass({
getInitialState(){
  return {
    text:this.props.data,
    flag: true}
},
handleEdit:function(event){
  this.setState({flag:false});
},
handleSave:function(event){
  this.setState({flag:true});
  var arr = document.URL.split('/');
  var last = arr[arr.length-1];
  var id = last.trim('#');
  console.log("=====================");
  id = id.split('-');
  id = id[id.length-1];


  // var id="596400d99a89200652418912";
  var aj = $.ajax({
			type: "POST",
			headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	},
			// contentType: "application/json",
			url: "/api/profile/update_profile_name",
			//"update_profile_name http://velozdesign.app/overview"
			data:{new_name:this.state.text},
			success: function(res) {
          alert('Name changed successfully!');
          console.log(res);
					//console.log(res);
					// console.log(res._id);
					//console.log(res.name);
					//const userdata = res.children.map(obj => obj.data);
					//console.log(userdata);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log('sth wrong'+ XMLHttpRequest);
			}
	});
  // axios.get('../api/get_user_data')
  //   .then(res => {
  //     console.log('sth');

  //   });
},
handleChange:function(event){
  this.setState({text: event.target.value})
},
handleKeyPress:function(event){
  if(event.key == 'Enter'){
    this.handleSave();
  }
},
handleClear:function(event){
  this.setState({text:''});
  if (this.refs.myinput !== null) {
      this.refs.myinput.focus();
  }
},
render:function(){
    var inputstyle= {color:"black",fontFamily:"serif", fontSize:this.props.fsize};
    if(this.state.flag)
    return (
      <span className="myedit">
        <a href="#" className={this.props.classnm} onClick={this.handleEdit}/*className="profile-full-name" href="#" onMouseOver={this.handleMouseOver} onMouseOut={this.handleMouseOut}*/>
        {this.state.text}&nbsp;&nbsp;
        </a>
      <button className="btn btn-primary btn-md edtbtn" style={{display:'inline'}} onClick={this.handleEdit}>
      <span className="glyphicon glyphicon-edit"></span>
      </button>
      </span>
  )
  else{
    return(
    <div >
    <input style={inputstyle} ref="myinput" className="form-control" value={this.state.text} onChange={this.handleChange} onKeyPress={this.handleKeyPress}/>
    </div>)
  }
}

});

//tab nav
var MyTab = React.createClass({
  // getInitialState(){
  //   this.state={
  //     current:0
  //   }
  // },

  handleClick:function(event){
    var tab = event.target.getAttribute("data-index")
    var route = "/"+ tab;
    console.log('route is ' + route);

    var arr = document.URL.split('/');
    var last = arr[arr.length-1];
    var id = last.trim('#');

    id = id.split('-');
    id = id[id.length-1];
    // console.log("==="+id);
    // var id="596907999a892006526af752";
    var aj = $.ajax({
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        // contentType: "application/json",
        url: "/api/get_user_data",
        //"update_profile_name http://velozdesign.app/overview"
        data:{url_id : id,route: route},
        success: function(res) {
            ReactDOM.render(<Projects tab={tab} id={res._id} name={res.name}
              gender={res.gender} email={res.email} />,document.getElementById('mhome'));

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
var Projects = React.createClass({
  getInitialState() {
    return { cur:true};
  },
  handleClick(event){
    this.setState({cur:false});
  },
  back(event){
    this.setState({cur:true});
  },
  render(){
    var img_wd_style ={background:"url('../img/test.jpg') top center no-repeat",
    width:'100%',height:'100%',
    textAlign:'center',
		/*color: '#ff3300',*/
		fontSize:'28px',
    fontWeight:'bold'};
    if(this.state.cur)
    {
      return (
        <div id="projects" style={{wordBreak:'break-all',padding:0, margin:0}}>

      <div style={{padding:0}}>

        <div>{this.props.tab}</div>

        <div >{this.props.id}</div>
        <div >{this.props.name}</div>
        <div >{this.props.gender}</div>
        <div >{this.props.email}</div>
      </div>

      <div className = "col-md-12 col-sm-12" style={{padding:0}}>

          <div className = "row">

            <div className = "col-md-4 col-sm-4" >
                <div style={img_wd_style}  onClick={this.handleClick}>

                <p style={{paddingTop:'99%'}}>test</p>
                </div>
            </div>
            <div className = "col-md-4 col-sm-4" >
                <div style={img_wd_style}  onClick={this.handleClick}>
                  <p style={{paddingTop:'99%'}}>test</p>
                </div>
            </div>
            <div className = "col-md-4 col-sm-4" >
                <div style={img_wd_style}  onClick={this.handleClick}>
                  <p style={{paddingTop:'99%'}}>test</p>
                </div>
            </div>



          </div>
          <div className="row">
          <div className="col-md-4 col-sm-4">
            <a href="">
            <img style={{width:'100%'}} src="https://www.timeshighereducation.com/sites/default/files/byline_photos/default-avatar.png" />
              <p>sth</p>
            </a>
          </div>
          <div className="col-md-4 col-sm-4">
            <a href="">
            <img style={{width:'100%'}} src="https://www.timeshighereducation.com/sites/default/files/byline_photos/default-avatar.png" />
              <p>sth</p>
            </a>
          </div>
          <div className="col-md-4 col-sm-4">
            <a href="">
            <img style={{width:'100%'}} src="https://www.timeshighereducation.com/sites/default/files/byline_photos/default-avatar.png" />
              <p>sth</p>
            </a>
          </div>
          </div>


    </div>
  </div>
    );

  }

  else{
    return (<div>Hello, this is specific project page!
      <button onClick={this.back}>back</button><br/>
      <video  src="../img/imageUpload.mp4" width="500" height="400" controls >
          your browser does not support HTML5 video tag
      </video>

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
        <div id="imageUpload">asd</div>

      </div>
      {/*<div id="uploadPhoto"></div>*/}
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

const Edit = React.createClass({
  getInitialState() {
    return {
      showModal: false,
      new_contact:this.props.contact,
      new_location:this.props.location,
      new_job_cost_lo:this.props.job_cost_lo,
      new_job_cost_hi:this.props.job_cost_hi
    };
  },

  close() {
    this.setState({ showModal: false });
  },

  open() {
    this.setState({ showModal: true });
  },
  saveChange(event){
    event.preventDefault();

    var new_cost_lo = this.cost_low.value?this.cost_low.value:this.props.job_cost_lo;
    var new_cost_hi = this.cost_high.value?this.cost_high.value:this.props.job_cost_hi;
    var new_cost = "$"+new_cost_lo + " - $" + new_cost_hi;
    console.log(new_cost);
    var new_name= this.contact.value?this.contact.value:this.props.contact;
    var new_location = this.location.value?this.location.value:this.props.location;
    var aj = $.ajax({
  			type: "POST",
  			headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      	},
  			// contentType: "application/json",
  			url: "/api/profile/update_profile_name",
  			//"update_profile_name http://velozdesign.app/overview"
  			data:{
          new_name:new_name,
          new_location:new_location,
          new_job_cost:new_cost
        },
  			success: function(res) {
            console.log('Info changed successfully!');
  			},
  			error: function(XMLHttpRequest, textStatus, errorThrown){
  				console.log('There is sth wrong'+ XMLHttpRequest);
  			}
  	});
    // if(flag==true) {
    this.setState({new_contact:new_name,
      new_location:new_location,
      new_job_cost_lo:new_cost_lo,
      new_job_cost_hi:new_cost_hi
    });
    // }
    this.close();
  },
  render() {
    var titleSty = {textAlign: "center",margin:10,padding:10,fontSize:15, textDecoration:'none'};
    return (
      <div className="edt" style={{textDecoration:'none'}}>
        <a id="edittitle" style={titleSty} onClick={this.open}>{this.props.data}
        </a>
        <button  className="btn btn-primary btn-xs" style={{display:'inline'}} id="editbutton" onClick={this.open}>
        <span className="glyphicon glyphicon-edit"></span>
        </button>

        <div className="info-list-label">
          <i className="hzi-font hzi-Man-Outline"></i>
          <div className="info-list-text edtContact"><b>Contact </b><span>{this.state.new_contact}</span></div>
        </div>

        <div className="info-list-label">
          <i className="hzi-font hzi-Location"></i>
          <div className="info-list-text">
            <b>Location</b>
            <span >{this.state.new_location}</span>
          </div>
        </div>

        <div className="info-list-label">
          <i className="hzi-font hzi-Cost-Estimate"></i>
          <div className="info-list-text">
            <b>Typical Job Costs </b><span>${this.state.new_job_cost_lo} - ${this.state.new_job_cost_hi}</span>
          </div>
        </div>
        <Modal show={this.state.showModal} onHide={this.close}>
          <Modal.Header closeButton>
            <Modal.Title>Interior Designers & Decorators</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            <h4>Change your contact info</h4>
            <Form horizontal onSubmit={this.saveChange}>
              <FormGroup controlId="formHorizontalContact">
                <Col componentClass={ControlLabel} sm={3}>
                  Contact
                </Col>
                <Col sm={9}>
                  <FormControl type="contact" placeholder="Contact" inputRef={(ref) => { this.contact = ref}} />
                </Col>
              </FormGroup>


              <FormGroup controlId="formHorizontalLocation">
                <Col componentClass={ControlLabel} sm={3}>
                  Location
                </Col>
                <Col sm={9}>
                  <FormControl type="location" placeholder="Los Angeles" inputRef={(ref) => { this.location = ref}} />
                </Col>
              </FormGroup>

              <FormGroup controlId="formHorizontalLocation">
                <Col componentClass={ControlLabel} sm={3}>
                  Typical Job Cost
                </Col>
                <Col sm={4}>
                  <InputGroup>
                    <InputGroup.Addon>$</InputGroup.Addon>
                    <FormControl type="text" inputRef={(ref) => { this.cost_low = ref}} />
                  </InputGroup>
                </Col>
                <Col componentClass={ControlLabel} sm={1}>
                  to
                </Col>
                <Col sm={4}>
                  <InputGroup>
                    <InputGroup.Addon>$</InputGroup.Addon>
                    <FormControl type="text" inputRef={(ref) => { this.cost_high = ref}} />
                  </InputGroup>
                </Col>
              </FormGroup>

              <FormGroup>
                <Col smOffset={3} sm={9}>
                  <Button type="submit">Save</Button>
                  <Button type="reset">Clear</Button>
                </Col>
              </FormGroup>

            </Form>

          </Modal.Body>
          <Modal.Footer>
            <Button onClick={this.close}>Close</Button>
          </Modal.Footer>
        </Modal>
      </div>
    );
  }
});
ReactDOM.render(<Follow />,document.getElementById('leftp'));
ReactDOM.render(<Edit data="Interior Designers & Decorators" contact="Lori Denis"
location="Los Angeles, CA, 90034" job_cost_lo='15,000' job_cost_hi='25,000'/>,
document.getElementById('Onetime'));

var name = document.getElementById('profile-t').innerHTML;
ReactDOM.render(
<Proftxt data={name} fsize={24} classnm={"h1"}/>,
document.getElementById('profile-t')
);

ReactDOM.render(<MyTab/>, document.getElementById('mytab'));

// ReactDOM.render(<Upload/>, document.getElementById('imageUpload'));

//ReactDOM.render(<Sample/>, document.getElementById('imageUpload'));


//ReactDOM.render(<MyModal />, document.getElementById('popupContainer'));
