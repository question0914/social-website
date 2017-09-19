import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import { Header } from "./Header";
import { Home } from "./Home";

class Hello extends React.Component {

	constructor() {
		super();
		this.state = {
			homeLink: "Home",
			homeMounted: true
		};
	}

	onGreet() {
		alert("Hello!");
	}

	onChangeLinkName(newName) {
		this.setState({
			homeLink: newName
		});

	}

	onChangeHomeMounted() {
		this.setState({
			homeMounted: !this.state.homeMounted
		});
	}
	render() {
		let homeCmp = "";
		if (this.state.homeMounted) {
			homeCmp = (
				<Home 
					name={"Hoa"} 
					initialAge={20} 
					greet={this.onGreet} 
					changeLink={this.onChangeLinkName.bind(this)}
					initialLinkName={this.state.homeLink}
				/>
			);
		}
		return (
			<div>
				<div className="row">
					<Header homeLink={this.state.homeLink}/>	
				</div>
				<div className="row">
					{homeCmp}
				</div>
				<div className="row">
					<button onClick={this.onChangeHomeMounted.bind(this)} className="btn btn-primary btn-sm">(Un)Mount Home Component</button>
				</div>
			</div>
		);
	}
}

if(document.getElementById('feed'))
    ReactDOM.render(<Feed/>, document.getElementById('feed'));
