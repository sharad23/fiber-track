
var color = angular.module('colors',[]);

color.factory('colordata', function($http) {

	return {
			getColors: function() { 

		   	                 return  $http.get("http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/color"); 
							 
		   	             },
						 
			getColor: function(id) { 
						console.log(id);
		   	                 return $http({
									method: 'GET',
									url: 'http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/color/'+id+'/edit',									
									
								});
		   	             },
			
			addColor: function addColor(data) { 
						console.log(data);													
							
							return	$http.post('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/color',data); 
								
		   	             },
			editColor: function editColor(data) { 
						console.log(data);														
							return	$http({
									method: 'PUT',
									url: "http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/color/"+data.id+"/edit",
									data: data,
									headers: {
									//'x-access-token':$cookieStore.get('token'),
									'Content-Type': 'application/x-www-form-urlencoded;'
									}
								});
						
		   	             },
			removeColor: function(id) { 

							 return $http.delete('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/color/'+id); 
		   	             },
		
       }


});


color.controller('ColorController', function ($scope,$rootScope,$location,colordata) {


				colordata.getColors().success(function(data) {									
									
									$scope.colors = data;
									$rootScope.colors=$scope.colors;									
									
									console.log($scope.colors);
									
									$scope.sort = function(keyname){
										$scope.sortKey = keyname;   //set the sortKey to the param passed
										$scope.reverse = !$scope.reverse; //if true make it false and vice versa
									};
									
									$scope.currentPage = 1; //current page
									$scope.maxSize =2; //pagination max size
									$scope.entryLimit = 5; //max rows for data table
									
									$scope.noOfPages = Math.ceil($scope.colors.length/$scope.entryLimit);
									$scope.setPage = function(pageNo) {
										$scope.currentPage = pageNo;
									};
									
									
									$scope.filter = function() {
										$timeout(function() { //wait for 'filtered' to be changed
											$scope.noOfPages = Math.ceil($scope.filtered.length/$scope.entryLimit);
										}, 10);
									};
									
						});
						
						
						
					$scope.newColor = {};
					 
					$scope.addcolor = function () {
					
						
						 var dataObject = $scope.newColor;
						
						colordata.addColor(dataObject).success(ColorAddSuccess).error(ColorAddError);
						
					
					};
								
					
					function ColorAddSuccess(data) {
					console.log(data);
					$scope.error = null;
					$scope.colors.push(data);					
					console.log($scope.colors);
					$scope.newColor = {};
					 $location.path('/colors');

					}
				 
					function ColorAddError(data) {
					
					$scope.error = "Unable to add Color";
						
					}
					
					
					 $scope.removecolor = function(id) {
   
								if (confirm('Do you really want to remove this user?')) {
										
										colordata.removeColor(id).success(function (data) {
																		
																		 for (i in $scope.colors) {
																				if ($scope.colors[i].id == id) {
																					$scope.colors.splice(i, 1);
																				}
																			}
																			
																	  });
								
								}
							}
    
});


app.controller('ColorEditController', function ($scope,$filter,$rootScope,$routeParams,$location,colordata) {

		console.log($rootScope.colors);

			var color_id=$routeParams.id;
			 console.log(color_id);
			$scope.colordata = $filter('getById')($rootScope.colors,color_id);
			
					 console.log($scope.colordata);
					$scope.updatecolor = function () {
					
						console.log($scope.colordata);
						
						var dataObject = {id :$routeParams.id,name: $scope.colordata.name,hexcode: $scope.colordata.hexcode};
						
						colordata.editColor(dataObject).success(ColorEditSuccess).error(ColorEditError);
						
					};
					
					
					function ColorEditSuccess(data) {
					
					console.log(data);

					}
				 
					function ColorEditError(data) {
					console.log(data);
					
					$scope.error = "Unable to edit User";
						
					}
					
				
});


app.controller('ColorDetailController', function ($scope,$routeParams,colordata) {
			
			var color_id=$routeParams.id;
			
					colordata.getColor(color_id).success(ColorDetailSuccess).error(ColorDetailError);
					
					function ColorDetailSuccess(data) {
					$scope.viewcolor = data;
					}
				 
					function ColorDetailError(data) {
					
					$scope.error = "Unable to show user details.";
						
					}
					
				
});


app.filter('getById', function() {
  return function(input,id) {
    var i=0, len=input.length;
    for (; i<len; i++) {
	
      if (input[i].id == id) {
        return input[i];
      }
    }
    return null;
  }
});







