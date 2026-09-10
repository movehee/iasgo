<?
include $DOCUMENT_ROOT ."/func/config.php";
include "config.php";
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<TITLE>::: 미리보기 ::: </TITLE>
<?=$_js_css?>
<style type="text/css">
	body,table,div,td,span{font-size:9pt;}
	.mail_tbl{border-top:1px solid #f17f0d;border-bottom:1px solid #f17f0d;border-collapse: collapse;width:626px;}
	.mail_tbl .th{background:#f6f6f6;text-align:left;padding-left:15px;height:30px;border-bottom:1px dashed #dbdbdb;width:100px;}	
	.mail_tbl .td{border-bottom:1px dashed #dbdbdb;padding-left:15px;width:526px;}
</style>
</HEAD>
 <link type="text/css" rel="stylesheet" href="/admin/button_package/button.css" />
<BODY topmargin="0" leftmargin="0">
<div style="text-align:center;">
<br/>
<div style="text-align:left;padding:0px;margin:0 auto;width:660px;font-size:15px;">- 미리보기 화면입니다. 하단의 '발송하기' 버튼을 클릭하세요.</div>
<div style="text-align:left;padding:3px 0 0 0px;margin:0 auto;width:660px;font-size:15px;">- 미리보기에선 첨부 파일은 파일명만 표시됩니다. 발송시 정상 링크 됩니다.</div>
<br/>
<?
require_once "${_SERVER[DOCUMENT_ROOT]}func/class.Template.php";

$tpl = new Template("./templates/");
$tpl->set_file("mail","template.mail0${temp_val}.html");
if($btn_type == '1'){
	$link_btn = "<a href='http://".$btn_url."' target='_blank'><img src='/image/pop/btn_detail.gif' alt=''/></a>";
}else if($btn_type == '2'){
	$link_btn = "<a href='http://".$btn_url."' target='_blank'><img src='/image/pop/btn_detail.gif' alt=''/></a>";
}else{
	$link_btn = "";
}

$tpl->set_var(array(
        'url'=>'http://' . $HTTP_HOST,
        'subject_value'=>$subject,
        'body_value'=>"<span id='mail_html'></span>",
        'link_btn'=>$link_btn,
		'site_name'=>$site_name,
		'site_addr'=>$site_addr,
		'site_tel'=>$site_tel,
		'site_fax'=>$site_fax,
		'site_email'=>$site_email,
		'footer2'=>$footer2,
        'date'=>date('Y-m-d'),
        'attach_file'=>"<span id='attach_html'></span>"
));

$tpl->parse("mailcontents","mail");
$html = $tpl->get_var("mailcontents");

echo "<center>".$html."</center>";
?>

</div><br/>
<p align="center">
	<span class="btnAdmin large empty blue"><button type="button" onclick="opener.document.form01.mode.value='imsi';opener.document.getElementById('wait_icon').style.display = '';opener.document.form01.submit();self.close();">발송하기</button></span>

	<span class="btnAdmin large darkGray"><button type="button" onclick="self.close()">수정하기</button></span>

</p>

<script>
	document.getElementById("mail_html").innerHTML = opener.document.getElementById("b_body").value;
	var html = "<br/><br/>";
	var arr = "";
	for(i=1;i<=10;i++){
		//if(opener.document.getElementsByName("original_name"+i)){
			if(opener.document.getElementsByName("original_name"+i)[0] && opener.document.getElementsByName("original_name"+i)[0].value){
				arr = opener.document.getElementsByName("original_name"+i)[0].value.split("\\");
				html +="<span style='color:red;'>첨부파일</span> : "+arr[arr.length-1]+"<br/>";
			}
		//}
	}
	
	for(i=1;i<=10;i++){
		if(opener.document.getElementsByName("userfile"+i)[0] && opener.document.getElementsByName("userfile"+i)[0].value){
			arr = opener.document.getElementsByName("userfile"+i)[0].value.split("\\");
			html +="<span style='color:red;'>첨부파일</span> : "+arr[arr.length-1]+"<br/>";
		}
	}

	document.getElementById("attach_html").innerHTML = html;
</script>
</body>
</html>