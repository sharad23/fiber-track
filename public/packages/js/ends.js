
var end = angular.module('ends',[]);



end.config(function configure($routeProvider) {

	$routeProvider
				.when('/ends', 
		         	      { 
		         	      	controller: 'endController', 
		         	      	templateUrl: './packages/partial/ends/end.html' 
		         	      }
		         	  )
				  
				.when('/ends/add', 
					  { 
						controller: 'endController', 
						templateUrl: './packages/partial/ends/end_add.html' 
					  }
				  )
				  
				.when('/ends/:id', 
					  { 
						controller: 'endEditController', 
						templateUrl: './packages/partial/ends/end_edit.html' 
					  }
				  )
				  
				.when('/end_detail/:id', 
					  { 
						controller: 'endDetailController', 
						templateUrl: './packages/partial/ends/end_detail.html' 
					  }
				  )
				
				
});

end.factory('enddata', function($http) {

	return {
			getends: function() { 

		   	                 return  $http.get("http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/end"); 
							 
		   	             },
						 
			getend: function(id) { 
						console.log(id);
		   	                 return $http({
									method: 'GET',
									url: 'http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/end/'+id,									
									
								});
		   	             },
			
			addend: function addend(data) { 
						console.log(data);													
							
							return	$http.post('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/end',data); 
								
		   	             },
			editend: function editend(data) { 
						console.log(data);														
							return	$http({
									method: 'PUT',
									url: "http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/end/"+data.id+"/edit",
									data: data,
									headers: {
									//'x-access-token':$cookieStore.get('token'),
									'Content-Type': 'application/x-www-form-urlencoded;'
									}
								});
						
		   	             },
			removeend: function(id) { 

							 return $http.delete('http://devtest.websurfer.com.np/sharad/fiber-track2/public/api/end/'+id); 
		   	             },
		
       }


});


end.controller('endController', function ($scope,$rootScope,$location,enddata) {


				enddata.getends().success(function(data) {									
									
									$scope.ends = data;
									$rootScope.ends=$scope.ends;									
									
									console.log($scope.ends);
									
									$scope.sort = function(keyname){
										$scope.sortKey = keyname;   //set the sortKey to the param passed
										$scope.reverse = !$scope.reverse; //if true make it false and vice versa
									};
									
									$scope.currentPage = 1; //current page
									$scope.maxSize =2; //pagination max size
									$scope.entryLimit = 5; //max rows for data table
									
									$scope.noOfPages = Math.ceil($scope.ends.length/$scope.entryLimit);
									$scope.setPage = function(pageNo) {
										$scope.currentPage = pageNo;
									};
									
									
									$scope.filter = function() {
										$timeout(function() { //wait for 'filtered' to be changed
											$scope.noOfPages = Math.ceil($scope.filtered.length/$scope.entryLimit);
										}, 10);
									};
									
						});
						
						
						
					$scope.newend = {};
					 
					$scope.addend = function () {
					
						
						 var dataObject = $scope.newend;
						
						enddata.addend(dataObject).success(endAddSuccess).error(endAddError);
						
					
					};
								
					
					function endAddSuccess(data) {
					console.log(data);
					$scope.error = null;
					$scope.ends.push(data);					
					console.log($scope.ends);
					$scope.newend = {};
					 $location.path('/ends');

					}
				 
					function endAddError(data) {
					
					$scope.error = "Unable to add end";
						
					}
					
					
					 $scope.removeend = function(id) {
   
								if (confirm('Do you really want to remove this end?')) {
										
										enddata.removeend(id).success(function (data) {
																		
																		 for (i in $scope.ends) {
																				if ($scope.ends[i].id == id) {
																					$scope.ends.splice(i, 1);
																				}
																			}
																			
																	  });
								
								}
							}
    
});


app.controller('endEditController', function ($scope,$filter,$rootScope,$routeParams,$location,enddata) {

		console.log($rootScope.ends);

			var end_id=$routeParams.id;
			 console.log(end_id);
			$scope.enddata = $filter('getById')($rootScope.ends,end_id);
			
					 console.log($scope.enddata);
					$scope.updateend = function () {
					
						console.log($scope.enddata);
						
						var dataObject = {id :$routeParams.id,name: $scope.enddata.name,location_id: $scope.enddata.location_id,longitude:$scope.enddata.longitude,lattitude:$scope.enddata.lattitude};
						
						enddata.editend(dataObject).success(endEditSuccess).error(endEditError);
						
					};
					
					
					function endEditSuccess(data) {
					
					console.log(data);

					}
				 
					function endEditError(data) {
					console.log(data);
					
					$scope.error = "Unable to edit User";
						
					}
					
				
});


app.controller('endDetailController', function ($scope,$routeParams,enddata) {
			
			var end_id=$routeParams.id;
			
					enddata.getend(end_id).success(endDetailSuccess).error(endDetailError);
					
					function endDetailSuccess(data) {
					console.log(data);
					
					$scope.viewend = data;
					}
				 
					function endDetailError(data) {
					console.log(data);
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







