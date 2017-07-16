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
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a class="brand" href="#">飞速手游登录用户信息统计</a>
						<div class="nav-collapse">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>
									ID
								</th>
								<th>
									IP
								</th>
								<th>
									HTTP_USER_AGENT
								</th>
								<th>
									LOGIN_TIME
								</th>
								<th>
									ADDRESS
								</th>
							</tr>
						</thead>
						<tbody id="pro_id">
						@forelse ($data as $k=>$v)
							<tr>
								<td>
									{{$k+1}}
								</td>
								<td>
									{{$v->IP}}
								</td>
								<td>
									{{$v->HTTP_USER_AGENT}}
								</td>
								<td>
									{{date('Y-m-d H:i:s',$v->REQUEST_TIME+3600*8)}}
								</td>
								<td>
									{{$v->ADDRESS}}
								</td>
							</tr>
						@empty
							nobody
						@endforelse
						</tbody>
					</table>
					<div class="pagination">
						{{$data->links()}}
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
		<script type="text/javascript">
            $(document).ready(function(){
                $('#b3').click(function () {
					location.href='/loginproxy';

                })
            })
		</script>

		<script type="text/javascript">
            $(document).ready(function(){
                $('#b2').click(function () {
                    var proName = $('#find1').val();
                    location.href='/findProxyList?pro_name='+proName;
                })
            })
		</script>
	</body>
</html>