(function(){
    var detail = angular.module("detail",[]);

    detail.config(function($locationProvider){
        $locationProvider.html5Mode(true).hashPrefix('!');              
    })

    detail.controller("detail",function($scope,$http,$location){
        $scope.index = 0;
        $scope.mobile = $location.search().mobile;
        var url = "http://www.smartlifein.com/index.php?m=order&c=index&a=ajax_search_order&mobile="+$scope.mobile;
        $http.get(url).success(function(d){
            $scope.list = d.data;
        });
        
        $scope.liclick = function(index){
            $scope.index = index;
        };
    });
})()