import React from "react";

export class Home extends React.Component {
	constructor(props) {
		super();
		//this.handleChange = this.handleChange.bind(this);
		this.state = {
			age: 	props.initialAge,
			status : 0,
			homeLink: props.initialLinkName
		};
		setTimeout(() => {
			this.setState({
				status: 1
			});
		},3000);
		
	}
	
	onMakeOlder() {
		this.setState({
			age: this.state.age + 3

		});
	}

	onChangeLink() {
		this.props.changeLink(this.state.homeLink);
	}
	handleChange(e) {
		this.setState({homeLink: e.target.value});
	}
	render() {
		return (
			<div>
				<p>In a new Component!</p>
				<p>Your name is {this.props.name} , your age is {this.state.age}</p>
				<p>Status: {this.state.status}</p>
				<hr/>
				<button onClick={() => this.onMakeOlder()} className="btn btn-primary btn-sm">Make me older!</button>
				<button onClick={this.props.greet} className="btn btn-primary btn-sm">Greet</button>
				<hr/>
				<input type="text" value={this.state.homeLink} 
					onChange={(e) => this.handleChange(e)} />   
				<button onClick={this.onChangeLink.bind(this)} className="btn btn-primary btn-sm">Change Header Link</button>
	
			</div>
		);
	}
}

Home.proptypes ={
	name: React.PropTypes.string,
	initialAge: React.PropTypes.number,
	greet: React.PropTypes.func,
	initialLinkName: React.PropTypes.string
};