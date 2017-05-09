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
									{{--@foreach ($proList as $u)--}}
										{{--{{$u['pro_name']}} <br>--}}
									{{--@endforeach--}}
								</li>
{{--								{!! $proList->links() !!}--}}
								<li>
									<a href="/pickShow?no=1&t=fs_game_bank1">游戏1</a>
								</li>
								<li>
									<a href="/pickShow?no=2">游戏2</a>
								</li>
								<li>
									<a href="/pickShow?no=3">添加游戏</a>
								</li>
							</ul>
							<ul class="nav pull-right">
								<li>
									<a href="../profile.htm">@username</a>
								</li>
								<li>
									<a href="../login.htm">Logout</a>
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
								<a href="/proxyIndex"><i class="icon-home"></i> 个人信息</a>
							</li>
							<li>
								<a href="/rechargeRecode"><i class="icon-file"></i> 充值记录</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="span10">
					<form id="edit-profile" class="form-horizontal">
						<fieldset>
							<legend>公告信息</legend>
							<div class="control-group">
								<label class="control-label" for="input01">标题</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="no_title" name="no_title" value="{{$data['no_title']}}" readonly>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">发布时间</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="no_time" name="no_time" value="{{$data['no_time']}}" readonly>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">内容</label>
								<div class="controls">
									<textarea class="input-xlarge" rows="20" id="no_com" name="no_com" readonly>{{$data['no_com']}}</textarea>
								</div>
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
				$('#b1').click(function () {
				    var proId = $('#pro_id').val();
				    var newCom = $('#new_com').val();
					$.get(
					 '/changeCom',
						{pro_id:proId,new_com:newCom},
						function (res) {
					     if(res.msg === ''){
                             location.href = "/proxyList"
                         }else{
					         alert(res.msg);
						 }
                        },
						'json'
					)
                })
			})
		</script>
		//服客户端
		<script type="text/javascript">
            var editor = new wangEditor('no_com');
            editor.create();
            editor.disable();
		</script>
	</body>
</html>