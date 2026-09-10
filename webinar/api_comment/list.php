<?

##검색 조건
$where = " and type='C' and page_name='".$_COMMENTCNF['page_name']."'";

if(!empty($_GET['_sid'])){
	$where .= " and sid='".$_GET['_sid']."'";
}

if(!empty($_COMMENTCNF['_number'])){
	$where .= " and number='".$_COMMENTCNF['_number']."'";
}


$query = "select * from comment_tbl where 1 ".$where;
$result = $conn->query($query);
if(DB::isError($result)) {
   die($result->getMessage());
}

?>

<div id="COMMENT_LIST_GROUP">
	<input type="hidden" name="user_cid" value="<?=$_COMMENTCNF['cid']?>">
	<input type="hidden" name="user_cname" value="<?=$_COMMENTCNF['cname']?>">
	<input type="hidden" name="user_file_name" value="<?=$_COMMENTCNF['page_name']?>">
	<input type="hidden" name="poster_sid" value="<?=$_COMMENTCNF['poster_sid']?>">
	<?
	##코멘트 넘버가 필요한경우 넣어주세요.
	?>
	<input type="hidden" name="comment_number" value="<?=$_COMMENTCNF['_number']?>">
	<p class="total"><b>Comments <span class="comment_cnt">(<?=$result->numRows()?>)</span></b></p>
	<div style="overflow-y: scroll; max-height: 400px;  ">

		<ul>

			<!-- <li></li> -->

			
			<?
			while(is_array($row=$result->fetchRow(DB_FETCHMODE_ASSOC))){	

				echo '<li class="li_'.$row['sid'].'"" csid="'.$row['sid'].'" this_sid="'.$row['sid'].'" rname="">';
				$row['content'] = url_auto_link($row['content']);
				?>
				<div class="comm_cont">
					<p>
						<b class="name"><?=$row['name']?></b>
						<span class="sgindate"><?=date('Y. m. d. H:i',$row['signdate'])?></span>
						
						<?if($_COMMENTCNF['admin'] || (($_COOKIE['wmember_qna_auth']) && $_COMMENTCNF['page_name'] == $_COOKIE['wmember_qna_auth'])) {?>
						<span class="btn_recomment">Reply</span>
						<?}?>

						<?if(($_COMMENTCNF['admin'] || $_COMMENTCNF['cid']==$row['id']) && !empty($_COMMENTCNF['cid'])){?>
							<span class="btn_modify">Edit</span>
							<span class="btn_delete">Delete</span>
						<?}?>
					</p>
					<div>
						<span class="comment_content"><?=nl2br($row['content'])?></span>
					</div>
					<div class="comment_box"></div>
				</div>
				<?
				echo "</li>";

				##서브 검색 조건
				$cwhere = " and type='CC' and page_name='".$_COMMENTCNF['page_name']."'";
				$cwhere .= " and csid='".$row['sid']."'";
				
				$cquery = "select * from comment_tbl where 1 ".$cwhere;
				$cresult = $conn->query($cquery);
				if(DB::isError($cresult)) {
				   die($cresult->getMessage());
				}
				
				while(is_array($rows=$cresult->fetchRow(DB_FETCHMODE_ASSOC))){

					echo '<li class="CC li_'.$rows['csid'].'" csid="'.$rows['csid'].'" this_sid="'.$rows['sid'].'" rname="'.$rows['name'].'">';
					$rows['content'] = url_auto_link($rows['content']);
					?>
					<div class="comm_cont">
						<p>
							<b class="name"><?=$rows['name']?></b>
							<span class="sgindate"><?=date('Y. m. d. H:i',$rows['signdate'])?></span>
							
							<?if($_COMMENTCNF['admin'] || (($_COOKIE['wmember_qna_auth']) && $_COMMENTCNF['page_name'] == $_COOKIE['wmember_qna_auth'])) {?>
							<span class="btn_recomment">Reply</span>
							<?}?>

							<?if($_COMMENTCNF['cid']==$rows['id'] && !empty($_COMMENTCNF['cid'])){?>
								<span class="btn_modify">Edit</span>
								<span class="btn_delete">Delete</span>
							<?}?>
						</p>
						<div>
							<?=!empty($rows['rname'])?'<span class="rname">'.$rows['rname'].'</span>':''?>
							<span class="comment_content"><?=nl2br($rows['content'])?></span>
						</div>
						<div class="comment_box"></div>
					</div>
					<?
					echo '</li>';
				}
			}
			?>
		</ul>
	</div>

	
	
	<table cellspacing="0" class="cminput">
		<tbody>
			<tr>
				<td class="i2">
					<div class="comm_write_wrap border-sub skin-bgcolor">
						<input type="hidden" name="file_name" value="<?=$_COMMENTCNF['page_name']?>" />
						<input type="hidden" name="comment_cid" value="<?=$_COMMENTCNF['cid']?>" />
						<input type="hidden" name="comment_csid" value="" />
						<input type="hidden" name="comment_cname" value="<?=$_COMMENTCNF['cname']?>" />
						<input type="hidden" name="comment_number" value="<?=$_COMMENTCNF['_number']?>" />
						<input type="hidden" name="poster_sid" value="<?=$_COMMENTCNF['poster_sid']?>" />
						<input type="hidden" name="comment_rname" value="" />
						<textarea id="comment_text" cols="50" rows="2" class="textarea m-tcol-c" maxlength="6000" style="overflow: hidden; line-height: 14px; height: 51px;" -title="댓글입력" placeholder="<?=$_COMMENTCNF['place_holder']?>"></textarea>
					</div>
				</td>
				<td class="i3">
					
					<div class="u_cbox_btn_upload _submitBtn">
						<a href="#" class="u_cbox_txt_upload _submitCmt">Send</a>
					</div>
				</td>
			</tr>
		</tbody>
	</table>


</div>

