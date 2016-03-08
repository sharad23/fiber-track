
var fiber_core = angular.module('fiber_cores',[]);



fiber_core.config(function configure($routeProvider) {

	$routeProvider
				.when('/fiber_cores', 
		         	      { 
		         	      	controller: 'fiber_coreController', 
		         	      	templateUrl: './packages/partial/fiber_cores/fiber_core.html' 
		         	      }
		         	  )
				  
				.when('/fiber_cores/add', 
					  { 
						controller: 'fiber_coreController', 
						templateUrl: './packages/partial/fiber_cores/fiber_core_add.html' 
					  }
				  )
				  
				.when('/fiber_cores/:id', 
					  { 
						controller: 'fiber_coreEditController', 
						templateUrl: './packages/partial/fiber_cores/fiber_core_edit.html' 
					  }
				  )
				  
				.when('/fiber_core_detail/:id', 
					  { 
						controller: 'fiber_coreDetailController', 
						templateUrl: './packages/partial/fiber_cores/fiber_core_detail.html' 
					  }
				  )
				
				
});



fiber_core.factory('fiber_coredata', function($http) {

	return {
			getFiber_cores: function() { 

		   	                 return  $http.get("http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber_core"); 
							 
		   	             },
						 
			getFiber_core: function(id) { 
						console.log(id);
		   	                 return $http({
									method: 'GET',
									url: 'http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber_core/'+id+'/edit',									
									
								});
		   	             },
			
			addFiber_core: function addFiber_core(data) { 
						console.log(data);													
							
							return	$http.post('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber_core',data); 
								
		   	             },
			editFiber_core: function editFiber_core(data) { 
						console.log(data);														
							return	$http({
									method: 'PUT',
									url: "http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber_core/"+data.id+"/edit",
									data: data,
									headers: {
									//'x-access-token':$cookieStore.get('token'),
									'Content-Type': 'application/x-www-form-urlencoded;'
									}
								});
						
		   	             },
			removeFiber_core: function(id) { 

							 return $http.delete('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/fiber_core/'+id); 
		   	             },
		
       }


});


fiber_core.controller('fiber_coreController', function ($scope,$rootScope,$location,fiber_coredata) {


				fiber_coredata.getFiber_cores().success(function(data) {									
									
									$scope.fiber_cores = data;
									$rootScope.fiber_cores=$scope.fiber_cores;									
									
									console.log($scope.fiber_cores);
									
									$scope.sort = function(keyname){
										$scope.sortKey = keyname;   //set the sortKey to the param passed
										$scope.reverse = !$scope.reverse; //if true make it false and vice versa
									};
									
									$scope.currentPage = 1; //current page
									$scope.maxSize =2; //pagination max size
									$scope.entryLimit = 5; //max rows for data table
									
									$scope.noOfPages = Math.ceil($scope.fiber_cores.length/$scope.entryLimit);
									$scope.setPage = function(pageNo) {
										$scope.currentPage = pageNo;
									};
									
									
									$scope.filter = function() {
										$timeout(function() { //wait for 'filtered' to be changed
											$scope.noOfPages = Math.ceil($scope.filtered.length/$scope.entryLimit);
										}, 10);
									};
									
						});
						
						
						
					$scope.newFiber_core = {};
					 
					$scope.addfiber_core= function () {
					
						
						 var dataObject = $scope.newFiber_core;
						
						fiber_coresdata.addfiber_cores(dataObject).success(Fiber_coreAddSuccess).error(Fiber_coreAddError);
						
					
					};
								
					
					function Fiber_coreAddSuccess(data) {
					console.log(data);
					$scope.error = null;
					$scope.fiber_coress.push(data);					
					console.log($scope.fiber_cores);
					$scope.newfiber_cores = {};
					 $location.path('/fiber_cores');

					}
				 
					function Fiber_coreAddError(data) {
					
					$scope.error = "Unable to add fiber_core";
						
					}
					
					
					 $scope.removeFiber_core = function(id) {
   
								if (confirm('Do you really want to remove this Fiber Core?')) {
										
										fiber_coredata.removeFiber_core(id).success(function (data) {
																		
																		 for (i in $scope.fiber_cores) {
																				if ($scope.fiber_cores[i].id == id) {
																					$scope.fiber_cores.splice(i, 1);
																				}
																			}
																			
																	  });
								
								}
							}
    
});


fiber_core.controller('fiber_coreEditController', function ($scope,$filter,$rootScope,$routeParams,$location,fiber_coredata) {

		console.log($rootScope.fiber_cores);

			var fiber_core_id=$routeParams.id;
			 console.log(fiber_core_id);
			$scope.fiber_coredata = $filter('getById')($rootScope.fiber_cores,fiber_core_id);
			
					 console.log($scope.fiber_coredata);
					$scope.updatefiber_core = function () {
					
						console.log($scope.fiber_coredata);
						
						var dataObject = {id :$routeParams.id,name: $scope.fiber_coresdata.name,hexcode: $scope.fiber_coresdata.hexcode};
						
						fiber_coredata.editFiber_core(dataObject).success(Fiber_coreEditSuccess).error(Fiber_coreEditError);
						
					};
					
					
					function Fiber_coreEditSuccess(data) {
					
					console.log(data);

					}
				 
					function Fiber_coreEditError(data) {
					console.log(data);
					
					$scope.error = "Unable to edit fiber core";
						
					}
					
				
});


fiber_core.controller('fiber_coreDetailController', function ($scope,$routeParams,fiber_coredata) {
			
			var fiber_core_id=$routeParams.id;
			
					fiber_coredata.getFiber_core(fiber_core_id).success(Fiber_coreDetailSuccess).error(Fiber_coreDetailError);
					
					function Fiber_coreDetailSuccess(data) {
					$scope.viewfiber_core = data;
					}
				 
					function Fiber_coreDetailError(data) {
					
					$scope.error = "Unable to show fiber core details.";
						
					}
					
				
});






