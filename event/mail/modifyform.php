<? include "config.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=100"/>
<title>:::: 메일수정 ::::</title>
<?=$_js_css?>
<link type="text/css" rel="stylesheet" href="/admin/button_package/button.css" />
</head>
<body>
<script type="text/javascript" src="/func/tinymce/tiny_mce.js"></script>
<script type="text/javascript">

tinyMCE.init({
	// General options
	mode : "textareas",
	language : "ko",
	theme : "advanced",
	plugins : "phpimage,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",

	// IE bug Fix.
	forced_root_block : false,

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,phpimage,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false,

	theme_advanced_disable: "image,advimage",

	// Example content CSS (should be your site CSS)
	content_css : "css/content.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",

	// P -> Br
	force_br_newlines: true,
	force_p_newlines: false,

	// Replace values for the template plugin
	template_replace_values : {
		username : "Some User",
		staffid : "991234"
	}
});

</script>
<SCRIPT LANGUAGE="JavaScript">
	$(window).load(function(){
	
		

		$('#form01').submit(function(){
		    f = document.form01;
		    if(!f.subject.value){
		      alert('제목을 입력하세요!!');
		      f.subject.focus();
		      return false;
		    }
			
			if(document.getElementById("send_id").value==""){

				var group_count = 0;
				var group_val = "";
				for (i=0;i< f.to_name_group.length;i++)
				{
					if (f.to_name_group[i].checked == true)
					{
						group_count++;
						group_val = f.to_name_group[i].value;
			
					}
				}
			
				if(group_count == 0){
				  alert('받는 사람을 선택하세요!!');
				  f.to_name_group[0].focus();
				  return false;
				}
				
				
				if(document.getElementsByName("to_name_group")[2].checked){
					if(!document.getElementById("testing_mail").value){
						alert("테스트 발송 대상을 입력하세요");
						document.getElementById("testing_mail").focus();
						return false;
					}
				}else if(document.getElementsByName("to_name_group")[3].checked){
					if(!document.getElementById("self_mail").value){
						alert("발송 대상을 입력하세요");
						document.getElementById("self_mail").focus();
						return false;
					}
				}else{
					var loop_num=0;
										
					//추가					
					var id =  $(':radio[name="to_name_group"]:checked').val();

					for(i=0;i<document.getElementsByName("member_gubun"+id+"[]").length;i++){
						if(document.getElementsByName("member_gubun"+id+"[]")[i].checked){
							loop_num++;
						}
					}
					
					
					if(loop_num == 0){
						alert("발송 대상을 선택하세요");
						return false;
					}
				}
			}
			
			var loop_num=0;
			var btn_type = "";
			
			for(i=0;i<document.getElementsByName("btn_type").length;i++){
				if(document.getElementsByName("btn_type")[i].checked){
					loop_num++;
					btn_type = document.getElementsByName("btn_type")[i].value;
				}	
			}
			
			if(loop_num == 0){
				alert("버튼 사용을 선택하세요");
				return false;
			}	
			
			if(document.getElementsByName("btn_type")[0].checked || document.getElementsByName("btn_type")[1].checked){
				if(!document.getElementById("btn_url").value){
					alert("URL을 입력하세요");
					return false;
				}
			}
			
			var template_count = 0;
			var temp_val = "";
			for (i=0;i< f.mail_template.length;i++)
			{
				if (f.mail_template[i].checked == true)
				{
					template_count++;
					temp_val = f.mail_template[i].value;
				}
			}
			
			if(template_count == 0){
		      alert('메일폼을 선택하세요!!');
		      f.mail_template[0].focus();
		      return false;
			}
			var b_body = tinyMCE.get('b_body').getContent();
			/* 특수기호 때문에 추가.*/
			$("#b_body").val(fn_replaceAll($("#b_body").val(), unescape("%uFEFF"), "" ));

			//window.open('preview.php?temp_val='+temp_val+'&group_val='+group_val+'&btn_type='+btn_type+'&btn_url='+encodeURIComponent(document.getElementById("btn_url").value)+'&subject='+encodeURIComponent(f.subject.value),'preview', 'top=0,left=0,width=900,height=800,scrollbars=yes,status=no');
			return false;
		
			
		});
	});

  function file_add(index, sel) {
    f = document.form01;
    len = document.all.userfile_id.length;
    if(index == 'A'){
      for(i=sel;i<=10;i++){

        if(document.getElementsByName("userfile"+i)[0].style.display == 'none'){
          document.getElementsByName("userfile"+i)[0].style.display = '';
          document.getElementById("userfile_area"+i).style.display = '';          
          document.getElementById("del_id"+i).style.display = '';
          i = 10;
        }
      }
    }else if(index == 'D'){
      //document.all.userfile_id[sel].value = 'none';
      //document.all.userfile_id[sel].select();
      document.execCommand('Delete');

      document.getElementsByName("userfile"+sel)[0].style.display = 'none';
      document.getElementById("userfile_area"+sel).style.display = 'none';          
      document.getElementById("del_id"+sel).style.display = 'none';
    }
  }

	function mail_check(){
<?
	if($success == "ok"){
		echo "alert(\"성공적으로 메일을 발송하였습니다!\");";
	}
	else if($success == "failed"){
		echo "alert(\"메일발송에 실패하였습니다!\\n관리자에게 문의하시기 바랍니다.\");";
	}
?>
	}

  function form01_chk(con) {
    window.open('group_sel.php?con=' + con,'group_sel','top=0, left=0, scrollbars=yes, resizable=yes, width=500 height=650');
  }

  function form01_search(con) {
    window.open('g_search_member.php?con=' + con,'g_search_member','top=0, left=0, scrollbars=yes, resizable=yes, width=800, status=yes, height=650');
  }

  function form_chk() {
  }

  function dayChk_fun() {
    f = document.form01;
    if(f.day_chk.checked == true){
      f.yearv.disabled = false;
      f.monthv.disabled = false;
      f.dayv.disabled = false;
      f.hhv.disabled = false;
      f.mmv.disabled = false;
      f.hhv_e.disabled = false;
      f.ddv_e.disabled = false;
    }else{
      f.yearv.disabled = true;
      f.monthv.disabled = true;
      f.dayv.disabled = true;
      f.hhv.disabled = true;
      f.mmv.disabled = true;
      f.hhv_e.disabled = true;
      f.ddv_e.disabled = true;
    }
  }
  
  function img_view(num){
  	document.getElementById("big_img_"+num).style.left = parseInt(num)*80+"px";  
  	document.getElementById("big_img_"+num).style.display = "";
  }
  
  function img_hide(){
  	$('.big_img').hide();
  }

  $(function(){
	$('.group_choice').click(function(){
		$('._tr1').hide();	
		$('._tr2').hide();	
		$('._tr3').hide();	
		$('._tr4').hide();
		$('._tr9').hide();
		$('._tr'+$(this).val()).show();
		$('.member_gubun_chk_ar').attr('disabled',false);
		$('.member_gubun_chk_ar').attr('checked',false);		
		$('.member_gubun_chk').attr('checked',false);				
	});
	
	$(".member_gubun_chk").click(function(){
		if($(this).val() == 'all' && $(this).attr('checked')){
			$('.member_gubun_chk_ar').attr('checked',false);		
			$('.member_gubun_chk_ar').attr('disabled',true);
		}else{
			$('.member_gubun_chk_ar').attr('disabled',false);		
		}
	});
	
	$('.btn_type').click(function(){
		if($(this).val() == '1' || $(this).val() == '2'){
			$('#btn_url_area').show();
		}else{
			$('#btn_url_area').hide();		
		}
	});
  });
  

