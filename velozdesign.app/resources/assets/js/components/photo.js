import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {Button,Modal,Form,FormGroup,
  Col,CheckBox,FormControl,ControlLabel,InputGroup} from 'react-bootstrap';
import Dropzone from 'react-dropzone';
import axios from 'axios';
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';
import 'react-tabs/style/react-tabs.css';

var Profimg = React.createClass(
{
getInitialState(){
  return {
    imgSrc:this.props.imgSrc
  }
},
handleClick(event){
  // alert('xx');
  this.modall.setState({showModal:true});
},
transferMsg(newimg) {
  this.setState({
    imgSrc:newimg
  });
},
render(){
  if(this.props.canEdit){
    return (
      <div onClick={this.handleClick}>
        <a className="profile-pic-border" href="#">
          <img id="prof-img" className="profile-pic" width="173" height="173" src={this.state.imgSrc} />
          <div className="edit-prof-photo" id="changePhoto">change your photo</div>
        </a>
        <ChangePhoto ref={(c) => { this.modall = c}} imgSrc={this.props.imgSrc} authid={this.props.authid} callbackP={this.transferMsg} />
      </div>
    )
  }
  else{
    return (
      <div>
        <a className="profile-pic-border" href="#">
          <img id="prof-img" className="profile-pic" width="173" height="173" src={this.state.imgSrc} />
        </a>
      </div>
    )
  }
  }
});

