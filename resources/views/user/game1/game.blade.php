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
							<form class="navbar-search pull-left" action="">
								<input type="text" class="search-query span2" placeholder="代理账号" />
							</form>
							<button type="button" class="btn btn-primary" id="b2">查询</button>
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
								<a href="/gameShow?no=1"><i class="icon-home"></i> 暂停销售</a>
							</li>
							<li>
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
					<form id="edit-profile" class="form-horizontal">
						<fieldset>
							<legend>账号状态</legend>
							<table class="table table-bordered table-striped">
								<tbody>
								<tr>
									<td>
										账号当前状态
									</td>
									@if ($gameStatus[0]->g_sell_status == 1)
										<td>
											<span class="label label-success">开启</span>
										</td>
									@elseif ($gameStatus[0]->g_sell_status == 0)
										<td>
											<span class="label label-warning">关闭</span>
										</td>
									@endif
								<tr>
									<td>
										账号修改状态
									</td>
									@if ($gameStatus[0]->g_sell_status == 1)
										<td>
											<span class="label label-warning hh1" id="{{$gameStatus[0]->g_id}}" style="cursor:pointer">关闭</span>
										</td>
									@elseif ($gameStatus[0]->g_sell_status == 0)
										<td id="{{$gameStatus[0]->g_id}}">
											<span class="label label-success hh1" id="{{$gameStatus[0]->g_id}}" style="cursor:pointer">开启</span>
										</td>
									@endif
								</tr>
								<tr>
									<td>
										价格显示状态
									</td>
									@if ($gameStatus[0]->g_price_status == 1)
										<td>
											<span class="label label-success">开启</span>
										</td>
									@elseif ($gameStatus[0]->g_price_status == 0)
										<td>
											<span class="label label-warning">关闭</span>
										</td>
									@endif
								</tr>
								<tr>
									<td>
										价格修改状态
									</td>
									@if ($gameStatus[0]->g_price_status == 1)
										<td>
											<span class="label label-warning hh2" id="{{$gameStatus[0]->g_id}}" style="cursor:pointer">关闭</span>
										</td>
									@elseif ($gameStatus[0]->g_price_status == 0)
										<td id="{{$gameStatus[0]->g_id}}">
											<span class="label label-success hh2" id="{{$gameStatus[0]->g_id}}" style="cursor:pointer">开启</span>
										</td>
									@endif
								</tr>
								<tr>
									<td>
										账号绑定选择
									</td>
									<td>
										<select name="bind" id="bind">
											<option value="">请选择</option>
											<option value="0">关闭</option>
											<option value="1">牵引码</option>
											<option value="2">绑定账号</option>
											<option value="3">双选</option>
										</select>
									</td>
								</tr>
								</tbody>
							</table>
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
                $('.hh1').click(function () {
                    var gId = $(this).attr('id');
                    $.get(
                        '/changeSell',
                        {g_id:gId},
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

		<script type="text/javascript">
            $(document).ready(function(){
                $('.hh2').click(function () {
                    var gId = $(this).attr('id');
                    $.get(
                        '/changePrice',
                        {g_id:gId},
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