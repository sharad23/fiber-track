
var location = angular.module('locations',[]);

color.factory('locationdata', function($http) {

	return {
			getLocations: function() { 

		   	                 return  $http.get("http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/locations"); 
							 
		   	             },
			getLocation: function(id) { 
						console.log(id);
		   	                 return $http({
									method: 'GET',
									url: 'http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/location/'+id+'/edit',									
									
								});
		   	             },
			
			addLocation: function addLocation(data) { 
						console.log(data);													
							
							return	$http.post('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/location',data); 
								
		   	             },
			editLocation: function editLocation(data) { 
						console.log(data);														
							return	$http({
									method: 'PUT',
									url: "http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/location/"+data.id+"/edit",
									data: data,
									headers: {
									//'x-access-token':$cookieStore.get('token'),
									'Content-Type': 'application/x-www-form-urlencoded;'
									}
								});
						
		   	             },
			removeLocation: function(id) { 

							 return $http.delete('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/location/'+id); 
		   	             },
		
       }


});


color.controller('LocationController', function ($scope,$rootScope,$location,locationdata) {


				locationdata.getLocations().success(function(data) {									
									
									$scope.locations = data;									
									
									console.log($scope.locations);
									
									$scope.sort = function(keyname){
										$scope.sortKey = keyname;   //set the sortKey to the param passed
										$scope.reverse = !$scope.reverse; //if true make it false and vice versa
									};
									
									$scope.currentPage = 1; //current page
									$scope.maxSize =2; //pagination max size
									$scope.entryLimit = 5; //max rows for data table
									
									$scope.noOfPages = Math.ceil($scope.locations.length/$scope.entryLimit);
									$scope.setPage = function(pageNo) {
										$scope.currentPage = pageNo;
									};
									
									
									$scope.filter = function() {
										$timeout(function() { //wait for 'filtered' to be changed
											$scope.noOfPages = Math.ceil($scope.filtered.length/$scope.entryLimit);
										}, 10);
									};
									
						});
						
					
					$scope.newLocation = {};
					 
					$scope.addlocation = function () {
					
						
						 var dataObject = $scope.newLocation;
						
						locationdata.addColor(dataObject).success(LocationAddSuccess).error(LocationAddError);
						
					
					};
								
					
					function LocationAddSuccess(data) {
					console.log(data);
					$scope.error = null;
					$scope.locations.push(data);					
					console.log($scope.locations);
					$scope.newLocation = {};
					 $location.path('/locations');

					}
				 
					function LocationAddError(data) {
					
					$scope.error = "Unable to add user";
						
					}
					
					
					 $scope.removelocation = function(id) {
   
								if (confirm('Do you really want to remove this user?')) {
										
										colordata.removeLocation(id).success(function (data) {
																		
																		 for (i in $scope.locations) {
																				if ($scope.locations[i].id == id) {
																					$scope.locations.splice(i, 1);
																				}
																			}
																			
																	  });
								
								}
							}
    
});


app.controller('LocationEditController', function ($scope,$filter,$rootScope,$routeParams,$location,locationdata) {

		console.log($rootScope.locations);

			var location_id=$routeParams.id;
			 console.log(location_id);
			$scope.locationdata = $filter('getById')($rootScope.locations,location_id);
			
					 console.log($scope.locationdata);
					$scope.updatelocation = function () {
					
						console.log($scope.locationdata);
						
						var dataObject = {id :$routeParams.id,name: $scope.locationdata.name};
						
						locationdata.editLocation(dataObject).success(LocationEditSuccess).error(LocationEditError);
						
					};
					
					
					function LocationEditSuccess(data) {
					
					console.log(data);

					}
				 
					function LocationEditError(data) {
					console.log(data);
					
					$scope.error = "Unable to edit Location";
						
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









