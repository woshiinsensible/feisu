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
									<a href="settings.htm">游戏1</a>
								</li>
								<li>
									<a href="help.htm">游戏2</a>
								</li>
								<li>
									<a href="help.htm">添加游戏</a>
								</li>
								<form class="navbar-search pull-left" action="">
									<input type="text" id="datetimeStart" class="search-query span2" placeholder="开始日期" />
								</form>
								<form class="navbar-search pull-left" action="">
									<input type="text" id="datetimeEnd" class="search-query span2" placeholder="结束日期" />
								</form>
							</ul>
							<ul class="nav pull-right">
								<li>
									<a href="profile.htm">@username</a>
								</li>
								<li>
									<a href="login.htm">Logout</a>
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
								<a href="index.htm"><i class="icon-white icon-home"></i> 代理信息</a>
							</li>
							<li>
								<a href="projects.htm"><i class="icon-folder-open"></i> 充值记录</a>
							</li>
							<li>
								<a href="tasks.htm"><i class="icon-check"></i> 提号记录</a>
							</li>
							<li>
								<a href="messages.htm"><i class="icon-envelope"></i> 发布公告</a>
							</li>
							<li>
								<a href="files.htm"><i class="icon-file"></i> 历史公告</a>
							</li>

						</ul>
					</div>
				</div>
				<div class="span10">
					<form id="edit-profile" class="form-horizontal">
						<fieldset>
							<legend>充值信息</legend>
							<div class="control-group">
								<label class="control-label" for="input01">代理账号</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="pro_name" name="pro_name" value="{{$data['pro_name']}}" readonly>
									<input type="hidden" id="pro_id" name="pro_id" value="{{$data['pro_id']}}">
									<input type="hidden" id="pro_total" name="pro_total" value="{{$data['pro_total']}}">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">充值点数</label>
								<div class="controls">
									<input type="number" class="input-xlarge" id="rec_count" name="rec_count" value="">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">折扣</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="pro_discount" name="pro_discount" placeholder="折扣在0-1之间"   value="{{$data['pro_discount']}}">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">充值备注</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="rec_com" name="rec_com" value="">
								</div>
							</div>
							<div class="form-actions">
								<button type="button" class="btn btn-primary" id="b1">确认充值</button>
							</div>
						</fieldset>
					</form>
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
		<script type="text/javascript">
			$(document).ready(function(){
				$('#b1').click(function () {
				    var proId = $('#pro_id').val();
				    var proName = $('#pro_name').val();
                    var recCount = $('#rec_count').val();
                    var recCom = $('#rec_com').val();
                    var proTotal = $('#pro_total').val();
                    var proDiscount = $('#pro_discount').val();
					$.get(
					 '/recharge',
						{
						    pro_id:proId,
                            pro_name:proName,
                            rec_count:recCount,
                            rec_com:recCom,
							pro_total:proTotal,
                            pro_discount:proDiscount
						},
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
	</body>
</html>