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
									<a href="/proxyList">总览</a>
								</li>
								<li  class="active">
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
							<li>
								<a href="/gameShow?no=1"><i class="icon-home"></i> 暂停销售</a>
							</li>
							<li>
								<a href="#"><i class="icon-folder-open"></i> 账号列表</a>
							</li>
							<li>
								<a href="#"><i class="icon-check"></i> 账号上传</a>
							</li>
							<li class="active">
								<a href="/priceShow?t=fs_game_account1"><i class="icon-envelope"></i> 账号定价</a>
							</li>
							<li>
								<a href="/zoneShow?t=fs_game_zone1"><i class="icon-file"></i> 大区名称</a>
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
									名称
								</th>
								<th>
									价格
								</th>
								<th>
									修改
								</th>
							</tr>
						</thead>
						<tbody id="a_id">
						@forelse ($priceList as $k=>$v)
							<tr>
								<td>
									{{$v->a_id}}
								</td>
								<td>
									{{$v->a_name}}
								</td>
								<td>
									{{$v->a_price}}
								</td>
								<td>
									<a href="/modPriceShow?a_id={{$v->a_id}}&t=fs_game_account1" class="view-link">修改</a>
								</td>
							</tr>
						@empty
							没有相关内容
						@endforelse
						</tbody>
					</table>
					<div class="form-actions">
						<button type="button" class="btn btn-primary" id="b1">添加账号定价</button>
					</div>
					<div class="pagination">
						<ul>
							<li class="disabled">
								{!! $priceList->links() !!}
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/site.js"></script>
		<script type="text/javascript">
            $(document).ready(function(){
                $('#b1').click(function () {
					location.href="/addPriceShow";
                })
            })
		</script>
	</body>
</html>