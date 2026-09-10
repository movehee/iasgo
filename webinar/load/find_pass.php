<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<script>
	$(function(){

		$('#find_passF').submit(function(){
			if(!$('#email').val()){
				alert("Please enter your ID (E-mail)");
				$('#email').focus();
				return false;
			}
			var params = $("#find_passF").serialize();
			jQuery.ajax({
				url: '/load/find_pass_reg.php',
				type: 'POST',
				data:params,
				contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
				dataType: 'html',
				async: false,
				success: function (result) {
					var parse_data = JSON.parse(result);
					if(parse_data.push=='Y'){
						alert('A password has been sent to the email address you entered.');
						parent.location.reload();
					}else{
						$('#email').val("");
						alert("No matching information");
						return false;
					}
				}, error: function (request,status,error){
					alert('Error');
					return false;
				}
			});
			return false;

			
		});
	});
</script>
<body>
	<div class="popupWrap" id="popupPwd">
		<h1>Forgotten your password?</h1>
		<div class="popupCon">
			<p>
				If you do not remember your password, please enter your ID(Email).<br>
				password will be sent out to your e-mail.
			</p>
			<div class="formArea">
				<form id="find_passF" name="find_passF" action="find_pass_reg.php" method="post">
					<fieldset>
						<legend>Forgotten your password</legend>
						<label for="" placeholder=" ">ID (E-mail) </label>
						<input type="text" name="email" id="email">
						<input type="submit" value="Find Password">
					</fieldset>
				</form>
			</div>
			<p class="note">* If you don’t remember your e-mail address, please contact the secretariat (<a href="mailto:kcr@kcr4u.org">kcr@kcr4u.org</a>)</p>
		</div>
		<div class="close"><a href="# return false;" class="color_close"></a></div>
	</div>
	<!-- //popupWrap -->



</body>
</html>