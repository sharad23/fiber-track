
//angular.js example for factory vs service
var app = angular.module('app', ['ngRoute','ui.bootstrap','colors']);



app.run(function($http) {
     $http.defaults.headers.common['x-access-token'] ='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwibmFtZSI6IlNoYXJhZCBCYWlkeWEiLCJlbWFpbCI6ImJhaWR5YXNoYXJhZEBnbWFpbC5jb20iLCJjcmVhdGVkX2F0IjoiLTAwMDEtMTEtMzAgMDA6MDA6MDAiLCJ1cGRhdGVkX2F0IjoiMjAxNi0wMy0wMiAwNzowODo0MSIsInVzZXJuYW1lIjoic2hhcmFkMjMiLCJwYXNzd29yZCI6ImlsdXZjYW5hZGEifQ.8gt7FNT436fQpZdxpOy3r5YhPjQMVaW54JmRMW7y4NY';
	 //$http.defaults.headers.common['Content-Type'] ='application/x-www-form-urlencoded;';
});


app.config(function configure($routeProvider) {

	$routeProvider
		      .when('/colors', 
		         	      { 
		         	      	controller: 'ColorController', 
		         	      	templateUrl: './packages/partial/colors/color.html' 
		         	      }
		         	  )
				  
				.when('/colors/add', 
					  { 
						controller: 'ColorController', 
						templateUrl: './packages/partial/colors/color_add.html' 
					  }
				  )
				  
				.when('/colors/:id', 
					  { 
						controller: 'ColorEditController', 
						templateUrl: './packages/partial/colors/color_edit.html' 
					  }
				  )
				  
				.when('/color_detail/:id', 
					  { 
						controller: 'ColorDetailController', 
						templateUrl: './packages/partial/colors/color_detail.html' 
					  }
				  )
					  
				 .when('/locations', 
		         	      { 
		         	      	controller: 'LocationController', 
		         	      	templateUrl: './packages/partial/locations/location.html' 
		         	      }
		         	  )
				
});



app.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});


