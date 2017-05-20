<!DOCTYPE html>
<!--[if lt IE 7 ]><html lang="en" class="ie6 ielt7 ielt8 ielt9"><![endif]--><!--[if IE 7 ]><html lang="en" class="ie7 ielt8 ielt9"><![endif]--><!--[if IE 8 ]><html lang="en" class="ie8 ielt9"><![endif]--><!--[if IE 9 ]><html lang="en" class="ie9"> <![endif]--><!--[if (gt IE 9)|!(IE)]><!--> 
<html lang="en"><!--<![endif]--> 
	<head>
		<meta charset="utf-8">
		<title>飞速手游棒棒哒</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="css/site.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="wE/dist/css/wangEditor.min.css">
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<div class="container">
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a class="brand" href="#">飞速手游</a>
						<div class="nav-collapse">
							<ul class="nav">
								<li class="active">
									<a href="proxyList">总览</a>
								</li>
								<li>
									<a href="/gameShow?no=1">游戏1</a>
								</li>
								<li>
									<a href="/gameShow?no=2">游戏2</a>
								</li>
								<li>
									<a href="/gameShow?no=3">添加游戏</a>
								</li>
							</ul>
							<ul class="nav pull-right">
								<li>
									<a><span class="badge">用户:{{ Session::get('user_name')}}</span></a>
								</li>
								<li>
									<a href="/logout"><span class="badge badge-important">退出</span></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span2">
					<div class="well" style="padding: 8px 0;">
						<ul class="nav nav-list">
							<li class="nav-header">
								飞速手游
							</li>
							<li class="active">
								<a href="/proxyList"><i class="icon-home"></i> 代理信息</a>
							</li>
							<li>
								<a href="/rechargeList"><i class="icon-folder-open"></i> 充值记录</a>
							</li>
							<li>
								<a href="/pickupList"><i class="icon-check"></i> 提号记录</a>
							</li>
							<li>
								<a href="/pub_show"><i class="icon-envelope"></i> 发布公告</a>
							</li>
							<li>
								<a href="/noticeList"><i class="icon-file"></i> 历史公告</a>
							</li>

						</ul>
					</div>
				</div>
				<div class="span10">
					<form id="edit-profile" class="form-horizontal">
						<fieldset>
							<legend>注册代理用户</legend>
							<div class="control-group">
								<label class="control-label" for="input01">代理账号</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="pro_name" name="pro_name" value="" placeholder="代理账号在4-10位之间">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">密码</label>
								<div class="controls">
									<input type="password" class="input-xlarge" id="pro_pwd" name="pro_pwd" value="">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">确认密码</label>
								<div class="controls">
									<input type="password" class="input-xlarge" id="pro_pwd2" name="pro_pwd2" value="">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">备注</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="pro_comment" name="pro_comment" value="">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">点数</label>
								<div class="controls">
									<input type="number" class="input-xlarge" id="pro_surplus" name="pro_surplus" value="" placeholder="必须输入整数">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">折扣</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="pro_discount" name="pro_discount" value="" placeholder="必须0-1之间，小数点必须是英文的">
								</div>
							</div>
							<div class="form-actions">
								<button type="button" class="btn btn-primary" id="b1">确认注册</button>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/site.js"></script>
		<script type="text/javascript" src="wE/dist/js/lib/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="wE/dist/js/wangEditor.min.js"></script>
		<script type="text/javascript">
                $(document).ready(function(){
                    $("#pro_name").blur(function(){
                        var proName = $('#pro_name').val();
                        $.get(
                            '/prouserExist',
                            {
                                pro_name:proName

                            },
                            function (res) {
                                if(res.msg !== ''){
                                    alert(res.msg);
                                }
                            },
                            'json'
                        )
                    });
                })
		</script>
		<script type="text/javascript">
            $(document).ready(function(){
                $("#b1").click(function(){
                    var proName = $('#pro_name').val();
                    var proWpd = $('#pro_pwd').val();
                    var proWpd2 = $('#pro_pwd2').val();
                    var proComment = $('#pro_comment').val();
                    var proSurplus = $('#pro_surplus').val();
                    var proDiscount = $('#pro_discount').val();
                    $.get(
                        '/loginProxyUser',
                        {
                            pro_name:proName,
                            pro_pwd:proWpd,
                            pro_pwd2:proWpd2,
                            pro_comment:proComment,
                            pro_count:proSurplus,
                            pro_discount:proDiscount
                        },
                        function (res) {
                            if(res.msg === ''){
                                alert("注册代理用户成功");
                                //返回上一页并刷新
                                self.location=document.referrer;
                            }else{
                                alert(res.msg);
                            }
                        },
                        'json'
                    )
                });
            })
		</script>
	</body>
</html>