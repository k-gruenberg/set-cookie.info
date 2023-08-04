<?php
	// Set cookie by sending "Set−Cookie" HTTP response header when the user submitted the corresponding POST request and when there is no XSRF:
	if (isset($_POST["cookie"]) && $_SERVER['HTTP_X_CSRF_Free'] === 'yes') {
		header("Set−Cookie: " . $_POST["cookie"]);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Set-Cookie</title>
		<style>
			.footer {
				position: fixed;
				left: 0;
				bottom: 0;
				width: 100%;
				background-color: #eeeeee;
				color: black;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<h1>Play around with HTTP cookies and the Set-Cookie HTTP header:</h1>
		<p>
			<b>Hint:</b> Open this site in incognito/private browsing mode so that your cookie experiments can be easily reset!
		</p>
		<p>
			This is: <span id="window_location"></span><br/>
			<script>window_location.innerText = window.location;</script>
			Visit: <script>
				let sub1 = window.location.toString().includes("sub1.set-cookie.info");
				let sub2 = window.location.toString().includes("sub2.set-cookie.info");
				document.write((!sub1 && !sub2) ? "set-cookie.info" : "<a href=\"http://set-cookie.info/\">set-cookie.info</a>");
				document.write(" | ");
				document.write(sub1 ? "sub1.set-cookie.info" : "<a href=\"http://sub1.set-cookie.info/\">sub1.set-cookie.info</a>");
				document.write(" | ");
				document.write(sub2 ? "sub2.set-cookie.info" : "<a href=\"http://sub2.set-cookie.info/\">sub2.set-cookie.info</a>");
				</script><br/>
			Subdirectories: <a href="dir1">dir1</a> | <a href="dir2">dir2</a>
		</p>
		<p>
			Cookies available through <b>JavaScript</b> (<tt>document.cookie</tt>):<br/>
			<textarea readonly style="background-color: lightgray;" id="js_cookies_textarea" rows="5" cols="100"></textarea>
			<script>js_cookies_textarea.value = document.cookie</script>
		</p>
		<p>
			Cookies the client sent in its <b>HTTP</b> request:<br/>
			<textarea readonly style="background-color: lightgray;" id="http_cookies_textarea" rows="5" cols="100"><?php echo getallheaders()['Cookie']; ?></textarea>
		</p>
		<p>
			Set cookie:<br/>
			<tt>Set−Cookie: </tt><input type="text" id="cookie" size="100" /><br/>
			<input type="submit" value="Set cookie!" onclick="
				// adapted from https://de.wikipedia.org/wiki/XMLHttpRequest#Codebeispiele_(JavaScript):
				let method = 'POST';
				let url = 'index.php';
				let params = 'cookie=' + encodeURIComponent(cookie.value);
				try {
					var xmlHttp = new XMLHttpRequest();
					if (xmlHttp) {
						xmlHttp.open(method, url, true);
						xmlHttp.setRequestHeader('X-CSRF-Free', 'yes');
						xmlHttp.onreadystatechange = function () {
							if (xmlHttp.readyState == 4) {
								location.reload();
							}
						};
						xmlHttp.send(params);
					}
				} catch(e) {
					alert('XMLHttpRequest ' + method + ' ' + url + ' failed with error: ' + e);
				}
			" />
		</p>
		<p>
			Examples (see <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie">developer.mozilla.org</a> for a full reference of the <tt>Set-Cookie</tt> HTTP header):<br/>
			<ul>
				<li><tt>Set−Cookie: FOO=BAR</tt></li>
				<li><tt>Set−Cookie: FOO=BAR; Domain=set-cookie.info</tt><br/>
				("Only the current domain can be set as the value, or a domain of a higher order, [...]. Setting the domain will make the cookie available to it, as well as to all its subdomains." &mdash; <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie">developer.mozilla.org</a>)</li>
				<li><tt>Set−Cookie: FOO=BAR; Path=/dir1/</tt></li>
				<li><tt>Set−Cookie: FOO=BAR; HttpOnly</tt></li>
				<li><tt>Set−Cookie: FOO=BAR; Max-Age=10</tt></li>
				<li><tt>Set−Cookie: FOO=BAR; Secure</tt></li>
			</ul>
		</p>

		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<div class="footer" style="font-family:Arial,Helvetica,sans-serif;">
			<p>© 2023 Kendrick Grünberg | <a href="https://github.com/k-gruenberg/set-cookie.info">View source code</a> | See also: <a href="http://same-origin-policy.info">same-origin-policy.info</a> ; <a href="http://content-security-policy.info/">content-security-policy.info</a></p>
		</div>
	</body>
</html>
