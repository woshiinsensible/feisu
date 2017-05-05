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
	<body style="background-color:darkgrey">
		<div id="login-page" class="container" style="margin-top:100px;width: 540px;height: 400px">
			<form id="login-form" class="well form-horizontal">
				<div class="control-group">
					<div class="controls">
						<h3>飞速手游登录</h3>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">用户名</label>
					<div class="controls">
						<input type="text"  placeholder="用户名长度4-10位之间" id="name">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword">密码</label>
					<div class="controls">
						<input type="password" placeholder="密码长度在6-12位之间" id="password">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword">身份</label>
					<div class="controls">
						<select id="role">
							<option value="1" selected>后台管理员</option>
							<option value="2">代理</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword">验证码</label>
					<div class="controls">
						<input type="text"  placeholder="请输入验证码" id="ver_code">
						<a onclick="javascript:re_captcha();" ><img src="{{ URL('test2/1') }}"  alt="验证码" title="刷新图片" width="100" height="40" id="c2c98f0de5a04167a9e427d883690ff6" border="0"></a>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn btn-primary" id="b1">登录</button>
					</div>
				</div>
			</form>
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/site.js"></script>
		<script>
            function re_captcha() {
                $url = "{{ URL('test2/') }}";
                $url = $url + "/" + Math.random();
                document.getElementById('c2c98f0de5a04167a9e427d883690ff6').src=$url;
            }
		</script>
		<script type="text/javascript">
            //修改定价
            $(document).ready(function(){
                $('#b1').click(function () {
                    var iname = $('#name').val();
                    var ipassword = $('#password').val();
                    var irole = $('#role').val();
                    var iver_code = $('#ver_code').val();
                    $.get(
                        '/login',
                        {
                            name:iname,
                            password:ipassword,
							role:irole,
							ver_code:iver_code,
                        },
                        function (res) {
                            if(res.msg === ''){
                                if(res.role == 1){
                                    location.href= '/proxyList'
								}else if(res.role == 2){
                                    location.href= '/2'
								}
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