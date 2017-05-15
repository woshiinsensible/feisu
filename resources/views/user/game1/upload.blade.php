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
								<li>
									<a href="proxyList">总览</a>
								</li>
								<li class="active">
									<a href="/gameShow?no=1">游戏1</a>
								</li>
								<li>
									<a href="/gameShow?no=2">游戏2</a>
								</li>
								<li>
									<a href="/gameShow?no=0">添加游戏</a>
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
							<li>
								<a href="/gameShow?no=1"><i class="icon-home"></i> 暂停销售</a>
							</li>
							<li class="active">
								<a href="/bankShow?t=fs_game_bank1"><i class="icon-folder-open"></i> 账号列表</a>
							</li>
							<li>
								<a href="#"><i class="icon-check"></i> 账号上传</a>
							</li>
							<li>
								<a href="/priceShow?t=fs_game_account1"><i class="icon-envelope"></i> 账号定价</a>
							</li>
							<li>
								<a href="/zoneShow?t=fs_game_zone1"><i class="icon-file"></i> 大区名称</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="span10">
					<form id="edit-profile" class="form-horizontal" action="/readExcel?t=fs_game_bank1" method="post" enctype="multipart/form-data">
						<fieldset>
							<legend>上传组合账号</legend>
							<div class="control-group">
								<label class="control-label" for="input01">账号</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="b_user" name="b_user" value="">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">密码</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="b_pwd" name="b_pwd" value="">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">大区简称</label>
								<div class="controls">
									<select name="sel1" id="sel1">
										@forelse ($zoneData as $v)
												<option id="b_terminal" value="{{$v->z_short}}">{{$v->z_short}}</option>
										@empty
											nobody
										@endforelse
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">大区名称</label>
								<div class="controls">
									<select name="sel1" id="sel1">
										@forelse ($zoneData as $v)
												<option id="b_zone" value="{{$v->z_name}}">{{$v->z_name}}</option>
										@empty
											nobody
										@endforelse
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">组合</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="b_group" name="b_group" value="" style="width:750px">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">备注</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="b_com" name="b_com" value="">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">价格</label>
								<div class="controls">
									<input type="number" class="input-xlarge" id="b_price" name="b_price" value="">
								</div>
							</div>
							<div class="control-group">
								<div class="controls">
									<button type="button" class="btn btn-primary" id="b1">确认添加</button>
								</div>
							</div>
							<div class="form-actions">
								<label class="control-label" for="input01">批量上传</label>
								<div class="controls">
										<input type="file" name="excel"/>
										<button type="submit" class="btn btn-primary">批量上传</button>
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
		<script type="text/javascript">
			$(document).ready(function(){
				$('#b1').click(function () {

				    var bId = $('#b_id').val();
				    var bUser = $('#b_user').val();
				    var bPwd = $('#b_pwd').val();
                    var bTerminal = $('#b_terminal').val();
                    var bZone = $('#b_zone').val();
                    var bGroup = $('#b_group').val();
                    var bCom = $('#b_com').val();
                    var bPrice = $('#b_price').val();
					$.get(
					 '/modGroup?t=fs_game_bank1',
						{
                            b_id:bId,
							b_user:bUser,
							b_pwd:bPwd,
							b_terminal:bTerminal,
							b_zone:bZone,
							b_group:bGroup,
							b_com:bCom,
							b_price:bPrice
						},
						function (res) {
					     if(res.msg === ''){
                             alert("修改组合账号成功");
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