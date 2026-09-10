<table cellspacing="0" class="cminput add">
	<tbody>
		<tr>
			<td class="i2">
				<div class="comm_write_wrap border-sub skin-bgcolor">
					<input type="hidden" name="file_name" value="<?=$_POST['file_name']?>" />
					<input type="hidden" name="this_sid" value="<?=$_POST['this_sid']?>" />
					<input type="hidden" name="comment_cid" value="<?=$_POST['cid']?>" />
					<input type="hidden" name="comment_csid" value="<?=$_POST['csid']?>" />
					<input type="hidden" name="comment_cname" value="<?=$_POST['cname']?>" />
					<input type="hidden" name="comment_number" value="<?=$_POST['_number']?>" />
					<input type="hidden" name="comment_rname" value="<?=$_POST['rname']?>" />
					<textarea id="comment_text" cols="50" rows="2" class="textarea m-tcol-c" maxlength="6000" style="overflow: hidden; line-height: 14px; height: 51px;" title="댓글입력"<?=$_POST['ctype']=='CC'?'-placeholder="'.$_POST['rname'].'님에게 작성하는 글입니다."':''?>><?=!empty($_POST['content'])?str_replace('<br>','',$_POST['content']):''?></textarea>
				</div>
			</td>
			<td class="i3">
				<div class="u_cbox_btn_upload <?=!empty($_POST['this_sid'])?'_modifyBtn':'_submitBtn'?>">
					<a href="#" class="u_cbox_txt_upload _submitCmt"><?=!empty($_POST['this_sid'])?'Edit':'Send'?></a>
				</div>
			</td>
		</tr>
	</tbody>
</table>