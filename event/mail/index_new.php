<? include "config.php";?>
<?
	/*
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	*/
	if($type=="chk_send"){
		if($mode!="search"){
			for($i=0;$i<count($chk_num);$i++){
			
				$data = explode("|||",$chk_num[$i]);
				$find_id = $data[0];
			
			
				if($i==0){
					$send_id = $send_id."'".$find_id."'";
				}else{
					$send_id = $send_id.",'".$find_id."'";
				}
			}
			$chk_query = "select count(*) from user_binfo where id in($send_id)";
			//echo $chk_query."<br/>";
			$chk_cnt=$conn->getOne($chk_query);
		}else{
			$search_query = "";

			if($year) $search_query .= " and year='${year}'";
			if($gubun) $search_query .= " and gubun='${gubun}'";
			if($pay_type) $search_query .= " and pay_type='${pay_type}'";
			if($status) $search_query .= " and status='${status}'";
			if($level) $search_query .= " and level='${level}'";
			if($keyword) $search_query .= " and ${keyfield} like '%${keyword}%'";

			$query = "SELECT distinct(id) FROM fee_tbl WHERE sid is not null ${search_query} order by pay_date desc, year asc";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			$i=0;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				if($i==0){
					$send_id = $send_id."'".$d['id']."'";
				}else{
					$send_id = $send_id.",'".$d['id']."'";
				}
			$i++;
			}

			$chk_cnt = $i;
		}
	}else if($type == "eregist_send"){
		for($i=0;$i<count($chk_num);$i++){
			if($i==0){
				$send_id = $send_id."'".$chk_num[$i]."'";
			}else{
				$send_id = $send_id.",'".$chk_num[$i]."'";
			}
		}
		$chk_query = "select count(*) from event_eregist_list where sid in($send_id)";
		$chk_cnt=$conn->getOne($chk_query);
	}

	$tem2_content = "<tr>";
	$tem2_content .= '<td style=\"padding:0 14px 14px;background-color:#f5f5f5;\">';
	$tem2_content .='<table style=\"width:670px;max-width:670px;margin: 0 auto;padding:0;border:0 none;border-collapse: collapse;border-spacing:0;\">';
	$tem2_content .='<tr>';
	$tem2_content .='<td style=\"padding:20px;background-color:#fff;\">';
	$tem2_content .='<table style=\"width:630px;max-width:630px;margin: 0 auto;padding:0;border:0 none;border-top:1px solid #5a5a5a;border-bottom:1px solid #5a5a5a;border-collapse: collapse;border-spacing:0;\">';
	$tem2_content .='<tr>';
	$tem2_content .='<td style=\"padding:20px;color:#090909;font-size:13px;font-family:Malgun Gothic, sans-serif;\">';
	$tem2_content .='<div style=\"padding-bottom:5px;\">';
	$tem2_content .='<span style=\"font-weight:bold;\">문서번호 :&nbsp;</span>';
	$tem2_content .='</div>';
	$tem2_content .='<div style=\"padding-bottom:5px;\">';
	$tem2_content .='<span style=\"font-weight:bold;\">시행일자 :&nbsp;</span>';
	$tem2_content .='</div>';
	$tem2_content .='<div style=\"padding-bottom:5px;\">';
	$tem2_content .='<span style=\"font-weight:bold;\">수&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;신 :&nbsp;</span>';
	$tem2_content .='</div>';
	$tem2_content .='<div>';
	$tem2_content .='<span style=\"font-weight:bold;\">제&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;목 :&nbsp; </span>';
	$tem2_content .='</div>';
	$tem2_content .='</td>';
	$tem2_content .='</tr>';
	$tem2_content .='</table>';
	$tem2_content .='</td>';
	$tem2_content .='</tr>';
	$tem2_content .='<tr>';
	$tem2_content .='<td style=\"padding:0 20px 50px;background-color:#fff;color:#090909;font-size:13px;font-family:Malgun Gothic, sans-serif;\">';
	$tem2_content .='내용들어갑니다.</td>';
	$tem2_content .='</tr>';
	$tem2_content .='</table>';
	$tem2_content .='</td>';
	$tem2_content .='</tr>';

	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<title>:::: 메일작성 ::::</title>
<?echo $_js_css;?>
<link type="text/css" rel="stylesheet" href="/admin/button_package/button.css" />
</head>
<body>
<script type="text/javascript" src="/func/tinymce_new/js/tinymce/tinymce.js"></script>
<script type="text/javascript">

tinymce.init({
	selector: 'textarea',
	theme: "modern", //테마종류 modern / mobile
	//mobile: { theme: 'mobile' },
	//height: 500,
	language: "ko_KR", //언어
	menubar:false, //메뉴바 나오는 부분
	plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount  imagetools contextmenu colorpicker textpattern help ',
	//toolbar: 'formatselect | bold italic underline strikethrough forecolor backcolor | fontselect fontsizeselect | link | table | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat codesample ',
	toolbar: 'formatselect | bold italic underline strikethrough forecolor backcolor | link | table | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat ',
	init_instance_callback: function (editor) {
		editor.on('change blur keyup keydown keypress', function (e) {
			$('.word_chk').trigger("change");
		});
	},
	setup: function(editor) {
		editor.addButton('custom_image', {
			title: '이미지삽입',
			icon: 'image',
			onclick: function() {
				window.open("POPUP_URL","tinymcePop","width=400,height=350");
			}
		});
	}, 
});


