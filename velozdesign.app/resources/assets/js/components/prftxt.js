import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {Button,Modal,Form,FormGroup,
  Col,CheckBox,FormControl,ControlLabel,InputGroup} from 'react-bootstrap';
import axios from 'axios';

var Proftxt = React.createClass({
  getInitialState(){
    return {
      text:this.props.name,
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
    // console.log("=====================");
    id = id.split('-');
    id = id[id.length-1];
    // console.log(this.state.text);
    axios({
      url:'/api/profile/update_profile_name',
      method:'post',
      headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data:{new_name:this.state.text}
      // success: function(res) {
      //     console.log(res);
      //     console.log('Info changed successfully!');
      // },
      // error: function(XMLHttpRequest, textStatus, errorThrown){
      //   console.log('There is sth wrong'+ XMLHttpRequest);
      // }
    })
    .then(res=>{
      console.log(res);
      // const uploaded = res.data;
      // let updatedImages = Object.assign([],this.state.images)
      // updatedImages.push(uploaded)

    })
    .catch(err=>{
      console.log(err);
    })
    // var id="596400d99a89200652418912";
    // var aj = $.ajax({
  	// 		type: "POST",
  	// 		headers: {
    //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //   	},
  	// 		// contentType: "application/json",
  	// 		url: "/api/profile/update_profile_name",
  	// 		//"update_profile_name http://velozdesign.app/overview"
  	// 		data:{new_name:this.state.text},
  	// 		success: function(res) {
    //         // alert('Name changed successfully!');
    //         console.log(res);
  	// 				//console.log(res);
  	// 				// console.log(res._id);
  	// 				//console.log(res.name);
  	// 				//const userdata = res.children.map(obj => obj.data);
  	// 				//console.log(userdata);
  	// 		},
  	// 		error: function(XMLHttpRequest, textStatus, errorThrown){
  	// 			console.log('sth wrong'+ XMLHttpRequest);
  	// 		}
  	// });
    // axios.get('../api/get_user_data')
    //   .then(res => {
    //     console.log('sth');

    //   });
  },
  handleChange:function(event){
    // console.log(event.target.value);
    this.setState({text: event.target.value})
  },
  handleKeyPress:function(event){
    if(event.key == 'Enter'){
      this.handleSave();
    }
  },
  handleClear:function(event){
    //this.setState({text:''});
    //if (this.refs.myinput !== null) {
    //     this.refs.myinput.focus();
    //}
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
      <input style={inputstyle} className="form-control" value={this.state.text} onChange={this.handleChange} onKeyPress={this.handleKeyPress}/>
      </div>)
    }
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
    // event.preventDefault();

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
// export default Message;
// global.Edit = Edit;
// global.Proftxt = Proftxt;
