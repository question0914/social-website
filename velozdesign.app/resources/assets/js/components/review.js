import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
var Review = React.createClass({
  getInitialState(){
    return {
      num_review: 0,
      avg_rate: 0};
  },
  componentDidMount() {
    console.log('review part');
    var arr = document.URL.split('/');
    var last = arr[arr.length-1];
    var id = last;
    if(id.lastIndexOf('#')!=-1)
      id = id.substring(0,id.length-1);
    if(id.lastIndexOf('?')!=-1)
      id = id.substring(0,id.length-1);
    id = id.split('-');
    id = id[id.length-1];
    console.log(id);
    axios({
      url:'/api/user/review/check_exist_review',
      method:'post',
      headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data:{'reviewer_id':id}
    })
    .then(res=>{
      var exist = res.data;
      console.log(res.data);
      // if(exist) this.setState({data:"review me"});
      // else
      // {
      axios({
          url:'/api/user/review/get_reviewing_review',
          method:'get'
      })
      .then(res=>{
        var review_data=res.data;
        var arr = review_data.reviews;
        console.log(review_data.reviews);
        // review_data = review_data.num_review>0?review_data.num_review+" reviews":review_data.num_review+" review";
        var rating = 0;
        // if(arr.length != 0)
        // {
          // for(revw in arr)
          // {
            // rating += revw;
          // }
          // rating = rating/arr.length;
          // 参数设置与函数调用

        // }
        this.setState({avg_rate:4.5,num_review:review_data.num_review});
        // if(review_data.num_review == 0)
      })
      .catch(err=>{
        console.log('get user review fail!');
      });
    })
    .catch(err=>{
      console.log(err);
    });

  },
  render(){

    return (

    <div>

      <div style={{display:'inline-block'}}>average rate: {this.state.avg_rate}&nbsp;&nbsp;
      <a href="#"style={{paddingLeft:10}}>{this.state.num_review} review
      </a>
      </div>
    </div>
    )
    // <div>
    //   <span class="sprite-profile-icons pi-pro-badge-green"></span>
    //   @if ($review_brief['num_rate'] > 0)
    //   <span itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
    //     <div class="pro-rating">
    //       <a class="review-star-link colorLink" compid="review" href="#">
    //         <span>
    //           <span class="glyphicon glyphicon-star-empty"></span>
    //           <span class="glyphicon glyphicon-star-empty"></span>
    //           <span class="glyphicon glyphicon-star-empty"></span>
    //           <span class="glyphicon glyphicon-star-empty"></span>
    //           <span class="glyphicon glyphicon-star-empty"></span>
    //         </span>
    //         {{$review_brief['average_rate']}}
    //         <span class="pro-review-string">
    //           <span itemprop="reviewCount">{{$review_brief['num_rate']}}</span> Reviews
    //         </span>
    //       </a>
    //       <meta itemprop="ratingValue" content="5">
    //     </div>
    //   </span>
    //   @endif
    //   @if ($show_review_btn)
    //     <a class="pro-review-string pro-review-btn">Review Me<span class="more-icon">></span></a>
    //   @endif
  }
});



if(document.getElementById('revieww'))
ReactDOM.render(<Review />,document.getElementById('revieww'));


function showRatingStars(myCanvas, rating, counts, size, style) {

            // 检测rating与star数目是否合适
            if (rating > counts) {

                alert("Please set suitable rating and counts!");
                return;
            }

            // 检测大小设置是否合适
            // if (myCanvas.offsetWidth < size * counts || myCanvas.offsetHeight < size) {
            //
            //     alert("Please set suitable size and myCanvas' size!");
            //     return;
            // }

            var context = myCanvas.getContext('2d');
            var xStart = rating * size;
            var yStart = 0;
            var xEnd = (Math.ceil(rating) + 1) * size;
            var yEnd = 0;
            var radius = size / 2;

            // 线性渐变，由左至右
            var linear = context.createLinearGradient(xStart, yStart, xEnd, yEnd);
            linear.addColorStop(0, style.fillColor);
            linear.addColorStop(0.01, style.spaceColor);
            linear.addColorStop(1, style.spaceColor);
            context.fillStyle = linear;

            // star边框颜色设置
            context.strokeStyle = style.borderColor;
            context.lineWidth = 1;

            // 绘制star的顶点坐标
            var x = radius,
                y = 0;

            for (var i = 0; i < counts; i++) {

                // star绘制
                context.beginPath();
                var x1 = size * Math.sin(Math.PI / 10);
                var h1 = size * Math.cos(Math.PI / 10);
                var x2 = radius;
                var h2 = radius * Math.tan(Math.PI / 5);
                context.lineTo(x + x1, y + h1);
                context.lineTo(x - radius, y + h2);
                context.lineTo(x + radius, y + h2);
                context.lineTo(x - x1, y + h1);
                context.lineTo(x - x1, y + h1);
                context.lineTo(x, y);
                context.closePath();
                context.stroke();
                context.fill();
                x = (i + 1.5) * size;
                y = 0;
                context.moveTo(x, y);
            }
}
var size = 15;
var rating = 4.5;
var counts = 5;
var style = {
    borderColor: "yellow",//"#21DEEF",
    fillColor: "yellow",//"#21DEEF",
    spaceColor: "#FFFFFF"
};
var myCanvas = document.getElementById("myCanvas");

showRatingStars(myCanvas, rating, counts, size, style);