</script>
<script type="text/javascript">


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

			window.open('preview.php?temp_val='+temp_val+'&group_val='+group_val+'&btn_type='+btn_type+'&btn_url='+encodeURIComponent(document.getElementById("btn_url").value)+'&subject='+encodeURIComponent(f.subject.value),'preview', 'top=0,left=0,width=900,height=800,scrollbars=yes,status=no');
			return false;


		});

		$('.mail_template').on("click",function(){
			var content = "<?=$tem2_content?>";
			if($(this).val()==2){
				tinyMCE.activeEditor.setContent(content);
			}else{
				tinyMCE.activeEditor.setContent("");
			}
		});
	});

/*
  function file_add(index, sel) {
    f = document.form01;
    len = document.all.userfile_id.length;
    if(index == 'A'){
      for(i=0;i<len;i++){
        if(document.all.userfile_id[i].style.display == 'none'){
          document.all.userfile_id[i].style.display = '';
          document.getElementById("userfile_area"+i).style.display = '';
          document.all.del_id[i].style.display = '';
          i = len;
        }//
      }
    }else if(index == 'D'){
      //document.all.userfile_id[sel].value = 'none';
      document.all.userfile_id[sel].select();
      document.execCommand('Delete');

      document.all.userfile_id[sel].style.display = 'none';
      document.getElementById("userfile_area"+i).style.display = 'none';
      document.all.del_id[sel].style.display = 'none';
    }
  }
*/
	function fn_replaceAll(str1, str2, str3){ 
		var oridata = str1; 
		while(oridata.indexOf(str2) > -1){ 
				oridata = oridata.replace(str2,str3); 
		} 
		return oridata; 
	}
  	
  function file_add(index, sel) {
    f = document.form01;
    len = document.all.userfile_id.length;
    if(index == 'A'){
      for(i=1;i<=10;i++){

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

  function form_chk() {
  }

  function form01_search(con) {
    window.open('g_search_member.php?con=' + con,'g_search_member','top=0, left=0, scrollbars=yes, resizable=yes, width=800, status=yes, height=650');
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
		$('.member_gubun_chk_ar').prop('disabled',false);
		$('.member_gubun_chk_ar').prop('checked',false);
		$('.member_gubun_chk').prop('checked',false);
	});

	$(".member_gubun_chk").click(function(){
		if($(this).val() == 'all' && $(this).prop('checked')){
			$('.member_gubun_chk_ar').prop('checked',false);
			$('.member_gubun_chk_ar').prop('disabled',true);
		}else{
			$('.member_gubun_chk_ar').prop('disabled',false);
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
<div style="width:95%;margin:0 auto;">
<br/>
<form name="form01" id="form01"  method="post" action="mail_post.php" onsubmit="return form_chk();" ENCTYPE="multipart/form-data">
<input type="hidden" name="mode" value="imsi">
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" >
  <tr>
    <td>
    <table cellpadding="0" cellspacing="0" class="regist_tbl" width="100%" >
      <tr height="30">
        <td align="left"    width="15%" class="th">제목</td>
        <td class="td" width="85%">
          <input type="text" name="subject" id="subject" maxlength="120" size="50" value="">
        </td>
      </tr>

      <tr height="30"> 
        <td align="left" class="th">보낸 사람</td>
        <td class="td" >
          <input type="text" name="from_name" size="50" value="<?=$society_name?>" maxlength="120">
        </td>
      </tr>

      <tr height="30">
        <td align="left" class="th">보낸사람 이메일</td>
        <td class="td" >
          <input type="text" name="from_email" size="50" value="<?=$adminEmail?>" maxlength="120">
        </td>
      </tr>

      <tr height="30">
        <td align="left" class="th">받는사람</td>
        <td class="td">
		
		<?if($type=="chk_send"){?>
		<input type="radio" name="to_name_group" value="5" checked>선택회원발송(<?=$chk_cnt?>명)<br>
		<?=str_replace("'"," ",$send_id)?>
		<?}else if($type == "eregist_send"){?>		
		<input type="radio" name="to_name_group" value="6" checked>선택회원발송(<?=$chk_cnt?>명)<br>
		<?}else{?>
		<?
			$i=1;
			foreach($_MAIL['to_name_group'] as $tkey => $tval){
		?>
			<input type="radio" id="name_<?=$tkey?>"  value="<?=$tkey?>" name="to_name_group" class="group_choice"/>
			<label  for="name_<?=$tkey?>"><?=$tval?></label>
		<?
				if($i == 5) echo "<br/>";
				$i++;
			}
		?>
		<?}?>
		<input type="hidden" name="send_id" id="send_id" value="<?=$send_id?>">
        </td>
      </tr>
		<tr class="_tr1" style="display:none;">
			<td class="th">발송대상</td>
			<td class="td">
				<input type="checkbox" value="all" name="member_gubun1[]" id="member_all" class="member_gubun_chk"/>
				<label for="member_all">전체</label>
				<?
					$i=1;
					foreach($_CONFIG['member_level'] as $tkey => $tval){
				?>
					<input type="checkbox" value="<?=$tkey?>" name="member_gubun1[]" id="member_<?=$tkey?>" class="member_gubun_chk_ar" />
					<label for="member_<?=$tkey?>"><?=$tval?></label>
				<?
						if($i == 5) break;
						$i++;
					}
				?>
			</td>
		</tr>
		<tr class="_tr3" style="display:none;">
			<td class="th">발송대상</td>
			<td class="td">
				<input type="checkbox" value="all" name="member_gubun3[]" id="addr_all" <?=$m['member_gubun'] == 'all'?'checked':''?> class="member_gubun_chk"/>
				<label for="addr_all">전체</label>
				<?
					$query = "select * from tp_addgrcode order by c_index desc";
					$result=$conn->query($query);
					if(DB::isError($result)) die($result->getMessage());
				?>
				<? $i=1;while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))):?>
					<input type="checkbox" value="<?=$d['c_index']?>" name="member_gubun3[]" id="addr_<?=$d['c_index']?>" class="member_gubun_chk_ar"/>
					<label for="addr_<?=$d['c_index']?>"><?=$d['c_grname']?></label>
					<? if($i % 7 == 0) echo "<br/>";?>
				<? $i++;endwhile?>
			</td>
		</tr>
		<tr class="_tr4" style="display:none;">
			<td class="th">테스트 발송대상</td>
			<td class="td"><input type="text" name="testing_mail" id="testing_mail" size="40"/></td>
		</tr>
		<tr class="_tr9" style="display:none;">
			<td class="th">발송대상 입력</td>
			<td class="td"><input type="text" name="self_mail" id="self_mail" size="40"/>Ex) 콤마(,)구분지어 입력하시면 됩니다.</td>
		</tr>
	  <tr>
	  	<td class="th">버튼 사용</td>
	  	<td class="td" >
			<?
				$i=1;
				foreach($btn_arr as $tkey => $tval){
			?>
				<input type="radio" value="<?=$tkey?>" id="btn_<?=$tkey?>" name="btn_type" class="btn_type" />
				<label for="btn_<?=$tkey?>"><?=$tval?></label>
			<?
				}
			?>	<br/>
			<div style="display:none;padding-top:5px;padding-bottom:5px;" id="btn_url_area">URL : http://<input type="text" name="btn_url" id="btn_url" size="60"/></div>
	  	</td>
	  </tr>

      <tr id = "file_tr" height="30" style="display:<?=$view?>">
        <td align="left" class="th">파일첨부<br>(10개까지 등록)</td>
        <td class="td" >

<?
for($i=1;$i<=10;$i++){
  $view = $i ==1 ? '' : 'none';
?>
		<div style="display:<?=$view?>" id="userfile_area<?=$i?>">
          <input type="file" name="userfile<?=$i?>" id="userfile_id" size="40" value="" style="display:<?=$view?>; border:0 none;">
          <?if($i==1){?>
		  <span class="btnAdmin samll black"><button type="button" onclick="file_add('A', 0);">추가</button></span>
          <?}?>
		  <span class="btnAdmin samll gray"><button type="button" onclick="file_add('D', <?=$i?>);" id="del_id<?=$i?>" style="display:none;">삭제</button></span>
		</div>
<?
}
?>
        </td>
      </tr>

      <tr height="30">
        <td align="left"    class="th ">메일폼</td>
        <td class="td tp10" style="position:relative;">
			<?
				foreach($template_arr as $tkey => $tval){
			?>
					<input type="radio" value="<?=$tkey?>" name="mail_template" class="mail_template"/>
					<? if($tkey == '8'):?>
						<?=$tval?>
					<? else:?>
						<img src="/image/mail/mail<?=$tkey?>.png" alt="" height="70" style="cursor:pointer;z-index:1000;" onmousemove="img_view('<?=$tkey?>')" onmouseout="img_hide()"/>
					<? endif?>

					<? if($tkey != '8'):?>
					<div style="position:absolute;display:none;top:50;z-index:1000;" id="big_img_<?=$tkey?>" class="big_img"><img src="/image/mail/mail<?=$tkey?>.png" alt="" width="300" style="border:1px solid #cccccc;"/></div>
					<? endif?>
			<?
				}
			?>
        </td>
      </tr>
      <tr height="30">
        <td align="center" colspan="2">
			<textarea name="b_body" id="b_body" style="height:500px;width:918px;"></textarea>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr height="10"><td></td></tr>
  <tr height="30" align="center">
    <td>
    	<div style="display:none;" id="wait_icon"><img src="/admin/mail/icon/icon_wait.gif" alt="" /></div>
		<span class="btnAdmin medium blue"><button type="submit" >미리보기</button></span>
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
</html>chown neurosurgery:neurosurgery