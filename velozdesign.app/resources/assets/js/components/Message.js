import React, { Component } from 'react';
import ReactDOM from 'react-dom';
var Message = React.createClass({
  render(){
    return (
      <p>{this.props.name}</p>
    )
  }
});
export default Message;

global.Message = Message;
