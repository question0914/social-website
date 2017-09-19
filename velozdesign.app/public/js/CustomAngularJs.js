var appA =  angular.module('VelozDesign',[]);

appA.controller('velozController', function($scope,$http){

	$scope.inputText = '';
	$scope.postContent = function(textdata)
	{
		var dataObj = {
			content : textdata
		};
		$http.post('/api/feed/post',dataObj).then(
			function(response){
				//$scope.inputText = response.data;
			},
			function(response){
				alert('Error');
			}
		);

	}

	$scope.make_review = function()
	{
		alert("Write Review");
	}
});
