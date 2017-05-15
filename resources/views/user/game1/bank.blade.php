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
								<a href="/uploadShow?t=fs_game_bank1"><i class="icon-check"></i> 账号上传</a>
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
						<span class="badge badge-info" style="cursor:pointer" id="s1">全选</span>
						<span class="badge badge-info" style="cursor:pointer" id="s2">全不选</span>
						<span class="badge badge-info" style="cursor:pointer" id="s3">反选</span>
						<span class="badge badge-info" style="cursor:pointer" id="s4">选择没有卖出的</span>
					<h6></h6>
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
									备注
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
									原价
								</th>
								<th>
									提货时间
								</th>
								<th>
									消耗点数
								</th>
								<th>
									代理账号
								</th>
								<th>
									定价
								</th>
								<th>
									<button type="button" class="btn btn-mini btn-danger" id="b1">删除</button>
								</th>
								<th>
									修改
								</th>
								<th>
									删除
								</th>
							</tr>
						</thead>
						<tbody id="b_id">
						@forelse ($bankList as $k=>$v)
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
									{{$v->b_com}}
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
									{{$v->b_price}}
								</td>
								<td>
									{{$v->b_pickup_time}}
								</td>
								<td>
									{{$v->b_used}}
								</td>
								<td>
									{{$v->b_proxy_user}}
								</td>
								<td>
									{{--<a href="/#?b_id={{$v->b_id}}&t=fs_game_bank1" class="view-link">定价</a>--}}
									<button type="button" class="btn btn-mini btn-primary dj" id="{{$v->b_id}}">定价</button>
								</td>
								<td>
									<input type="checkbox" name="del" id="{{$v->b_used}}" value="{{$v->b_id}}" class="del">
								</td>
								<td>
									<a id="{{$v->b_id}}" href="/modGroupShow?t=fs_game_bank1&b_id={{$v->b_id}}" class="view-link hh2" style="cursor:pointer"><button type="button" class="btn btn-mini btn-info">修改</button></a>
								</td>
								<td>
									<a id="{{$v->b_id}}" class="view-link hh1" style="cursor:pointer"><button type="button" class="btn btn-mini btn-warning">删除</button></a>
								</td>
							</tr>
						@empty
							没有相关内容
						@endforelse
						</tbody>
					</table>
					<div class="well-small summary">
						<ul>
							<li>
								<a href="#">总代码数: <span class="badge badge-info">{{$countArray['bankCount']}}</span></a>
							</li>
							<li>
								<a href="#">提取代码数: <span class="badge badge-info">{{$countArray['usedCount']}}</span></a>
							</li>
							<li>
								<a href="#">剩余代码数: <span class="badge badge-info">{{$countArray['nousedCount']}}</span></a>
							</li>
						</ul>
					</div>
					<div class="pagination">
						<ul>
							<li class="disabled">
								{!! $bankList->appends(['t' => 'fs_game_bank1'])->links() !!}
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
                //单个删除组合账号
                $('.hh1').click(function () {
                    var bId = $(this).attr('id');
                    if(confirm('确认是否删除？')){
                        $.get(
                            '/delSingle?t=fs_game_bank1',
                            {b_id:bId},
                            function (res) {
                                if(res.msg === ''){
                                    alert("删除组合账号成功");
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

		<script type="text/javascript">
            $(document).ready(function(){
                //批量删除
                var chk_value =[];
                $('#b1').click(function () {
                    $('input[name="del"]:checked').each(function(){
                        chk_value.push($(this).val());
                    });
                    if(confirm('确认是否删除？')){
                        //发送ajax请求更新价格
                        $.get(
                            '/delBatch?t=fs_game_bank1',
                            {
                                b_ids:chk_value
                            },
                            function (res) {
                                if(res.msg === ''){
                                    alert("批量删除成功");
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

		<script type="text/javascript">
            $(document).ready(function(){
                //全选
                $('#s1').click(function () {
                    $("#b_id :checkbox").prop("checked", true);
                });
                //全部选
                $('#s2').click(function () {
                    $("#b_id :checkbox").prop("checked", false);
                });
                //反选
                $('#s3').click(function () {
                    $("#b_id :checkbox").each(function () {
                        $(this).prop("checked", !$(this).prop("checked"));
                    });
                });
				//选没有卖出的
                $('#s4').click(function () {
                    $("#b_id :checkbox").each(
                        function(){
                            if($(this).attr('id') == 0){
                                $(this).prop("checked", true);
							}
                        }
                    )
                });
            })
		</script>

		<script type="text/javascript">
			//修改定价
            $(document).ready(function(){
                $('.dj').click(function () {
                    var bId = $(this).attr('id');
                    var val = prompt('重新定价的价格!只能输入数字!');
                    if(isNaN(val)){
                        alert('价格不是数字，重新输入');
					}
					//发送ajax请求更新价格
                    $.get(
                        '/updatePrice?t=fs_game_bank1',
                        {
                            b_id:bId,
							b_price:val
						},
                        function (res) {
                            if(res.msg === ''){
                                alert("更新价格成功");
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