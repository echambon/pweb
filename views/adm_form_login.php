<section>
	<article>
		<h1>Log in form</h1>
		<p>You are not connected. Please connect now to access the administration tools.</p>
		
		<div id="messageContainer"></div>
		
		<form id="loginForm" method="post" action="/adm/process_login">
			<table style="width:100%">
			<tr>
				<td style="padding-top:20px">Username<br><input type="text" id="username" name="username"></td>
			</tr>
			<tr>
				<td style="padding-top:20px">Password<br><input type="password" id="password" name="password"></td>
			</tr>
			<tr>
				<td style="padding-top:20px"><input type="submit" value="Log in"></td>
			</tr>
			</table>
		</form>
	</article>
</section>
