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
									总点数
								</th>
								<th>
									剩余点数
								</th>
								<th>
									消耗点数
								</th>
								<th>
									提货数量
								</th>
								<th>
									加入时间
								</th>
								<th>
									折扣
								</th>
								<th>
									备注
								</th>
								<th>
									状态
								</th>
								<th>
									修改密码
								</th>
								<th>
									修改备注
								</th>
								<th>
									冻结
								</th>
								<th>
									充值
								</th>
							</tr>
						</thead>
						<tbody id="pro_id">
						@forelse ($proList as $k=>$v)
							<tr>
								<td>
									{{$v['pro_id']}}
								</td>
								<td>
									{{$v['pro_name']}}
								</td>
								<td>
									{{$v['pro_total']}}
								</td>
								<td>
									{{$v['pro_surplus']}}
								</td>
								<td>
									{{$v['pro_used']}}
								</td>
								<td>
									{{$v['pro_pick']}}
								</td>
								<td>
									{{$v['pro_time']}}
								</td>
								<td>
									{{$v['pro_discount']}}
								</td>
								<td>
									{{$v['pro_comment']}}
								</td>
								@if ($v['pro_status'] == 1)
								<td>
									<span class="label label-success">正常</span>
								</td>
								@elseif ($v['pro_status'] == 0)
									<td>
										<span class="label label-warning">冻结</span>
									</td>
									@endif

								<td>
									<a href="change_pwd?pro_id={{$v['pro_id']}}&pro_name={{$v['pro_name']}}" class="view-link">修改密码</a>
								</td>
								<td>
									<a href="/change_com?pro_id={{$v['pro_id']}}&pro_name={{$v['pro_name']}}" class="view-link">修改备注</a>
								</td>

								@if ($v['pro_status'] == 1)
									<td>
										<span class="label label-warning hh1" id="{{$v['pro_id']}}" style="cursor:pointer">冻结</span>
									</td>
								@elseif ($v['pro_status'] == 0)
									<td id="{{$v['pro_id']}}">
										<span class="label label-success hh1" id="{{$v['pro_id']}}" style="cursor:pointer">激活</span>
									</td>
								@endif


								<td>
									<a href="/rec_show?pro_id={{$v['pro_id']}}&pro_name={{$v['pro_name']}}&pro_discount={{$v['pro_discount']}}&pro_total={{$v['pro_total']}}" class="view-link">充值</a>
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
								{!! $proList->links() !!}
							</li>
						</ul>
					</div>
					<div class="well-small summary">
						<ul>
							<li>
								<a href="#">代理总数: <span class="badge badge-info">{{$proRes['pro_count']}}</span></a>
							</li>
							<li>
								<a href="#">总点数: <span class="badge badge-info">{{$proRes['pro_total']}}</span></a>
							</li>
							<li>
								<a href="#">消耗总数: <span class="badge badge-info">{{$proRes['pro_surplus']}}</span></a>
							</li>
							<li>
								<a href="#">剩余点数: <span class="badge badge-info">{{$proRes['pro_used']}}</span></a>
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