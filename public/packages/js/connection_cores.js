
var connection_core = angular.module('connection_cores',[]);



connection_core.config(function configure($routeProvider) {

	$routeProvider
				.when('/connection_cores', 
		         	      { 
		         	      	controller: 'connection_coreController', 
		         	      	templateUrl: './packages/partial/connection_cores/connection_core.html' 
		         	      }
		         	  )
				  
				.when('/connection_cores/add', 
					  { 
						controller: 'connection_coreController', 
						templateUrl: './packages/partial/connection_cores/connection_core_add.html' 
					  }
				  )
				  
				.when('/connection_cores/:id', 
					  { 
						controller: 'connection_coreEditController', 
						templateUrl: './packages/partial/connection_cores/connection_core_edit.html' 
					  }
				  )
				  
				.when('/connection_core_detail/:id', 
					  { 
						controller: 'connection_coreDetailController', 
						templateUrl: './packages/partial/connection_cores/connection_core_detail.html' 
					  }
				  )
				
				
});

connection_core.factory('connection_coredata', function($http) {

	return {
			getconnection_cores: function() { 

		   	                 return  $http.get("http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber-connection-core"); 
							 
		   	             },
						 
			getconnection_core: function(id) { 
						console.log(id);
		   	                 return $http({
									method: 'GET',
									url: 'http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber-connection-core/'+id+'/edit',									
									
								});
		   	             },
			
			addconnection_core: function addconnection_core(data) { 
						console.log(data);													
							
							return	$http.post('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber-connection-core',data); 
								
		   	             },
			editconnection_core: function editconnection_core(data) { 
						console.log(data);														
							return	$http({
									method: 'PUT',
									url: "http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber-connection-core/"+data.id+"/edit",
									data: data,
									headers: {
									//'x-access-token':$cookieStore.get('token'),
									'Content-Type': 'application/x-www-form-urlencoded;'
									}
								});
						
		   	             },
			removeconnection_core: function(id) { 

							 return $http.delete('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/connection_core/'+id); 
		   	             },
		
       }


});


connection_core.controller('connection_coreController', function ($scope,$rootScope,$location,connection_coredata) {


				connection_coredata.getconnection_cores().success(function(data) {									
									
									$scope.connection_cores = data;
									$rootScope.connection_cores=$scope.connection_cores;									
									
									console.log(data);
									
									$scope.sort = function(keyname){
										$scope.sortKey = keyname;   //set the sortKey to the param passed
										$scope.reverse = !$scope.reverse; //if true make it false and vice versa
									};
									
									$scope.currentPage = 1; //current page
									$scope.maxSize =2; //pagination max size
									$scope.entryLimit = 5; //max rows for data table
									
									$scope.noOfPages = Math.ceil($scope.connection_cores.length/$scope.entryLimit);
									$scope.setPage = function(pageNo) {
										$scope.currentPage = pageNo;
									};
									
									
									$scope.filter = function() {
										$timeout(function() { //wait for 'filtered' to be changed
											$scope.noOfPages = Math.ceil($scope.filtered.length/$scope.entryLimit);
										}, 10);
									};
									
						});
						
						
						
					$scope.newconnection_core = {};
					 
					$scope.addconnection_core = function () {
					
						
						 var dataObject = $scope.newconnection_core;
						
						connection_coredata.addconnection_core(dataObject).success(connection_coreAddSuccess).error(connection_coreAddError);
						
					
					};
								
					
					function connection_coreAddSuccess(data) {
					console.log(data);
					$scope.error = null;
					$scope.connection_cores.push(data);					
					console.log($scope.connection_cores);
					$scope.newconnection_core = {};
					 $location.path('/connection_cores');

					}
				 
					function connection_coreAddError(data) {
					
					$scope.error = "Unable to add connection_core";
						
					}
					
					
					 $scope.removeconnection_core = function(id) {
   
								if (confirm('Do you really want to remove this user?')) {
										
										connection_coredata.removeconnection_core(id).success(function (data) {
																		
																		 for (i in $scope.connection_cores) {
																				if ($scope.connection_cores[i].id == id) {
																					$scope.connection_cores.splice(i, 1);
																				}
																			}
																			
																	  });
								
								}
							}
    
});


app.controller('connection_coreEditController', function ($scope,$filter,$rootScope,$routeParams,$location,connection_coredata) {

		console.log($rootScope.connection_cores);

			var connection_core_id=$routeParams.id;
			 console.log(connection_core_id);
			$scope.connection_coredata = $filter('getById')($rootScope.connection_cores,connection_core_id);
			
					 console.log($scope.connection_coredata);
					$scope.updateconnection_core = function () {
					
						console.log($scope.connection_coredata);
						
						var dataObject = {id :$routeParams.id,name: $scope.connection_coredata.name,hexcode: $scope.connection_coredata.hexcode};
						
						connection_coredata.editconnection_core(dataObject).success(connection_coreEditSuccess).error(connection_coreEditError);
						
					};
					
					
					function connection_coreEditSuccess(data) {
					
					console.log(data);

					}
				 
					function connection_coreEditError(data) {
					console.log(data);
					
					$scope.error = "Unable to edit User";
						
					}
					
				
});


app.controller('connection_coreDetailController', function ($scope,$routeParams,connection_coredata) {
			
			var connection_core_id=$routeParams.id;
			
					connection_coredata.getconnection_core(connection_core_id).success(connection_coreDetailSuccess).error(connection_coreDetailError);
					
					function connection_coreDetailSuccess(data) {
					$scope.viewconnection_core = data;
					}
				 
					function connection_coreDetailError(data) {
					
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







