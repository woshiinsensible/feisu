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
							<li class="active">
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
									标题
								</th>
								<th>
									发布时间
								</th>
								<th>
									是否置顶
								</th>
								<th>
									查看
								</th>
								<th>
									修改
								</th>
								<th>
									删除
								</th>
							</tr>
						</thead>
						<tbody id="pro_id">
						@forelse ($noticeList as $k=>$v)
							<tr>
								<td>
									{{$k+1}}
								</td>
								<td>
									{{$v['no_title']}}
								</td>
								<td>
									{{$v['no_time']}}
								</td>
								@if ($v['no_up'] == 1)
									<td>
										置顶
									</td>
								@elseif ($v['no_up'] == 0)
									<td>
										不置顶
									</td>
								@endif
								<td>
									<a href="/notice_show?no_id={{$v['no_id']}}" class="view-link">查看</a>
								</td>
								<td>
									<a href="/notice_mod?no_id={{$v['no_id']}}" class="view-link">修改</a>
								</td>
								<td>
									<a id="{{$v['no_id']}}" class="view-link hh3" style="cursor:pointer">删除</a>
								</td>
							</tr>
						@empty
							没有相关内容
						@endforelse
						</tbody>
					</table>
					<div class="pagination">
						<ul>
							<li class="disabled">
								{!! $noticeList->links() !!}
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
                $('.hh3').click(function () {
                    var noId = $(this).attr('id');
                    if(confirm('确认是否删除？')){
                        $.get(
                            '/delNotice',
                            {no_id:noId},
                            function (res) {
                                if(res.msg === ''){
                                    alert("删除公告成功");
                                    history.go(0);
                                }else{
                                    alert(res.msg);
                                }
                            },
                            'json'
                        )
					}

                })
            })
		</script>
	</body>
</html>