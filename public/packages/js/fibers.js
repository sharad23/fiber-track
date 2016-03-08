
var fiber = angular.module('fibers',[]);


fiber.config(function configure($routeProvider) {

	$routeProvider
				.when('/fibers', 
		         	      { 
		         	      	controller: 'fiberController', 
		         	      	templateUrl: './packages/partial/fibers/fiber.html' 
		         	      }
		         	  )
				  
				.when('/fibers/add', 
					  { 
						controller: 'fiberController', 
						templateUrl: './packages/partial/fibers/fiber_add.html' 
					  }
				  )
				  
				.when('/fibers/:id', 
					  { 
						controller: 'fiberEditController', 
						templateUrl: './packages/partial/fibers/fiber_edit.html' 
					  }
				  )
				  
				.when('/fiber_detail/:id', 
					  { 
						controller: 'fiberDetailController', 
						templateUrl: './packages/partial/fibers/fiber_detail.html' 
					  }
				  )
				
				
});





fiber.factory('fiberdata', function($http) {

	return {
			getFibers: function() {
					console.log('get');			

		   	                 return  $http.get("http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber"); 
							 
		   	             },
						 
			getFiber: function(id) { 
						console.log(id);
		   	                 return $http({
									method: 'GET',
									url: 'http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber/'+id+'/edit',									
									
								});
		   	             },
			
			addFiber: function addFiber(data) { 
						console.log(data);													
							
							return	$http.post('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber',data); 
								
		   	             },
			editFiber: function editFiber(data) { 
						console.log(data);														
							return	$http({
									method: 'PUT',
									url: "http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber/"+data.id+"/edit",
									data: data,
									headers: {
									//'x-access-token':$cookieStore.get('token'),
									'Content-Type': 'application/x-www-form-urlencoded;'
									}
								});
						
		   	             },
			removeFiber: function(id) { 

							 return $http.delete('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber/'+id); 
		   	             },
		
       }


});


fiber.controller('fiberController', function ($scope,$rootScope,$location,fiberdata) {


				fiberdata.getFibers().success(function(data) {									
									
									$scope.fibers = data;
									$rootScope.fibers=$scope.fibers;									
									
									console.log($scope.fibers);
									
									$scope.sort = function(keyname){
										$scope.sortKey = keyname;   //set the sortKey to the param passed
										$scope.reverse = !$scope.reverse; //if true make it false and vice versa
									};
									
									$scope.currentPage = 1; //current page
									$scope.maxSize =2; //pagination max size
									$scope.entryLimit = 5; //max rows for data table
									
									$scope.noOfPages = Math.ceil($scope.fibers.length/$scope.entryLimit);
									$scope.setPage = function(pageNo) {
										$scope.currentPage = pageNo;
									};
									
									
									$scope.filter = function() {
										$timeout(function() { //wait for 'filtered' to be changed
											$scope.noOfPages = Math.ceil($scope.filtered.length/$scope.entryLimit);
										}, 10);
									};
									
						});
						
						
						
					$scope.newFiber = {};
					 
					$scope.addfiber = function () {
					
						
						 var dataObject = $scope.newFiber;
						
						fiberdata.addFiber(dataObject).success(FiberAddSuccess).error(FiberAddError);
						
					
					};
								
					
					function FiberAddSuccess(data) {
					console.log(data);
					$scope.error = null;
					$scope.fibers.push(data);					
					console.log($scope.fibers);
					$scope.newFiber = {};
					 $location.path('/fibers');

					}
				 
					function FiberAddError(data) {
					
					$scope.error = "Unable to add Fiber";
						
					}
					
					
					 $scope.removefiber = function(id) {
   
								if (confirm('Do you really want to remove this fiber?')) {
										
										fiberdata.removeFiber(id).success(function (data) {
																		
																		 for (i in $scope.fibers) {
																				if ($scope.fibers[i].id == id) {
																					$scope.fibers.splice(i, 1);
																				}
																			}
																			
																	  });
								
								}
							}
    
});


fiber.controller('fiberEditController', function ($scope,$filter,$rootScope,$routeParams,$location,fiberdata) {

		console.log($rootScope.fibers);

			var fiber_id=$routeParams.id;
			 console.log(fiber_id);
			$scope.fiberdata = $filter('getById')($rootScope.fibers,fiber_id);
			
					 console.log($scope.fiberdata);
					$scope.updatefiber = function () {
					
						console.log($scope.fiberdata);
						
						var dataObject = {id :$routeParams.id,name: $scope.fiber.name,hexcode: $scope.fiberdata.hexcode};
						
						fiberdata.editFiber(dataObject).success(FiberEditSuccess).error(FiberEditError);
						
					};
					
					
					function FiberEditSuccess(data) {
					
					console.log(data);

					}
				 
					function FiberEditError(data) {
					console.log(data);
					
					$scope.error = "Unable to edit Fiber";
						
					}
					
				
});


fiber.controller('fiberDetailController', function ($scope,$routeParams,fiberdata) {
			
			var fiber_id=$routeParams.id;
			
					fiberdata.getFiber(fiber_id).success(FiberDetailSuccess).error(FiberDetailError);
					
					function FiberDetailSuccess(data) {
					$scope.viewfiber = data;
					}
				 
					function FiberDetailError(data) {
					
					$scope.error = "Unable to show fiber details.";
						
					}
					
				
});
