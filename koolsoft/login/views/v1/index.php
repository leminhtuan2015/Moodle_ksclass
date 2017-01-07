<script>
    $(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});
</script>

	<TITLE>Login</TITLE>
	<STYLE type="text/css">
	.panelContent{
		width: 70%;
		margin: 0 auto;
		padding: 20px 0px;
		text-align: center;
	}
	.btnLogin-Login{
		width: 100px;
		background-color: #0091ea;
		color: white;
		padding: 7px 15px;
		border: none;
		border-radius: 5px;
		display: block;
    	margin: 0 auto;
    	margin-top: 3%;
	}
	.inputUserName-Login{
		width: 50%;
		margin-top: 2%;
		padding: 7px 10px;
	}
</STYLE>
</HEAD>

<BODY >
	<DIV class='panelContent'>
		<div>
<!--			<img src="images/viettel.png" style="width:200px; display: inline-block;">-->
			<h5 style="display: inline-block; color:#0C5686; font-size: 2.4em; letter-spacing: 3px; font-family: sans-serif;
				text-transform:uppercase;">Learning</h5>
		</div>
        <form action="/moodle/koolsoft/login/?action=login" method="post">
            <input type="text" placeholder="User name" class="inputUserName-Login" name="username">
            <input type="password" placeholder="Password" class="inputUserName-Login" name="password">
            <button type="submit" class="btnLogin-Login">Dang nhap</button>
        </form>

		<h5 style="margin-top: 2%;">Ban chua co tai khoan? <a href="">Dang ki ngay</a></h5>
		<h5 style="margin-top: 2%;">Ban chua quen mat khau? <a href="">Reset mat khau</a></h5>
		<h4 style="margin-top: 2%;">Copyright 2017<a href=""> Hola Education. </a>All rights reserved</h4>
		<h5 style="margin-top: 2%;">Power by<a href=""> Koolsoft</a></h5>
	</DIV>
</BODY>
</HTML>
