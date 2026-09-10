<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<div class="popupWrap" id="popupLogout">
	<div class="popupCon">
		<p>
			Would you like to sign out?
		</p>
		<div class="btn">
			<a class="btnDef" onclick="parent.location.href='/logout.php'">OK</a>
			<a class="color_close">CANCEL</a>
		</div>
	</div>
	<!-- <div class="color_close hand" style="position:absolute;top:5px;right:10px;z-index:99999;font-size:32px;"><i class="fa fa-times" ></i> -->
</div>
</div>
<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>