(function(){
    var order = angular.module('order',[]);
    
    order.controller('order',function($scope){
        $scope.data = {
            username:'555'
        }
        console.log($scope.data.username);
    });
})()