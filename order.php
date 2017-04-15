<?php
$info = $_POST;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="telephone=no" name="format-detection">
	<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	
	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/style.css">
	
	<title>订单详情</title>
</head>
<body ng-app="order" ng-controller="order">
	<header class="g-header">
		<a class="logo fl" href="http://m.smartlifein.com/">
			<img src="http://m.smartlifein.com/statics/images/mobile/logo.png" alt="智慧生活">
		</a>
		<span class="u-header_tlt">团购</span>
		<a class="fr nav_href" href="http://m.smartlifein.com/navigation.html"></a>
		<a class="fr search_href" href="http://m.smartlifein.com/search/"></a>
	</header>
	
	<nav class="search_bar">
		<a href="javascript:window.history.go(-1);"></a>
		<h3>确认订单</h3>
	</nav>	

    <section class="m-order">
        <div class="m-detail_content">
            <div class="dl">
                <div class="dt">
                    <a>
                        <img src="<?php echo $info["propic"];?>" alt="">
                    </a>
                </div>
                <div class="dd">
                    <h3>
                        <a>
                            <?php echo $info["proname"];?><?php echo $info["proname"];?>(<?php echo $info["proformat"];?>)</a>
                    </h3>
                    <em><?php echo $info["proprice"];?>元×<?php echo $info["pronum"];?></em>
                    <h4>&#65509;<?php echo $info["proprice"]*$info["pronum"];?></h4>
                    <h5>由<?php echo $info["company"];?>厂商提供</h5>
                </div>
            </div>
        </div>
        
        <div class="m-order_list">
            <ul>
                <li>
                    收件人：<span><?php echo $info["username"];?></span>
                </li>
                <li>
                    收件人手机号：<span><?php echo $info["telphone"];?></span>
                </li>
                <li>
                    详细地址：<span><?php echo $info["address"];?></span>
                </li>
                <li class="clearfix">
                    发票信息：<span class="fr">发票：<?php echo $info["invoice"];?></span>
                </li>
                <li>
                    添加备注：<span><?php echo $info["uremark"];?></span>
                </li>
            </ul>
        </div>

        <div class="u-gray"></div>
        
        <div class="m-order_list">
            <ul>
                <li>
                    支付方式
                </li>
                <li>
                   <?php if(in_array($info["paytype"],array(2,4))):?>
                    <div class="dl">
                        <div class="dt u-wx"></div>
                        <div class="dd">
                            <h3>微信支付</h3>
                            <p>推荐安装微信5.0及以上版本的用户使用</p>
                        </div>
                    </div>
                    <?php else:?>
                    <div class="dl">
                        <div class="dt u-ap"></div>
                        <div class="dd">
                            <h3>支付宝</h3>
                            <p>推荐有支付宝账号的用户使用</p>
                        </div>
                    </div>
                    <?php endif;?>
                </li>
            </ul>
            <div class="u-order_submit" ng-click="subPay()">确认支付</div>
        </div>
    </section>
    
	<footer class="g-footer">
		<div class="footer_nav">
			<a href="http://m.smartlifein.com/navigation.html">导航</a>
			<a href="http://m.smartlifein.com/aboutus.html">关于我们</a>
			<a href="http://m.smartlifein.com/aboutus.html?do=tougao">投稿</a>
			<a href="http://m.smartlifein.com/report.html">反馈</a>
		</div>
		<p>智慧生活网 (粤ICP备06087881号-17)</p>
	</footer>
	<script src="js/angular1-4-6.min.js"></script>
	<script>
        (function(){
            var order = angular.module("order",[]).config(function($httpProvider){
                $httpProvider.defaults.transformRequest=function(obj){
                    var str=[];
                    for(var p in obj){
                        str.push(encodeURIComponent(p)+"="+encodeURIComponent(obj[p]));
                    }
                    return str.join("&");
                };

                $httpProvider.defaults.headers.post={
                    'Content-Type':'application/x-www-form-urlencoded'
                };
            });
                
            order.controller("order",function($scope,$http){
                $scope.data = {
                    paytype:"<?php echo $info["paytype"];?>",
                    proid:"<?php echo $info["proid"];?>",
                    proname:'<?php echo $info["proname"];?>',
                    propic:"<?php echo $info["propic"];?>",
                    prourl:"<?php echo $info["prourl"];?>",
                    proformat:"<?php echo $info["proformat"];?>",
                    pronum:"<?php echo $info["pronum"];?>",
                    proprice:"<?php echo $info["proprice"];?>",
                    invoice:"<?php echo $info["invoice"];?>",
                    company:"<?php echo $info["company"];?>",
                    username:'<?php echo $info["username"];?>',
                    mobile:"<?php echo $info["mobile"];?>",
                    telphone:"<?php echo $info["telphone"];?>",
                    address:"<?php echo $info["address"];?>",
                    uremark:"<?php echo $info["uremark"];?>",
                    code:"<?php echo $info["pass"];?>"
                };
                
                $scope.subPay = function(){
                    var url = "http://www.smartlifein.com/index.php?m=order&c=index&a=ajax_order";
                    $http({
                        url:url,
                        method: 'POST',   
                        data: $scope.data
                    }).success(function(){
                        console.log("success!");
                    })
                };
            });
        })();
    </script>
</body>
</html>