var ChangePhoto = React.createClass({
  getInitialState(){

    return{
      showModal:false,
      imgSrc:this.props.imgSrc,
      image:{}
    };

  },
  submitUrl(event){

    const url = this.imgUrl.value;
    const uploaded = url;
    console.log('id:'+this.props.authid);
    axios({
      url: '/api/profile/update_avatar_image',
      method:'post',
      headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'upload_url':url,
        'designer_id':this.props.authid
      }
    })
    .then(res=>{
      console.log(res);
      if(res)
      {
        alert('successfully upload image by url!');
        this.setState({image:uploaded, imgSrc:uploaded});
      }
    })
    .catch(err=>{
      console.log(err);
    })
    //let updatedImage = Object.assign({},this.state.image)
    //updatedImage.push(uploaded)
    // this.setState({image:uploaded, imgSrc:uploaded})
  },
  submitFile(files){
    const image = files[0];
    console.log('upload file');
    this.setState({image:image});
    var formData = new FormData();
    formData.append('upload_file', image);
    formData.append('designer_id',this.props.authid);
    axios({
      url:'/api/profile/update_avatar_image',
      method:'post',
      headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData
    })
    .then(res=>{
      console.log(res);
      if(res)
      {
        // const uploaded = res.data;
         this.setState({imgSrc:res.data});
      }

      // let updatedImages = Object.assign([],this.state.images)
      // updatedImages.push(uploaded)

    })
    .catch(err=>{
      console.log(err);
    })
  },
  uploadFile(){
    // this.setState({imgSrc: newimg});
    this.props.callbackP(this.state.imgSrc);
    // const image = files[0];
    // console.log('upload file');
    // const uploaded = res.data;
    // let updatedImages = Object.assign([],this.state.images)
    // updatedImages.push(uploaded)
    // this.setState({images:updatedImages})
    // var formData = new FormData();
    // formData.append('upload_file', image);
    // var mparams = {
    //   headers: {
    //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //   },
    //   data: formData
    // };
    // axios({
    //   url:'/uploadTest',
    //   method:'post',
    //   headers:{
    //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //   },
    //   data: formData
    // })
    // .then(res=>{
    //   console.log(res);
    //   const uploaded = res.data;
    //   let updatedImages = Object.assign([],this.state.images)
    //   updatedImages.push(uploaded)
    //   this.setState({images:updatedImages})
    // })
    // .catch(err=>{
    //   console.log(err);
    // })

  },
  uploadByUrl(){


  },
  removeImage(event){
    // let updatedImages = Object.assign([],this.state.images)
    // updatedImages.splice(event.target.id,1)
    this.setState({image:{}})
  },
  transferMsg(newimg) {
    this.setState({
      imgSrc:newimg
    });
  },
  open(){
    this.setState({showModal:true});
  },
  close(){
    this.setState({showModal:false});
  },
  render() {
    //if authorized to change photo (designer role)
    // if(this.props.auth)
    // {style={{display:'inline-block'}}
    const dropzoneStyle = {
    width  : "100%",
    height : 160,
    border : "2px dashed black",
    borderRadius:5
    };

    var isEmptyO = Object.prototype.isPrototypeOf(this.state.image) && Object.keys(this.state.image).length === 0;
    const dropped = isEmptyO?null:
    (
      <div style={{display:'inline-block'}}>
          <p> {this.state.image.name}</p>
      </div>
    );

    const toupload = this.state.imgSrc != this.props.imgSrc && this.state.imgSrc!="" ?
    (
      <div>
      <hr />
      <div style={{backgroundColor:'lightblue',borderRadius:7,height:120}}>
        <div style={{float:'left',width:'20%',height:120,textAlign:'center'}}>
          <p style={{marginTop:55}}>to be uploaded</p>
        </div>
        <div style={{float:'left',border:"2px dashed green",borderRadius:7,backgroundColor:'white',width:'60%',height:120,textAlign:'center'}}>
          <img src={this.state.imgSrc} style={{display:'inline-block',height:'100%'}} />
        </div>
        <div style={{textAlign:'center',float:'left',width:'20%',height:120}}>
        <Button onClick={this.uploadFile} style={{height:30,marginTop:45}}>upload</Button>
        </div>
      </div>
      </div>
    ):null;
      return (
        <Modal show={this.state.showModal} onHide={this.close}>
          <Modal.Header closeButton>
            <Modal.Title>upload photo</Modal.Title>
          </Modal.Header>
          <Modal.Body>
          <Tabs>
            <TabList >
              <span style={{fontSize:20,marginRight:30}}>select a way to upload your photo</span>
              <Tab>File</Tab>
              <Tab>URL</Tab>

            </TabList>

            <TabPanel>
              <div style={{display:'flex'}}>
                <div>
                  <Dropzone multiple={false} accept="image/*" onDrop={this.submitFile} style={dropzoneStyle}>
                    <div style={{textAlign:'center'}}>Drop an image or click to select a file to upload.<br/>
                      Only one image allowed
                    </div>
                  </Dropzone>
                </div>
                <div style={{width:'100%',textAlign:'center'}}>
                  <div style={{fontSize:18,fontWeight:'bold',paddingBottom:5}}>Dropped file</div>
                  {dropped}
                </div>
              </div>

            </TabPanel>
            <TabPanel>
              <div className="input-group">
                  <input ref={(e)=>this.imgUrl=e} type="text" className="form-control hasclear" placeholder="Image URL"></input>
                      <div className="input-group-btn">
                          <button type="button" className="btn btn-default" onClick={this.submitUrl}>Submit</button>
                      </div>
              </div>
            </TabPanel>
          </Tabs>
          <div>{toupload}</div>
          </Modal.Body>
          <Modal.Footer>
            <Button onClick={this.close}>Close</Button>
          </Modal.Footer>
        </Modal>


      );
    // }<Child_1 imgSrc={this.props.imgSrc} callbackP={this.transferMsg} />
    // else{
      // return (
        // <div>cannot change photo</div>
      // );
    // }
  }
});

var Cover = React.createClass({
  getInitialState(){
    return {
      imgSrc:this.props.imgSrc,
    }
  },
  handleClick(event){
    this.modal.setState({showModal:true});
  },
  transferMsg(newimg) {
    this.setState({
      imgSrc:newimg
    });
  },
  render(){
    if(this.props.canEdit)
    {
      return (
        <div className="mycover" onClick={this.handleClick}>
          <img id="coverImage" className="cover-image custom-cover offset-cover" src={this.state.imgSrc} />
          <div className="edt-cover" id="changeCover">change your cover</div>
          <ChangePhoto ref={(e)=>this.modal=e} imgSrc={this.props.imgSrc} callbackP={this.transferMsg} />
        </div>
      )
    }
    else
    {
      return (
        <div className="mycover" >
          <img id="coverImage" className="cover-image custom-cover offset-cover" src={this.state.imgSrc} />
        </div>
      )
    }
  }
});
//{{$user_profile_data['profile_img']['cover'][0]}}

// global.ChangePhoto = ChangePhoto;
global.Profimg = Profimg;// global.navigator= window.navigator;
global.Cover = Cover;
//{{$user_profile_data['profile_img']['cover'][0]}}
