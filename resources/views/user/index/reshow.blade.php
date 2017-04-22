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
		<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
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
									<a href="index.html">总览</a>
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
								<form class="navbar-search pull-left" action="">
									<input type="text" id="datetimeStart" class="search-query span1" placeholder="代理账号" />
								</form>
								<form class="navbar-search pull-left" action="">
									<input type="text" id="datetimeStart" class="search-query span2" placeholder="开始日期" />
								</form>
								<form class="navbar-search pull-left" action="">
									<input type="text" id="datetimeEnd" class="search-query span2" placeholder="结束日期" />
								</form>
								<button type="button" class="btn btn-primary" id="b2">查询</button>
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
								<a href="/proxyList"><i class="icon-home"></i> 代理信息</a>
							</li>
							<li  class="active">
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
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>
									ID
								</th>
								<th>
									代理账号
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
						<tbody id="pro_id">
						@forelse ($rechargeList as $k=>$v)
							<tr>
								<td>
									{{$v['rec_id']}}
								</td>
								<td>
									{{$v['pro_name']}}
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
					<div class="pagination">
						<ul>
							<li class="disabled">
								{!! $rechargeList->links() !!}
							</li>
						</ul>
					</div>
					{{--<input type="hidden" id="pro_id" value="{{$v['pro_id']}}">--}}
					{{--<ul class="pager">--}}
						{{--<li class="next">--}}
							{{--<a href="activity.htm">More &rarr;</a>--}}
						{{--</li>--}}
					{{--</ul>--}}
                    {{--<ul class="pager">--}}
						{{--<li class="next">--}}
							{{--More Templates <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a>--}}
						{{--</li>--}}
					{{--</ul>--}}
				</div>
			</div>
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/site.js"></script>
		<script src="js/bootstrap-datetimepicker.js"></script>
		<script type="text/javascript">
            $("#datetimeStart").datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                autoclose: true,
                todayBtn: true,
                minView: 0,
                minuteStep:10,
            }).on("click",function(){
                $("#datetimeStart").datetimepicker("setEndDate",$("#datetimeEnd").val())
            });
            $("#datetimeEnd").datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                autoclose: true,
                todayBtn: true,
                minView: 0,
                minuteStep:1,
                startDate:new Date()
            }).on("click",function(){
                $("#datetimeEnd").datetimepicker("setStartDate",$("#datetimeStart").val())
            });
		</script>
	</body>
</html>