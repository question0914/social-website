//alert('sth');
// import React, { Component } from 'react';
// import ReactDOM from 'react-dom';
// class FetchDem extends React.Component {
//
//   constructor(props) {
//
//     super(props);
//
//     this.state = {
//
//       posts: [],
//     };
//
//   }
//
//   componentDidMount() {
//
//     axios.get(`http://www.reddit.com/r/${this.props.subreddit}.json`)
//       .then(res => {
//
//         const posts = res.data.data.children.map(obj => obj.data);
//
//         console.log(posts);
//         this.setState({ posts });
//
//       });
//
//   }
//
//   render() {
// 		var listStyle= {
// 			margin:0, padding:0, /*backgroundColor:"lightblue",*/
// 			fontSize: "24",fontFamily:"serif",
//
// 			lineHeight:"100%"
// 		};
//     return (
//       //var value = this.props.subreddit;
//       <div>
//
//         <h1>{`route: /r/${this.props.subreddit}`}</h1>
//         <ul >
//           {this.state.posts.map(post =>
//             <li style={listStyle} key={post.id} >{post.title}</li>
//           )}
//         </ul>
//       </div>
//     );
//   }
// }
// export default ajaxtest;
// ReactDOM.render(
//     <FetchDem subreddit="reactjs"/>,
//     document.getElementById('myhome')
//   );
