
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<meta content="" name="description" />
    <meta content="webthemez" name="author" />
    <title>站长后台-管理首页-领航移动</title>
    <link href="/css/font-awesome.css" rel="stylesheet" />
    <link href="/css/admin.css?20180105" rel="stylesheet"/>
    <script src="/script/jquery.min.js"></script>    
</head>

<body style="background: #000">
<div class="login">
	<div class="content">
		<h1>后台登陆</h1>
		<form action="" method="post">
			<input type="text" name="username" class="username" placeholder="Username">
			<input type="password" name="password" class="password" placeholder="Password">
			{!! csrf_field() !!}
			<button type="submit">Sign me in</button>
		</form>
	</div>
</div>
</body>
</html>