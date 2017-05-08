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
									<a href="/poxyList">总览</a>
								</li>
								<li>
									<a href="/gameShow?no=1">游戏1</a>
								</li>
								<li>
									<a href="/gameShow?no=2">游戏2</a>
								</li>
								<li>
									<a href="/gameShow?no=0">添加游戏</a>
								</li>
							</ul>
							{{--<form class="navbar-search pull-left" action="">--}}
								{{--<input type="text" class="search-query span2" placeholder="代理账号" />--}}
							{{--</form>--}}
							{{--<button type="button" class="btn btn-primary" id="b2">查询</button>--}}
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
								<a href="/proxyIndex"><i class="icon-home"></i> 个人信息</a>
							</li>
							<li>
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
									折扣
								</th>
								<th>
									总点数
								</th>
								<th>
									消耗点数
								</th>
								<th>
									剩余点数
								</th>
								<th>
									充值
								</th>

							</tr>
						</thead>
						<tbody id="pro_id">
						@forelse ($resStatus as $k=>$v)
							<tr>
								<td>
									{{$v['pro_discount']}}
								</td>
								<td>
									{{$v['pro_total']}}
								</td>
								<td>
									{{$v['pro_used']}}
								</td>
								<td>
									{{$v['pro_surplus']}}
								</td>
								<td>
									<a href="#"><span class="badge badge-info">淘宝充值</span></a>
									<a href="#"><span class="badge badge-info">自动充值</span></a>
								</td>
							</tr>
						@empty
							nobody
						@endforelse
						</tbody>
					</table>
					<h3  style="text-align:center;">公告栏</h3>
					<table class="table table-bordered table-striped">
						<thead>
						<tr>
							<th>
								标题
							</th>
							<th>
								发布时间
							</th>
							<th>
								查看
							</th>
						</tr>
						</thead>
						<tbody id="no_id">
						@forelse ($resNotice as $k=>$v)
							<tr>
								<td>
									{{$v['no_title']}}
								</td>
								<td>
									{{$v['no_time']}}
								</td>
								<td>
									<a href="/showNotice?no_id={{$v['no_id']}}"><span class="badge badge-info">查看</span></a>
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