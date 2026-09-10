<?

##### 환경파일 include
include "config.php";

require_once($_header_file);

if(!isAdminLogined()){
	putMessageBack("관리자 전용 페이지 입니다.");
}
	
	
	if(!$search_query){
		$search_query = "";

		if($subject) $search_query .= " and subject like '%${subject}%'";
		if($send_name) $search_query .= " and send_name like '%${send_name}%'";
		if($s_signdate && $e_signdate){
			$s_signdate_unix = strtotime("${s_signdate} 23:59:59");
			$e_signdate_unix = strtotime("${e_signdate} 23:59:59");
			$search_query .= " and signdate >= ${s_signdate_unix} and signdate <= ${e_signdate_unix}";
		}

		if($s_senddate && $e_senddate){
			$s_senddate_unix = strtotime("${s_senddate} 00:00:00");
			$e_senddate_unix = strtotime("${e_senddate} 00:00:00");
			$search_query .= " and senddate >= ${s_senddate_unix} and senddate <= ${e_senddate_unix}";
		}
	}else{
		$search_query = str_replace("\\","",$search_query);
	}

	$search_url = "&subject=".$subject."&send_name=".$send_name."&s_signdate=".$s_signdate."&e_signdate=".$e_signdate."&s_senddate=".$s_senddate."&e_senddate=".$e_senddate;

	####### 전체 게시물의 수
	$query="select count(sid) from $mail_tbl where sid is not null ${search_query}";
//	echo $query;
	$totalRecord=$conn->getOne($query);
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());

	require_once './conf/class.Page.php';
	require_once './conf/class.Block.php';

	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();

	if($order && $sort){
		$order_query="ORDER BY $order $sort ";
	} else {
		$order_query='ORDER BY signdate desc';
	}

	$query = "select * from $mail_tbl where sid is not null ${search_query} ${order_query} LIMIT ".$pageNav->getFirstRecordInPage().", $num_per_page";
	//echo $query."<br/>";

	$result = $conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	# 가상번호 입력
	$virtualRecordNo=$pageNav->getVirtualRecordNoInPage($totalRecord);

	# 블럭단위 계산
	$blockNav = new Block("", $totalPage, $page_per_block);
	$totalBlock = $blockNav->getTotalBlock();
	$blockNav->setBlock($page);
	$block = $blockNav->getBlock();
	$firstPageInBlock = $blockNav->getFirstPageInBlock();
	$lastPageInBlock = $blockNav->getLastPageInBlock();
	if($block >= $totalBlock)
	   $lastPageInBlock = $totalPage;


	

?>
<script type="text/javascript">
//<![CDATA[

	$(function(){
		$('#del_chk').click(function(){
			if(confirm("해당 메일을 삭제 하시겠습니까?\n\n발송된 내역이 모두 삭제됩니다.")){
				return true;
			}
			return false;
		});
		
		$(window).load(function(){
			$('#search_submit').click(function(){
				$('#searchForm').submit();
			});
		});
		
	})

	function del_chk(url){
		if(confirm("해당 메일을 삭제 하시겠습니까?\n\n발송된 내역이 모두 삭제됩니다.")){
			location.href=url;
		}
	}
	function view_pop(sid){
		window.open("view.php?sid="+sid,"view_pop","width=900, height=700, left=10, top=10, scrollbars=yes");
	}

	function send_check(n, sid)
	{
		if( n == "1" ){
			var b = '#b'+sid;
			var w = '#bw'+sid;
		}
		else if( n == "2" ){
			var b = '#c'+sid;
			var w = '#cw'+sid;
		}
		
		$.ajax({
			type: "POST",
			 url: "./status_ajax.php",
			 data: "sid="+sid+"&n="+n,
			 beforeSend: function() {
			  $(b).hide();
			  $(w).show().fadeIn('fast');
			 },
			 success: function(msg){
			//       $('#pt').html("<pre>"+msg+"</pre>");
			   alert(msg);
			   location.reload();
			 },
			 error: function(xhr, status, error){
			 	alert(xhr.status+" : "+error);
			 },
			 complete: function(){
			 	$(b).show();
			 	$(w).hide();
			 }
		});
	}
