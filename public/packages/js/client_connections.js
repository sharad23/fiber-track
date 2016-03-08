
var client_connection = angular.module('client_connections',[]);


client_connection.config(function configure($routeProvider) {

	$routeProvider
				.when('/client_connections', 
		         	      { 
		         	      	controller: 'client_connectionController', 
		         	      	templateUrl: './packages/partial/client_connections/client_connection.html' 
		         	      }
		         	  )
				  
				.when('/client_connections/add', 
					  { 
						controller: 'client_connectionController', 
						templateUrl: './packages/partial/client_connections/client_connection_add.html' 
					  }
				  )
				  
				.when('/client_connections/:id', 
					  { 
						controller: 'client_connectionEditController', 
						templateUrl: './packages/partial/client_connections/client_connection_edit.html' 
					  }
				  )
				  
				.when('/client_connection_detail/:id', 
					  { 
						controller: 'client_connectionDetailController', 
						templateUrl: './packages/partial/client_connections/client_connection_detail.html' 
					  }
				  )
				
				
});



client_connection.factory('client_connectiondata', function($http) {

	return {
			getclient_connections: function() { 

		   	                 return  $http.get("http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/client-connection"); 
							 
		   	             },
						 
			getclient_connection: function(id) { 
						console.log(id);
		   	                 return $http({
									method: 'GET',
									url: 'http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/client-connection/'+id+'/edit',									
									
								});
		   	             },
			
			addclient_connection: function addclient_connection(data) { 
						console.log(data);													
							
							return	$http.post('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/client-connection',data); 
								
		   	             },
			editclient_connection: function editclient_connection(data) { 
						console.log(data);														
							return	$http({
									method: 'PUT',
									url: "http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/client-connection/"+data.id+"/edit",
									data: data,
									headers: {
									//'x-access-token':$cookieStore.get('token'),
									'Content-Type': 'application/x-www-form-urlencoded;'
									}
								});
						
		   	             },
			removeclient_connection: function(id) { 

							 return $http.delete('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/client_connection/'+id); 
		   	             },
		
       }


});


client_connection.controller('client_connectionController', function ($scope,$rootScope,$location,client_connectiondata) {


				client_connectiondata.getclient_connections().success(function(data) {									
									
									$scope.client_connections = data;
									$rootScope.client_connections=$scope.client_connections;									
									
									console.log($scope.client_connections);
									
									$scope.sort = function(keyname){
										$scope.sortKey = keyname;   //set the sortKey to the param passed
										$scope.reverse = !$scope.reverse; //if true make it false and vice versa
									};
									
									$scope.currentPage = 1; //current page
									$scope.maxSize =2; //pagination max size
									$scope.entryLimit = 5; //max rows for data table
									
									$scope.noOfPages = Math.ceil($scope.client_connections.length/$scope.entryLimit);
									$scope.setPage = function(pageNo) {
										$scope.currentPage = pageNo;
									};
									
									
									$scope.filter = function() {
										$timeout(function() { //wait for 'filtered' to be changed
											$scope.noOfPages = Math.ceil($scope.filtered.length/$scope.entryLimit);
										}, 10);
									};
									
						});
						
						
						
					$scope.newclient_connection = {};
					 
					$scope.addclient_connection = function () {
					
						
						 var dataObject = $scope.newclient_connection;
						
						client_connectiondata.addclient_connection(dataObject).success(client_connectionAddSuccess).error(client_connectionAddError);
						
					
					};
								
					
					function client_connectionAddSuccess(data) {
					console.log(data);
					$scope.error = null;
					$scope.client_connections.push(data);					
					console.log($scope.client_connections);
					$scope.newclient_connection = {};
					 $location.path('/client_connections');

					}
				 
					function client_connectionAddError(data) {
					
					$scope.error = "Unable to add client_connection";
						
					}
					
					
					 $scope.removeclient_connection = function(id) {
   
								if (confirm('Do you really want to remove this user?')) {
										
										client_connectiondata.removeclient_connection(id).success(function (data) {
																		
																		 for (i in $scope.client_connections) {
																				if ($scope.client_connections[i].id == id) {
																					$scope.client_connections.splice(i, 1);
																				}
																			}
																			
																	  });
								
								}
							}
    
});


app.controller('client_connectionEditController', function ($scope,$filter,$rootScope,$routeParams,$location,client_connectiondata) {

		console.log($rootScope.client_connections);

			var client_connection_id=$routeParams.id;
			 console.log(client_connection_id);
			$scope.client_connectiondata = $filter('getById')($rootScope.client_connections,client_connection_id);
			
					 console.log($scope.client_connectiondata);
					$scope.updateclient_connection = function () {
					
						console.log($scope.client_connectiondata);
						
						var dataObject = {id :$routeParams.id,name: $scope.client_connectiondata.name,hexcode: $scope.client_connectiondata.hexcode};
						
						client_connectiondata.editclient_connection(dataObject).success(client_connectionEditSuccess).error(client_connectionEditError);
						
					};
					
					
					function client_connectionEditSuccess(data) {
					
					console.log(data);

					}
				 
					function client_connectionEditError(data) {
					console.log(data);
					
					$scope.error = "Unable to edit User";
						
					}
					
				
});


app.controller('client_connectionDetailController', function ($scope,$routeParams,client_connectiondata) {
			
			var client_connection_id=$routeParams.id;
			
					client_connectiondata.getclient_connection(client_connection_id).success(client_connectionDetailSuccess).error(client_connectionDetailError);
					
					function client_connectionDetailSuccess(data) {
					$scope.viewclient_connection = data;
					}
				 
					function client_connectionDetailError(data) {
					
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







