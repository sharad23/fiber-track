
var fiber_connection = angular.module('fiber_connections',[]);


fiber_connection.config(function configure($routeProvider) {

	$routeProvider
				.when('/fiber_connections', 
		         	      { 
		         	      	controller: 'fiber_connectionController', 
		         	      	templateUrl: './packages/partial/fiber_connections/fiber_connection.html' 
		         	      }
		         	  )
				  
				.when('/fiber_connections/add', 
					  { 
						controller: 'fiber_connectionController', 
						templateUrl: './packages/partial/fiber_connections/fiber_connection_add.html' 
					  }
				  )
				  
				.when('/fiber_connections/:id', 
					  { 
						controller: 'fiber_connectionEditController', 
						templateUrl: './packages/partial/fiber_connections/fiber_connection_edit.html' 
					  }
				  )
				  
				.when('/fiber_connection_detail/:id', 
					  { 
						controller: 'fiber_connectionDetailController', 
						templateUrl: './packages/partial/fiber_connections/fiber_connection_detail.html' 
					  }
				  )
				
				
});




fiber_connection.factory('fiber_connectiondata', function($http) {

	return {
			getfiber_connections: function() { 

		   	                 return  $http.get("http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber-connection"); 
							 
		   	             },
						 
			getfiber_connection: function(id) { 
						console.log(id);
		   	                 return $http({
									method: 'GET',
									url: 'http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber-connection/'+id+'/edit',									
									
								});
		   	             },
			
			addfiber_connection: function addfiber_connection(data) { 
						console.log(data);													
							
							return	$http.post('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber-connection',data); 
								
		   	             },
			editfiber_connection: function editfiber_connection(data) { 
						console.log(data);														
							return	$http({
									method: 'PUT',
									url: "http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber-connection/"+data.id+"/edit",
									data: data,
									headers: {
									//'x-access-token':$cookieStore.get('token'),
									'Content-Type': 'application/x-www-form-urlencoded;'
									}
								});
						
		   	             },
			removefiber_connection: function(id) { 

							 return $http.delete('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber-connection/'+id); 
		   	             },
		
       }


});


fiber_connection.controller('fiber_connectionController', function ($scope,$rootScope,$location,fiber_connectiondata) {


				fiber_connectiondata.getfiber_connections().success(function(data) {									
									
									$scope.fiber_connections = data;
									
									$rootScope.fiber_connections=$scope.fiber_connections;									
									
									console.log($scope.fiber_connections);
									
									$scope.sort = function(keyname){
										$scope.sortKey = keyname;   //set the sortKey to the param passed
										$scope.reverse = !$scope.reverse; //if true make it false and vice versa
									};
									
									$scope.currentPage = 1; //current page
									$scope.maxSize =2; //pagination max size
									$scope.entryLimit = 5; //max rows for data table
									
									$scope.noOfPages = Math.ceil($scope.fiber_connections.length/$scope.entryLimit);
									$scope.setPage = function(pageNo) {
										$scope.currentPage = pageNo;
									};
									
									
									$scope.filter = function() {
										$timeout(function() { //wait for 'filtered' to be changed
											$scope.noOfPages = Math.ceil($scope.filtered.length/$scope.entryLimit);
										}, 10);
									};
									
						});
						
						
						
					$scope.newfiber_connection = {};
					 
					$scope.addfiber_connection = function () {
					
						
						 var dataObject = $scope.newfiber_connection;
						
						fiber_connectiondata.addfiber_connection(dataObject).success(fiber_connectionAddSuccess).error(fiber_connectionAddError);
						
					
					};
								
					
					function fiber_connectionAddSuccess(data) {
					console.log(data);
					$scope.error = null;
					$scope.fiber_connections.push(data);					
					console.log($scope.fiber_connections);
					$scope.newfiber_connection = {};
					 $location.path('/fiber_connections');

					}
				 
					function fiber_connectionAddError(data) {
					
					$scope.error = "Unable to add fiber_connection";
						
					}
					
					
					 $scope.removefiber_connection = function(id) {
   
								if (confirm('Do you really want to remove this fiber connection?')) {
										
										fiber_connectiondata.removefiber_connection(id).success(function (data) {
																		
																		 for (i in $scope.fiber_connections) {
																				if ($scope.fiber_connections[i].id == id) {
																					$scope.fiber_connections.splice(i, 1);
																				}
																			}
																			
																	  });
								
								}
							}
    
});


app.controller('fiber_connectionEditController', function ($scope,$filter,$rootScope,$routeParams,$location,fiber_connectiondata) {

		console.log($rootScope.fiber_connections);

			var fiber_connection_id=$routeParams.id;
			 console.log(fiber_connection_id);
			$scope.fiber_connectiondata = $filter('getById')($rootScope.fiber_connections,fiber_connection_id);
			
					 console.log($scope.fiber_connectiondata);
					$scope.updatefiber_connection = function () {
					
						console.log($scope.fiber_connectiondata);
						
						var dataObject = {id :$routeParams.id,name: $scope.fiber_connectiondata.name,hexcode: $scope.fiber_connectiondata.hexcode};
						
						fiber_connectiondata.editfiber_connection(dataObject).success(fiber_connectionEditSuccess).error(fiber_connectionEditError);
						
					};
					
					
					function fiber_connectionEditSuccess(data) {
					
					console.log(data);

					}
				 
					function fiber_connectionEditError(data) {
					console.log(data);
					
					$scope.error = "Unable to edit User";
						
					}
					
				
});


app.controller('fiber_connectionDetailController', function ($scope,$routeParams,fiber_connectiondata) {
			
			var fiber_connection_id=$routeParams.id;
			
					fiber_connectiondata.getfiber_connection(fiber_connection_id).success(fiber_connectionDetailSuccess).error(fiber_connectionDetailError);
					
					function fiber_connectionDetailSuccess(data) {
					$scope.viewfiber_connection = data;
					}
				 
					function fiber_connectionDetailError(data) {
					
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







