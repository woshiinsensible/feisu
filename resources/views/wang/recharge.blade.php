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
							{{--<option value="AZVX-">安卓微信</option>--}}
							<option value="AZQQ-">安卓qq</option>
							{{--<option value="IOSVX-">苹果微信</option>--}}
							<option value="IOSQQ-">苹果qq</option>
						</select>
					</div>
				</div>
				{{--<div class="control-group">--}}
					{{--<label class="control-label" for="inputZhan">刷图选择</label>--}}
					{{--<div class="controls">--}}
						{{--<select id="sel2" name="shuatu">--}}
							{{--<option value="0">请选择</option>--}}
							{{--<option value="3">大师魔女回忆</option>--}}
							{{--<option value="2">精英魔女回忆</option>--}}
							{{--<option value="1">普通魔女回忆</option>--}}
						{{--</select>--}}
					{{--</div>--}}
				{{--</div>--}}
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
            var obj = document.getElementById("sel1");
            for (var i = 0; i < obj.options.length; i++) {
                if (obj.options[i].value == getCookie('sel1')) {
                    obj.options[i].selected=true;
                    break;//好像是return false;
                }

            }

            ///设置cookie
            function setCookie(NameOfCookie, value, expiredays)
            {
//@参数:三个变量用来设置新的cookie:
//cookie的名称,存储的Cookie值,
// 以及Cookie过期的时间.
// 这几行是把天数转换为合法的日期

                var ExpireDate = new Date ();
                ExpireDate.setTime(ExpireDate.getTime() + (expiredays * 24 * 3600 * 1000));

// 下面这行是用来存储cookie的,只需简单的为"document.cookie"赋值即可.
// 注意日期通过toGMTstring()函数被转换成了GMT时间。

                document.cookie = NameOfCookie + "=" + escape(value) +
                    ((expiredays == null) ? "" : "; expires=" + ExpireDate.toGMTString());
            }

            ///获取cookie值
            function getCookie(NameOfCookie)
            {

// 首先我们检查下cookie是否存在.
// 如果不存在则document.cookie的长度为0

                if (document.cookie.length > 0)
                {

// 接着我们检查下cookie的名字是否存在于document.cookie

// 因为不止一个cookie值存储,所以即使document.cookie的长度不为0也不能保证我们想要的名字的cookie存在
//所以我们需要这一步看看是否有我们想要的cookie
//如果begin的变量值得到的是-1那么说明不存在

                    begin = document.cookie.indexOf(NameOfCookie+"=");
                    if (begin != -1)
                    {

// 说明存在我们的cookie.

                        begin += NameOfCookie.length+1;//cookie值的初始位置
                        end = document.cookie.indexOf(";", begin);//结束位置
                        if (end == -1) end = document.cookie.length;//没有;则end为字符串结束位置
                        return unescape(document.cookie.substring(begin, end)); }
                }

                return null;

// cookie不存在返回null
            }

            ///删除cookie
            function delCookie (NameOfCookie)
            {
// 该函数检查下cookie是否设置，如果设置了则将过期时间调到过去的时间;
//剩下就交给<a href="http://lib.csdn.net/base/operatingsystem" class='replace_word' title="操作系统知识库" target='_blank' style='color:#df3434; font-weight:bold;'>操作系统</a>适当时间清理cookie啦

                if (getCookie(NameOfCookie)) {
                    document.cookie = NameOfCookie + "=" +
                        "; expires=Thu, 01-Jan-70 00:00:01 GMT";
                }
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
                    var sel1_value =  document.getElementById('sel1').value;
                    setCookie('sel1',sel1_value,3);
                    console.log(getCookie('sel1'));
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
//                    var shuatu1 = $('#sel2').val();
                    var ipassword = $('#t1').val();
                    var irole = $('#t2').val();
                    var iver_code = $('#t3').val();
                    $('#b1').attr('disabled',true);
                    $('#b2').attr('disabled',true);
                    var sel1_value =  document.getElementById('sel1').value;
                    setCookie('sel1',sel1_value,3);
                    console.log(getCookie('sel1'));
                    $.get(
                        '/wang_recharge_submit',
                        {
                            zhanqu:iname,
                            zhanghao:ipassword,
                            mima:irole,
                            chongzhima:iver_code,
//                            shuatu:shuatu1
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