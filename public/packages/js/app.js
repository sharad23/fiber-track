
//angular.js example for factory vs service
var app = angular.module('app', ['ngRoute','ui.bootstrap','colors','fibers','fiber_cores','fiber_connections','ends','connection_cores','clients','client_connections']);

app.run(function($http) {
     $http.defaults.headers.common['x-access-token'] ='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwibmFtZSI6IlNoYXJhZCBCYWlkeWEiLCJlbWFpbCI6ImJhaWR5YXNoYXJhZEBnbWFpbC5jb20iLCJjcmVhdGVkX2F0IjoiLTAwMDEtMTEtMzAgMDA6MDA6MDAiLCJ1cGRhdGVkX2F0IjoiMjAxNi0wMy0wMiAwNzowODo0MSIsInVzZXJuYW1lIjoic2hhcmFkMjMiLCJwYXNzd29yZCI6ImlsdXZjYW5hZGEifQ.8gt7FNT436fQpZdxpOy3r5YhPjQMVaW54JmRMW7y4NY';
	 //$http.defaults.headers.common['Content-Type'] ='application/x-www-form-urlencoded;';
});


app.config(function configure($routeProvider) {

	$routeProvider
				.when('/', 
		         	      { 
		         	      	controller: 'HomeController', 
		         	      	templateUrl: './packages/partial/index.html' 
		         	      }
		         	  )
		      
});



app.controller('HomeController', function () {

		 
					
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


app.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});