//]]>
</script>


<div class="searchArea">
	<form id="searchForm" method="get" action="<?=$PHP_SELF?>">
	<div class="tblWrap">
		<table class="tblSearch" summary="메일발송 검색 조건 상세내역" cellspacing="0" cellpadding="0">
			<caption>메일발송 검색 조건</caption>
			<colgroup>
				<col style="width:11%;" />
				<col style="width:39%;" />
				<col style="width:11%;" />
				<col style="width:39%;" />
			</colgroup>
			<tbody>
			<tr>
				<th><label for="subject">메일제목</label></th>
				<td><input type="text" name="subject" id="subject" size="40" value="<?=$subject?>" class="block" /></td>
				<th><label for="send_name">발송자명</label></th>
				<td><input type="text" name="send_name" id="send_name" size="20" value="<?=$send_name?>" class="block" /></td>
			</tr>
			<tr>
				<th><label for="s_signdate">작성일</label></th>
				<td class="dateCell">
					<input type="text" name="s_signdate" id="s_signdate" title="작성일 검색기간 시작일" class="date fl" value="<?=$s_signdate?>" style="width:43%" readonly  />
					<span>~</span>
					<input type="text" name="e_signdate" id="s_signdate02" title="작성일 검색기간 종료일" class="date fr" value="<?=$e_signdate?>" style="width:43%" readonly />
				</td>
				<th><label for="s_senddate">발송일</label></th>
				<td class="dateCell">
					<input type="text" name="s_senddate" id="s_senddate" title="발송일 검색기간 시작일" value="" class="date fl" style="width:43%" readonly />
					<span>~</span>
					<input type="text" name="e_senddate" id="e_senddate02" title="발송일 검색기간 종료일" value="" class="date fr" style="width:43%" readonly />
				</td>
			</tr>
			</tbody>
		</table>
	</div>
		
	<div class="btnArea btn">
		<input class="btnDef" type="submit" value="검색" />
		<input class="btnGrey" type="button" value="검색 초기화" onclick="location.href='<?=$PHP_SELF?>'" />
	</div>	
	
	</form>
</div>

<p>
	<span class="fcRed">* 발송률 갱신중에는 시간이 소요될수 있으니 잠시 기다려주시기 바랍니다.
	<br />
	* 폼사용 발송 : 이메일을 다시 발송하고 싶을때 사용하세요
	</span>
