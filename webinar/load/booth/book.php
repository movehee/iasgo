<script>
$(function(){
	$('#booth_bookF').submit(function(){
		if(!$('#name_kr').val()){
			alert("Please enter your Name");
			$('#name_kr').focus();
			return false;
		}
		if(!$('#email').val()){
			alert("Please enter your E-mail");
			$('#email').focus();
			return false;
		}
		if(!$('#content').val()){
			alert("Please enter Guest book");
			$('#content').focus();
			return false;
		}
	});
});
</script>
<div class="tabCon guest" style="display:block">
	<h3>Guest Book</h3>
	<p>
		Thank you for visiting. Please leave your message on this guest book.
	</p>

	<div class="formArea">
		<form id="booth_bookF" name="booth_bookF" action="book_reg.php" method="post">
		<input type="hidden" name="booth_sid" id="booth_sid" value="<?=$booth_sid?>">
			<fieldset>
				<legend>Guest Book</legend>
				<ul>
					<li>
						<label for="name_kr">Name</label>
						<input type="text" name="name_kr" id="name_kr" value="<?=$_COOKIE['wmember_name']?>">
					</li>
					<li>
						<label for="email">E-mail</label>
						<input type="text" name="email" id="email" value="<?=$_COOKIE['wmember_email']?>">
					</li>
					<li class="clear">
						<label for="content">Contents</label>
						<textarea name="content" id="content" cols="100" rows="10" placeholder="Please leave any information you would like delivered to the company."></textarea>
					</li>
				</ul>
				<div class="btn"><span class="btnBg btnSend"><input type="submit" value="Send"></span></div>
			</fieldset>
		</form>
	</div>
</div>