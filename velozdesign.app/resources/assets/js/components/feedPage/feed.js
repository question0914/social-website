/**
 * Created by zijianli on 7/27/17.
 */
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import ImagesUploader from 'react-images-uploader';
import 'react-images-uploader/styles.css';
import 'react-images-uploader/font.css';

var Feed = React.createClass({
    handlePost:function(event){
        console.log("1234");
        var content = document.getElementById("content").value;
        axios({
            url:'/api/feed/post',
            method:'post',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                'content': content,
            }

        })
        .then(res=>{
          console.log('xxxxxxxxx');
            console.log(res);
        })
        .catch(err=>{
            console.log(err);
        })
    },
    handleImage:function(event){

    },
    render: function(){
        return(
            <div className="container-fluid">
                <div className="col-xs-12 col-sm-3 col-md-3 col-lg-3">

                </div>
                <div className="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div className="row">
                        <div className="panel panel-default">
                            <div className="panel-body">
                                <ImagesUploader
                                    url="https://s3.amazonaws.com/uploads.customtobacco.com"
                                    optimisticPreviews
                                    onLoadEnd={(err) => {
                                        if (err) {
                                            console.error(err);
                                        }
                                    }}
                                    label="Upload a image"
                                />
                                <textarea rows="5" id="content" type="text" className="form-control" placeholder="Description of Image" style={{border: 0, width: "100%"}}></textarea>
                            </div>
                            <div className="panel-footer">
                                <button className="btn btn-default"><span className="glyphicon glyphicon-edit"></span> Write an article!!!!</button>
                                <button className="btn btn-default" onClick={this.handleImage}>Photo/Video</button>
                                <button className="btn btn-primary pull-right" onClick={this.handlePost}>Post</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        )
    }
});

ReactDOM.render(<Feed/>, document.getElementById('feed'));
