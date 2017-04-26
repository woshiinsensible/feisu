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
									<a href="../settings.htm">游戏1</a>
								</li>
								<li>
									<a href="../help.htm">游戏2</a>
								</li>
								<li>
									<a href="../help.htm">添加游戏</a>
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
								<a href="/proxyList"><i class="icon-home"></i> 暂停销售</a>
							</li>
							<li>
								<a href="/rechargeList"><i class="icon-folder-open"></i> 账号列表</a>
							</li>
							<li>
								<a href="/pickupList"><i class="icon-check"></i> 账号上传</a>
							</li>
							<li>
								<a href="/pub_show"><i class="icon-envelope"></i> 账号定价</a>
							</li>
							<li>
								<a href="/zoneShow?t=fs_game_zone1"><i class="icon-file"></i> 大区名称</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="span10">
					<form id="edit-profile" class="form-horizontal">
						<fieldset>
							<legend>添加大区</legend>
							<div class="control-group">
								<label class="control-label" for="input01">全称</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="z_name" name="z_name" value="">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">简称</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="z_short" name="z_short" value="">
								</div>
							</div>
							<div class="form-actions">
								<button type="button" class="btn btn-primary" id="b1">确认添加</button>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/site.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#b1').click(function () {

				    var zName = $('#z_name').val();
				    var zShort = $('#z_short').val();
					$.get(
					 '/addZone?t=fs_game_zone1',
						{
                            z_name:zName,
                            z_short:zShort
						},
						function (res) {
					     if(res.msg === ''){
                             alert("添加大区成功");
                             //返回上一页并刷新
                             self.location=document.referrer;
                         }else{
					         alert(res.msg);
						 }
                        },
						'json'
					)
                })
			})
		</script>
	</body>
</html>