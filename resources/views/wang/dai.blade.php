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
						<h3>王者荣耀充值</h3>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputZhan">战区</label>
					<div class="controls">
						<select id="sel1" name="zhanqu">
							<option value="0">请选择</option>
							<option value="AZVX-">安卓微信</option>
							<option value="AZQQ-">安卓qq</option>
							<option value="IOSVX-">苹果微信</option>
							<option value="IOSQQ">苹果qq</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputZhan">刷图选择</label>
					<div class="controls">
						<select id="sel2" name="shuatu">
							<option value="0">请选择</option>
							<option value="3">大师魔女回忆</option>
							<option value="2">精英魔女回忆</option>
							<option value="1">普通魔女回忆</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">账号</label>
					<div class="controls">
						<input type="text"  id="t1" value="{{\Illuminate\Support\Facades\Cookie::get('t1')}}">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword">密码</label>
					<div class="controls">
						<input type="text"  id="t2" value="{{\Illuminate\Support\Facades\Cookie::get('t2')}}">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword">充值码</label>
					<div class="controls">
						<input type="text"  id="t3" value="{{\Illuminate\Support\Facades\Cookie::get('t3')}}">
					</div>
				</div>
				{{--<div class="control-group">--}}
					{{--<label class="control-label" for="inputPassword">设备号</label>--}}
					{{--<div class="controls">--}}
						{{--<input type="text" placeholder="请填写设备号" id="t4" value="{{\Illuminate\Support\Facades\Cookie::get('t4')}}">--}}
					{{--</div>--}}
				{{--</div>--}}
				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn btn-primary" id="b2">确认充值</button>
						<button style="margin-left: 50px" type="button" class="btn btn-primary" id="b1">剩余点数</button>
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
                    var iname = $('#sel1').val();
                    var ipassword = $('#t1').val();
                    var irole = $('#t2').val();
                    var iver_code = $('#t3').val();
                    $('#b1').attr('disabled',true);
                    $('#b2').attr('disabled',true);
                    $.get(
                        '/wang_recharge_do',
                        {
                            zhanqu:iname,
                            zhanghao:ipassword,
                            mima:irole,
                            chongzhima:iver_code
                        },
                        function (res) {
							arr = '';
//							console.log(res.msg);
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
                        '/wang_cookie',
                        {
                            zhanqu:iname,
                            zhanghao:ipassword,
                            mima:irole,
                            chongzhima:iver_code
                        },
                        function (res) {

                        },
                        'json'
                    )
                })
            })
		</script>
		<script type="text/javascript">
            $(document).ready(function(){
                $('#b2').click(function () {
                    var iname = $('#sel1').val();
                    var shuatu1 = $('#sel2').val();
                    var ipassword = $('#t1').val();
                    var irole = $('#t2').val();
                    var iver_code = $('#t3').val();
                    $('#b1').attr('disabled',true);
                    $('#b2').attr('disabled',true);
                    $.get(
                        '/wang_recharge_submit',
                        {
                            zhanqu:iname,
                            zhanghao:ipassword,
                            mima:irole,
                            chongzhima:iver_code,
                            shuatu:shuatu1
                        },
                        function (res) {
                            arr = '';
//							console.log(res.msg);
                            if(res.error_code == 123){

                                for (var i=0;i<res.msg.length-9;i++)
                                {
                                    arr += res.msg[i]+'\n';
                                }
//                                tt=trim(res.msg);
                                var r = confirm(arr);
                                if (r==true)
                                {
                                    zz = parseInt(res.msg[13])+parseInt(res.msg[14]);
                                    location.href='/wang_yes?zhanqu='+res.msg[10]+'&zhanghao='+res.msg[11]+'&mima='+res.msg[12]+'&chongzhima='+res.msg[9]+'&jihaoji='+res.msg[7]+'&shuatu='+res.msg[6]+'&zong='+zz+'&sheng='+res.msg[8];
                                }
                                else
                                {
                                    history.go(0);
                                }
                            }else{
                                alert(res.msg);
                                history.go(0);
                            }


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
                        '/wang_cookie',
                        {
                            zhanqu:iname,
                            zhanghao:ipassword,
                            mima:irole,
                            chongzhima:iver_code,
                        },
                        function (res) {

                        },
                        'json'
                    )
                })
            })
		</script>
	</body>
</html>