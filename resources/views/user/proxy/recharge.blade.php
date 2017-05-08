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
							<li>
								<a href="/proxyIndex"><i class="icon-home"></i> 个人信息</a>
							</li>
							<li class="active">
								<a href="/rechargeRecode"><i class="icon-file"></i> 充值记录</a>
							</li>
							<li>
								<a href="/proxyIndex"><i class="icon-home"></i> 账号提取</a>
							</li>
							<li>
								<a href="/rechargeRecode"><i class="icon-file"></i> 提货记录</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="span10">
					<table class="table table-bordered table-striped">
						<thead>
						<tr>
							<th>
								ID
							</th>
							<th>
								充值点数
							</th>
							<th>
								充值时间
							</th>
							<th>
								充值备注
							</th>
						</tr>
						</thead>
						<tbody id="rec_id">
						@forelse ($resArray as $k=>$v)
							<tr>
								<td>
									{{$k+1}}
								</td>
								<td>
									{{$v['rec_count']}}
								</td>
								<td>
									{{$v['rec_time']}}
								</td>
								<td>
									{{$v['rec_com']}}
								</td>
							</tr>
						@empty
							nobody
						@endforelse
						</tbody>
					</table>
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
		<script type="text/javascript">
            var editor = new wangEditor('no_com');
            editor.create();
            editor.disable();
		</script>
	</body>
</html>