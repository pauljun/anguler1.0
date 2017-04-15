/*
    文件字段说明
    username      :     收件人姓名
    telphone      :     收件人手机号码
    address       :     收货地址
    mobile        :     快捷下单手机号码
    uremark       :     用户备注
    
    
    company       :     商家
    proprice      :     商品价格
    pronum        :     产品数量
    proformat     :     产品规格
    prourl        :     产品地址
    propic        :     产品图片
    proname       :     产品名称
    proid         :     产品id
    paytype       :     支付方式1:支付宝，2：微信
    
    invoice       :     发票
*/

(function(){
    var order = angular.module('order',[]);
    order.config(function($locationProvider){  
        $locationProvider.html5Mode(true).hashPrefix('!');
    }).controller('order',function($scope,$http,$location){
        $scope.showDia = false;
        $scope.need = 1;
        $scope.invo_index = 0;
        $scope.paytype = 3;
        $scope.detailsArr = ["明细","耗材","电脑配件","办公用品（附购物清单）"];
        $scope.invoice = '';
        //用户信息
        $scope.url = $location.search();
        //产品信息及用户信息
        $scope.username = '';
        $scope.telphone = '';
        $scope.address = '';
        $scope.mobile = '';
        $scope.pronum = $scope.url.num;
        $scope.prourl = $location.absUrl();
        $scope.proid = $scope.url.id;
        $scope.invoice = '';
        $scope.pass = '';
        $scope.uremark = '';
        var data;
        //详情列表
        $http.get("js/data.json").success(function(d){
            data = d.lists;
            angular.forEach(data,function(value,key){
                var url = $scope.url;
                if(value.proid == url.id){                  
                    var index = parseInt((url.type)*(value.proformat.length))+parseInt(url.config);
                    $scope.proname = value.proname;
                    $scope.proformat = value.proformat[url.type].val + ',' + value.configuration[index].val;
                    $scope.proprice = value.price[index].val;
                    $scope.company = value.company;
                    $scope.propic = value.propic;
                };
            });
        });
        
        //获取验证码
        $scope.sendPass = function(){
            var passUrl = 'http://www.smartlifein.com/index.php?m=order&c=index&a=ajax_sendsms&mobile='+$scope.mobile;
            $http.get(passUrl).success(function(data){
                if(data.code == 1){
                    
                }else{
                    
                }
            });
        };
        
        //打开发票选择弹窗
        $scope.billSelect = function(){
            $scope.showDia = true;
        };
        
        //关闭发票选择弹窗
        $scope.closeDia = function(){
            $scope.showDia = false;
        };
        
        //发票确定点击事件
        $scope.subNeed = function(){
            if($scope.need == 2){
                if($scope.invocontent == ""){
                    $scope.invoiceError = true;
                    return;
                };
                
                $scope.invoice = $scope.invocontent + ','+$scope.detailsArr[$scope.invo_index];
                $scope.showDia = false;
            }else{
                $scope.invoice = "";
                $scope.showDia = false;
            };
        };
        
        //订单提交
        $scope.orderSub = function(isValid){         
            $scope.paytype = $scope.paytype;
            //验证姓名
            if($scope.username == ""){
                $scope.formName = true;
                return; 
            };
            //手机号码验证
            if($scope.telphone == ""){
                $scope.formTelphone = true;
                return;
            };
            //收货地址验证
            if($scope.address == ""){
                $scope.formAddr = true;
                return;
            };
            //下单手机号码地址验证
            if($scope.mobile == ""){
                $scope.formMobile = true;
                return;
            };
            //验证码验证
            console.log($scope.pass);
            if($scope.pass == ""){
                $scope.formPass = true;
                return;  
            };
            
            //表单验证通过
            if(isValid){
                //验证码校验
                var passUrl = '/index.php?m=order&c=index&a=ajax_checksmscode&mobile='+$scope.mobile+'&code='+$scope.pass;
                $http.get(passUrl).success(function(data){
                    if(data.code == 1){
                        //验证码校验成功                        
                        document.getElementById("form").setAttribute("action","/mbtuan/order.php");
                        document.getElementById("form").submit();
                    }else{
                        $scope.passWrong = true;
                    }
                });
            };
        };
    });
})();