</p>
<div class="resultArea">

	<div class="defTbl admin tm30">
		<table class="tblResult" summary="메일발송 목록" cellspacing="0" cellpadding="0">
			<caption>메일발송 목록</caption>
			<colgroup>
				<col style="width:5%;" />
				<col />
				<col style="width:10%;" />
				<col style="width:10%;" />
				<!-- <col style="width:7%;" /> -->
				<!-- <col style="width:5%;" /> -->
				<col style="width:5%;" />
				<col style="width:5%;" />
				<col style="width:5%;" />
				<col style="width:7%;" />
				<col style="width:7%;" />
				<col style="width:5%;" />
			</colgroup>
			<thead>
				<tr>
					<th scope="col" width="4%">No.</th>
					<th scope="col">제목</th>
					<th scope="col">발송자명</th>
					<th scope="col">Read/Send</th>
					<!-- <th scope="col">발송률<br/><font color="red">실패</font>/<font color="blue">성공</font></th> -->
					<!-- <th scope="col">발송률<br/>갱신</th> -->
					<th scope="col">발송횟수</th>
					<th scope="col">폼사용</th>
					<th scope="col">재발송</th>
					<th scope="col">작성일</th>
					<th scope="col">최종발송일</th>
					<th scope="col">관리</th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<? $i=1;while(is_array($d = $result->fetchRow(DB_FETCHMODE_ASSOC))):?>
				<?
					$mtotal = $conn->getOne("select count(*) from $mail_list_tbl where mail_sid=$d[sid] ");
					$msuccess = $conn->getOne("select count(*) from $mail_list_tbl where mail_sid = $d[sid] and code='250' "); //성공인코드만 검색
					$mfalse = $mtotal - $msuccess;
			//		$mnull = $conn->getOne("select count(*) from $mail_list_tbl where mail_sid = $d[sid] and code is not null "); //null이 아닌 코드는 발송시도까지 끝난 메일이다.
			
					$s100 = @round( $msuccess/$mtotal*100);
				?>
					<td class="first"><?=$virtualRecordNo?></td>
					<td ><a href="javascript:view_pop('<?=$d['sid']?>')"><?=$d['subject']?></a></td>
					<td><?=$d['send_name']?></td>
					<td><?=$d['total_read']?>/<?=$d['total_send']?> (<?=@round(($d['total_read']/$d['total_send'])*100)?>%)</td>
					<!-- <td>
						<font color="red"><?=$mfalse?></font>/<font color="blue"><?=$msuccess?>[<?=$s100?>%]</font>
					</td> -->
					<!-- <td>
						<span class="button white_4 small"><img src="/image/icon/btn_renew_s.gif" id="c<?=$d['sid']?>" onclick="javascript:send_check('2', '<?=$d['sid']?>');" <?=($mfalse==0?"style='display:none'":"")?> alt="갱신" /></span>
						 <img src="/image/icon/icon_wait.gif" id="cw<?=$d['sid']?>" style="display:none" width="14" height="14" />
			
					</td> -->
					<td><?=$d['send_count']?></td>
					<td>

						<span class="rBtnAdmin black small"><input type="button" value="폼사용" onclick="javascript:void window.open('re_postform.php?mode=repost&sid=<?=$d['sid']?>&search_query=<?=urlencode($search_query)?>','re_post','width=1000, height=800, scrollbars=yes');" /></span>
					</td>
					<td>
						<span class="rBtnAdmin black small">
						<input type="button" value="재발송" onclick="javascript:void window.open('re_postform.php?sid=<?=$d['sid']?>&search_query=<?=urlencode($search_query)?>','re_modify','width=1000, height=800, scrollbars=yes');" /></span>
					</td>
					<td><?=date('Y.m.d',$d['signdate'])?></td>
					<td><?=date('Y.m.d',$d['senddate'])?></td>
					<td>	
						<a href="#" onclick="javascript:void window.open('modifyform.php?sid=<?=$d['sid']?>','mail_modify','width=1000, height=800, scrollbars=yes');" ><img src="/image/admin/modify.gif" alt="수정"></a>
	
						<a href="#" onclick="del_chk('delete.php?sid=<?=$d['sid']?>&search_query=<?=urlencode($search_query)?>')" ><img src="/image/admin/delete.gif" alt="삭제"></a>
					</td>
				</tr>
				<? $virtualRecordNo--;$i++;endwhile?>
			</tbody>
		</table>
	</div>
	
			
	<div class="ar tp10">
		<?if($_SERVER['REMOTE_ADDR']=="218.235.94.220"){?>
			<span class="btnAdmin medium navy"><button type="button" onclick="javascript:void window.open('/admin/mail/index_new.php','mail_send','width=1000, height=800, scrollbars=yes');">등 록</button></span>
		<?}else{?>
			<span class="btnAdmin medium navy"><button type="button" onclick="javascript:void window.open('/admin/mail/','mail_send','width=1000, height=800, scrollbars=yes');">등 록</button></span>
		<?}?>
	</div>
	
	
	<?include $DOCUMENT_ROOT."admin/include.page.php"?>	
	
</div>
<?
require_once($_footer_file);
?>