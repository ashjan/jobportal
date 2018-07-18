	 <table border="0" class="txt" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" cellpadding="0" align="center">
		<tr>
			<td width="23%" align="left"><img border="0" src="graphics/logo.jpg"></td>
			<td width="59%" align="center" valign="middle"><h2>Welcome to Administration Panel</h2> </td>
			  
			<td width="18%" align="right" nowrap="nowrap" valign="top">
				<strong>
				<?php
					echo 'Welcome '.$_SESSION[SESSNAME]['name'];
				?>
				</strong><br />
				<a href="admin.php">HOme</a> &nbsp;|&nbsp; <a href="logout.php">Logout</a>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" height="25" valign="middle"><div id="msgstatusarea"></div></td>
		</tr>
     </table>
