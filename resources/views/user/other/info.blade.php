<!DOCTYPE html>
<!--[if lt IE 7 ]><html lang="en" class="ie6 ielt7 ielt8 ielt9"><![endif]--><!--[if IE 7 ]><html lang="en" class="ie7 ielt8 ielt9"><![endif]--><!--[if IE 8 ]><html lang="en" class="ie8 ielt9"><![endif]--><!--[if IE 9 ]><html lang="en" class="ie9"> <![endif]--><!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>飞飞辅助棒棒哒</title>
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
						<h4>丧尸之战自助修改网站</h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">注册码</label>
					<div class="controls">
						<input type="text"  placeholder="请填写注册码" id="t1" value="{{\Illuminate\Support\Facades\Cookie::get('t1')}}">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword">网站账号</label>
					<div class="controls">
						<input type="text" placeholder="请填写网站账号" id="t2" value="{{\Illuminate\Support\Facades\Cookie::get('t2')}}">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword">网站密码</label>
					<div class="controls">
						<input type="text" placeholder="请填写网站密码" id="t3" value="{{\Illuminate\Support\Facades\Cookie::get('t3')}}">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword">设备号</label>
					<div class="controls">
						<input type="text" placeholder="请填写设备号" id="t4" value="{{\Illuminate\Support\Facades\Cookie::get('t4')}}">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn btn-primary" id="b2">停挂</button>
						<button style="margin-left: 80px" type="button" class="btn btn-primary" id="b1">更新</button>
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
                    var iname = $('#t1').val();
                    var ipassword = $('#t2').val();
                    var irole = $('#t3').val();
                    var iver_code = $('#t4').val();
                    $('#b1').attr('disabled',true);
                    $('#b2').attr('disabled',true);
                    $.get(
                        '/getInfo',
                        {
                            reg_code:iname,
                            account:ipassword,
                            password:irole,
                            device:iver_code,
                        },
                        function (res) {
							arr = '';
                            if(res.error_code == 123){

                                for (var i=0;i<res.msg.length;i++)
                                {
                                    arr += res.msg[i]+'\n';
                                }
//                                tt=trim(res.msg);
								alert(arr)
							}else{
                                alert(res.msg);
							}
                            history.go(0);

//                            if(res.msg === ''){
//                                alert('更新成功');
//                                history.go(0);
//                            }else{
//                                alert(res.msg);
//                                history.go(0);
//                            }
//							console.log(res.msg)
                        },
                        'json'
                    );
                    $.get(
                        '/cookie',
                        {
                            reg_code:iname,
                            account:ipassword,
                            password:irole,
                            device:iver_code,
                        },
                        function (res) {

                        },
                        'json'
                    )
                })
            })
		</script>
		<script type="text/javascript">
            //del
            $(document).ready(function(){
                $('#b2').click(function () {
                    var iname = $('#t1').val();
                    $('#b1').attr('disabled',true);
                    $('#b2').attr('disabled',true);
                    $.get(
                        '/delInfo',
                        {
                            reg_code:iname
                        },
                        function (res) {
                            if(res.msg === ''){
                                alert('删除成功');
                                history.go(0);
                            }else{
                                alert(res.msg);
                                history.go(0);
                            }
                        },
                        'json'
                    )
                })
            })
		</script>
	</body>
</html>