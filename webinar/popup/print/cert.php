<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
?>
<style type="text/css">
	#popupCertificaton {position: relative;width: 910px;height: 644px;font-family:'Times New Roman', sans-serif;  margin: 0 auto;}
	#popupCertificaton div.bg {display: inline-block; z-index: 1;left: 0;top: 0; width: 910px;height: 644px;}
	.name {position: absolute;display: inline-block; left: 45px;top: 190px; font-weight: bold;width:820px; font-size: 46px; line-height:46px;  text-align: center; }
</style>
<?
	$Cert_name = $conn->getOne("select if(name_eng!='', name_eng, name_kr) as cert_name from registration_tbl where sid='".$_COOKIE['wmember_sid']."'");
?>
<div id="popupCertificaton">
	<div class="bg"><img src="/asset/layout/certification_bg.png" alt="CERTIFICATE OF ATTENDANCE"></div>
	<div class="name"><?=$Cert_name?></div>
</div>
<script>print()</script>