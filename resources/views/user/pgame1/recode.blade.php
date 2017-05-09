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
									<a href="/proxyIndex">总览</a>
								</li>
								<li  class="active">
									<a href="/pickShow?no=1&t=fs_game_bank1">游戏1</a>
								</li>
								<li>
									<a href="/pickShow?no=2">游戏2</a>
								</li>
								<li>
									<a href="/pickShow?no=0">添加游戏</a>
								</li>
							</ul>
							<form class="navbar-search pull-left" action="">
								<input type="text" class="search-query span2" placeholder="编号" />
							</form>
							<button type="button" class="btn btn-primary" id="b2">查询</button>
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
								<a href="/proxyIndex"><i class="icon-home"></i> 账号提取</a>
							</li>
							<li class="active">
								<a href="/pickRecode?t=fs_game_bank1"><i class="icon-file"></i> 提货记录</a>
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
									编号
								</th>
								<th>
									账号组合
								</th>
								<th>
									大区
								</th>
								<th>
									账号
								</th>
								<th>
									密码
								</th>
								<th>
									消耗点数
								</th>
								<th>
									购买时间
								</th>
								<th>
									绑定
								</th>
							</tr>
						</thead>
						<tbody id="b_id">
						@forelse ($resBank as $k=>$v)
							<tr>
								<td>
									{{$k+1}}
								</td>
								<td>
									{{$v->b_no}}
								</td>
								<td>
									{{$v->b_group}}
								</td>
								<td>
									{{$v->b_zone}}
								</td>
								<td>
									{{$v->b_user}}
								</td>
								<td>
									{{$v->b_pwd}}
								</td>
								<td>
									{{$v->b_used}}
								</td>
								<td>
									{{$v->b_pickup_time}}
								</td>
								<td>
									<a href="#"><span class="badge badge-info">绑定</span></a>
								</td>
							</tr>
						@empty
							没有提货记录
						@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/site.js"></script>
		<script type="text/javascript">
            $(document).ready(function(){
                $('.hh1').click(function () {
                    var proId = $(this).attr('id');
                    $.get(
                        '/changeSta',
                        {pro_id:proId},
                        function (res) {
                            if(res.msg === ''){
                                history.go(0);
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