</SCRIPT>
<div>

<?
	$query = "select * from $mail_tbl where sid='${_GET['sid']}'";
	$result = $conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	$m = $result->fetchRow(DB_FETCHMODE_ASSOC);	
?>
<div style="width:95%;margin:0 auto;">
<br/>
<form name="form01" id="form01" method="post" action="modify.php?sid=<?=$_GET['sid']?>&search_query=<?=urlencode($search_query)?>" onsubmit="return form_chk();" ENCTYPE="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" >
  <tr>
    <td>
    <table cellpadding="0" cellspacing="0" class="regist_tbl" width="100%" >
      <tr height="30">
        <td align="left"    width="15%" class="th">제목</td>
        <td class="td" width="85%">&nbsp;
          <input type="text" name="subject" maxlength="120" size="50" value="<?=$m['subject']?>">
        </td>
      </tr>

      <tr height="30">
        <td align="left"    class="th">보낸 사람</td>
        <td class="td" >&nbsp;
          <input type="text" name="from_name" size="50" value="<?=$m['send_name']?>" maxlength="120">
        </td>
      </tr>

      <tr height="30">
        <td align="left" class="th">보낸사람 이메일</td>
        <td class="td" >&nbsp;
          <input type="text" name="from_email" size="50" value="<?=$m['send_email']?>" maxlength="120">
        </td>
      </tr>

      <tr height="30">
        <td align="left" class="th">받는사람</td>
        <td class="td" >
		<?
			if($m['to_name_group']=="5"){
				$l_query = "select distinct(id) from mail_list_tbl where mail_sid='$m[sid]'";
				$lresult=$conn->query($l_query);
				if(DB::isError($lresult)) die($lresult->getMessage());
				$i=0;
				while(is_array($l=$lresult->fetchRow(DB_FETCHMODE_ASSOC))){
					if($i==0){
						$m_list = $l['id'];
						$send_id = "'".$l['id']."'";
					}else{
						$m_list = $m_list.", ".$l['id'];
						$send_id = $send_id.",'".$l['id']."'";
					}
					
				$i++;	
				}
		?>
		<input type="radio" name="to_name_group" value="5" checked>선택회원발송(<?=$i?>명)<br><?=$m_list?>
		<?}else{?>
		<?
			$i=1;
			foreach($_MAIL['to_name_group'] as $tkey => $tval){
				$chk = '';
				if($tkey == $m['to_name_group']) $chk='checked';
		?>
			<input type="radio" value="<?=$tkey?>" name="to_name_group" class="group_choice" <?=$chk?>/> <?=$tval?>&nbsp;&nbsp;&nbsp;
		<?
				if($i == 5) echo "<br/>";
				$i++;
			}
		?>
		<?}?>
		<input type="hidden" name="send_id" id="send_id" value="<?=$send_id?>">
        </td>
      </tr>
      	<?
      		$member_gubun = explode(',',$m['member_gubun']);
      	?>
		<tr class="_tr1" style="display:<?=$m['to_name_group']=='1'?'':'none'?>;">
			<td class="th">발송대상</td>
			<td class="td">
				<input type="checkbox" value="all" name="member_gubun1[]" class="member_gubun_chk" <?=$m['member_gubun'] == 'all' && $m['to_name_group'] == '1'?'checked':''?>/> 전체&nbsp;&nbsp;&nbsp;
				<?
					$i=1;
					foreach($_CONFIG['member_level'] as $tkey => $tval){
						$chk = '';
						if(in_array($tkey,$member_gubun)){
							$chk = 'checked';	
						} 
				?>
					<input type="checkbox" value="<?=$tkey?>" name="member_gubun1[]" class="member_gubun_chk_ar" <?=$chk?>/> <?=$tval?>&nbsp;&nbsp;&nbsp;
				<?
						if($i == 5) break;
						$i++;
					}
				?>				
			</td>
		</tr>
		<tr class="_tr3" style="display:<?=$m['to_name_group']=='3'?'':'none'?>;">
			<td class="th">발송대상</td>
			<td class="td">
				<input type="checkbox" value="all" name="member_gubun3[]" class="member_gubun_chk" <?=$m['member_gubun'] == 'all' && $m['to_name_group'] == '3'?'checked':''?>/> 전체&nbsp;&nbsp;&nbsp;
				<?
					$query = "select * from tp_addgrcode order by c_index desc";
					$result=$conn->query($query);
					if(DB::isError($result)) die($result->getMessage());					
				?>					
				<? $i=1;while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))):?>
				<?
					$chk = '';
					if($d['c_index'] == $member_gubun[$i-1]) $chk = 'checked';
				?>				
					<input type="checkbox" value="<?=$d['c_index']?>" name="member_gubun3[]" <?=$chk?> class="member_gubun_chk_ar"/>
					<?=$d['c_grname']?>
					<? if($i % 7 == 0) echo "<br/>";?>
				<? $i++;endwhile?>
			</td>
		</tr>			
		<tr class="_tr4" style="display:<?=$m['to_name_group']=='4'?'':'none'?>;">
			<td class="th">테스트 발송대상</td>
			<td class="td"><input type="text" name="testing_mail" id="testing_mail" value="<?=$m['testing_mail']?>" size="40"/></td>
		</tr>
		<tr class="_tr9" style="display:<?=$m['to_name_group']=='9'?'':'none'?>;">
			<td class="th">발송대상 입력</td>
			<td class="td"><input type="text" name="self_mail" id="self_mail" value="<?=$m['self_mail']?>" size="40"/></td>
		</tr>
	  <tr>
	  	<td class="th">버튼 사용</td>
	  	<td class="td">
			<?
				$i=1;
				foreach($btn_arr as $tkey => $tval){
					$chk = '';
					if($tkey == $m['btn_type']) $chk='checked';				
			?>
				<input type="radio" value="<?=$tkey?>" name="btn_type" class="btn_type" <?=$chk?>/> <?=$tval?>&nbsp;&nbsp;&nbsp;
			<?
				}
			?>		
			<div style="display:<?=$m['btn_type'] != 'N'?'':'none'?>;" id="btn_url_area">URL : http://<input type="text" name="btn_url" id="btn_url" value="<?=$m['btn_link']?>" size="60"/></div>
	  	</td>
	  </tr>
	  
      <tr id = "file_tr" height="30" style="display:<?=$view?>">
        <td align="left" class="th">파일첨부<br>(10개까지 등록)</td>
        <td class="td" >
		<?
			$f_sum = 1;
			for($i=1;$i<=10;$i++){
				if($m['file_name'.$i]){
					echo "첨부된 파일 : ".$m['file_name'.$i]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;삭제 <input type='checkbox' name='file_del".$i."' value='Y' /> <br/>";
					echo "<input type='hidden' value='".$m['file_name'.$i]."' name='original_name".$i."' />";
					echo "<input type='hidden' value='".$m['read_name'.$i]."' name='read_name".$i."' />";
					$f_sum++;
				}
			}
			
			//echo $f_sum;
		?>         
