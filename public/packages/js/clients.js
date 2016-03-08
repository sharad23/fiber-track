
var client = angular.module('clients',[]);


client.config(function configure($routeProvider) {

	$routeProvider
				.when('/clients', 
		         	      { 
		         	      	controller: 'clientController', 
		         	      	templateUrl: './packages/partial/clients/client.html' 
		         	      }
		         	  )
				  
				.when('/clients/add', 
					  { 
						controller: 'clientController', 
						templateUrl: './packages/partial/clients/client_add.html' 
					  }
				  )
				  
				.when('/clients/:id', 
					  { 
						controller: 'clientEditController', 
						templateUrl: './packages/partial/clients/client_edit.html' 
					  }
				  )
				  
				.when('/client_detail/:id', 
					  { 
						controller: 'clientDetailController', 
						templateUrl: './packages/partial/clients/client_detail.html' 
					  }
				  )
				
				
});

client.factory('clientdata', function($http) {

	return {
			getclients: function() { 

		   	                 return  $http.get("http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/client"); 
							 
		   	             },
						 
			getclient: function(id) { 
						console.log(id);
		   	                 return $http({
									method: 'GET',
									url: 'http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/client/'+id+'/edit',									
									
								});
		   	             },
			
			addclient: function addclient(data) { 
							console.log(data);													
							
							return	$http.post('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/client',data); 
								
		   	             },
			editclient: function editclient(data) { 
						console.log(data);														
							return	$http({
									method: 'PUT',
									url: "http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/client/"+data.id+"/edit",
									data: data,
									headers: {
									//'x-access-token':$cookieStore.get('token'),
									'Content-Type': 'application/x-www-form-urlencoded;'
									}
								});
						
		   	             },
			removeclient: function(id) { 

							 return $http.delete('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/client/'+id); 
		   	             },
		
       }


});


client.controller('clientController', function ($scope,$rootScope,$location,clientdata) {


				clientdata.getclients().success(function(data) {									
									
									$scope.clients = data;
									$rootScope.clients=$scope.clients;									
									
									console.log($scope.clients);
									
									$scope.sort = function(keyname){
										$scope.sortKey = keyname;   //set the sortKey to the param passed
										$scope.reverse = !$scope.reverse; //if true make it false and vice versa
									};
									
									$scope.currentPage = 1; //current page
									$scope.maxSize =2; //pagination max size
									$scope.entryLimit = 5; //max rows for data table
									
									$scope.noOfPages = Math.ceil($scope.clients.length/$scope.entryLimit);
									$scope.setPage = function(pageNo) {
										$scope.currentPage = pageNo;
									};
									
									
									$scope.filter = function() {
										$timeout(function() { //wait for 'filtered' to be changed
											$scope.noOfPages = Math.ceil($scope.filtered.length/$scope.entryLimit);
										}, 10);
									};
									
						});
						
						
						
					$scope.newclient = {};
					 
					$scope.addClient = function () {
					
						console.log('add');
						 var dataObject = $scope.newclient;
						
						clientdata.addclient(dataObject).success(clientAddSuccess).error(clientAddError);
						
					
					};
								
					
					function clientAddSuccess(data) {
					console.log(data);
					$scope.error = null;
					$scope.clients.push(data);					
					console.log($scope.clients);
					$scope.newclient = {};
					 $location.path('/clients');

					}
				 
					function clientAddError(data) {
					
					$scope.error = "Unable to add client";
						
					}
					
					
					 $scope.removeclient = function(id) {
   
								if (confirm('Do you really want to remove this client?')) {
										
										clientdata.removeclient(id).success(function (data) {
																		
																		 for (i in $scope.clients) {
																				if ($scope.clients[i].id == id) {
																					$scope.clients.splice(i, 1);
																				}
																			}
																			
																	  });
								
								}
							}
    
});


app.controller('clientEditController', function ($scope,$filter,$rootScope,$routeParams,$location,clientdata) {

		console.log($rootScope.clients);

			var client_id=$routeParams.id;
			 console.log(client_id);
			$scope.clientdata = $filter('getById')($rootScope.clients,client_id);
			
					 console.log($scope.clientdata);
					$scope.updateclient = function () {
					
						console.log($scope.clientdata);
						
						var dataObject = {id :$routeParams.id,name: $scope.clientdata.name,hexcode: $scope.clientdata.hexcode};
						
						clientdata.editclient(dataObject).success(clientEditSuccess).error(clientEditError);
						
					};
					
					
					function clientEditSuccess(data) {
					
					console.log(data);

					}
				 
					function clientEditError(data) {
					console.log(data);
					
					$scope.error = "Unable to edit User";
						
					}
					
				
});


app.controller('clientDetailController', function ($scope,$routeParams,clientdata) {
			
			var client_id=$routeParams.id;
			
					clientdata.getclient(client_id).success(clientDetailSuccess).error(clientDetailError);
					
					function clientDetailSuccess(data) {
					$scope.viewclient = data;
					}
				 
					function clientDetailError(data) {
					
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