<?
for($i=$f_sum;$i<=10;$i++){
  $view = $i ==$f_sum ? '' : 'none';
?>
		<div style="display:<?=$view?>" id="userfile_area<?=$i?>">
          <input type="file" name="userfile<?=$i?>" id="userfile_id" size="40" value="" style="display:<?=$view?>">
          <? if($i==$f_sum){?>
		  <span class="btnAdmin samll black"><button type="button" onclick="file_add('A', '<?=$f_sum?>');">추가</button></span>
          <? }?>
		  <span class="btnAdmin samll gray"><button type="button" onclick="file_add('D', <?=$i?>);" id="del_id<?=$i?>" style="display:none;">삭제</button></span>
		</div>
<?	
}
?>
        </td>
      </tr>

      <tr height="30">
        <td align="left"    class="th">메일폼</td>
        <td class="td" style="position:relative;">&nbsp;
			<?
				foreach($template_arr as $tkey => $tval){
					$chk = '';
					if($tkey == $m['template']) $chk='checked';						
			?>
					<input type="radio" value="<?=$tkey?>" name="mail_template" class="mail_template" <?=$chk?>/> 
					<? if($tkey == '8'):?>
					<?=$tval?>
					<? else:?>					
					<img src="/image/mail/mail<?=$tkey?>.png" alt="" height="70" style="cursor:pointer;" onmousemove="img_view('<?=$tkey?>')" onmouseout="img_hide()"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<? endif?>
					
					<? if($tkey != '8'):?>
					<div style="position:absolute;display:none;top:50;" id="big_img_<?=$tkey?>" class="big_img"><img src="/image/mail/mail<?=$tkey?>.png" alt="" width="300" style="border:1px solid #cccccc;"/></div>
					<? endif?>
										
			<?
				}
			?>
        </td>
      </tr>
      <tr height="30">
        <td align="center" colspan="2">

			<textarea name="b_body" id="b_body" style="height:500px;width:918px;"><?=$m['content']?></textarea>		
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr height="10"><td></td></tr>
  <tr height="30" align="center">
    <td>
		<div style="display:none;" id="wait_icon"><img src="/image/icon/icon_wait.gif" alt="" /></div>

		<span class="btnAdmin medium blue"><button type="submit" >수정</button></span>
		<span class="btnAdmin medium gray"><button type="button" onclick="self.close();">취소</button></span>
    </td>
  </tr>
  <tr height="20"><td></td></tr>
</table>
</form>
</div>
<?
$conn->disconnect();
?>
</body>
</html>