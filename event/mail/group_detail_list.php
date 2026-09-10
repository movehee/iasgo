<?
##### 환경파일 include
include "config.php";


require_once($_header_file);
if(!isAdminLogined()){
	putMessageBack("관리자 전용 페이지 입니다.");
}
	require_once './conf/class.Page.php';
	require_once './conf/class.Block.php';

	$search_query = "";
	$page_per_block = 10;
	if($search_key) $search_query .= " and ${search_key} like '%${search_value}%'";
	if($c_index) $search_query .= " and c_code='${c_index}'";

	$search_url ="&search_key=${search_key}&search_value=${search_value}&c_index=${c_index}";

	####### 전체 게시물의 수
	$query="SELECT count(c_index) FROM tp_addgrinfo WHERE c_code is not null ${search_query} ";
	$totalRecord=$conn->getOne($query);
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());


	####### 페이징 처리
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();

	$query = "SELECT * FROM tp_addgrinfo WHERE c_code is not null ${search_query} order by c_index desc";
	$query.= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;

	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	$excel_query = "SELECT * FROM tp_addgrinfo WHERE c_code is not null ${search_query} order by c_index desc";

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
<br/>
<script type="text/javascript">
	$(function(){
		$('.insert_group').click(function(){
			window.open("insert_group.php","insert_pop","width=300, height=150");
		});

		$('#excel_detail_insert').click(function(){
			window.open("excel_detail_insert.php?c_index=<?=$c_index?>","insert_pop","width=900, height=400, scrollbars=no");
		});

		$('#self_detail_insert').click(function(){
			window.open("self_detail_insert.php?c_index=<?=$c_index?>","insert_pop","width=500, height=250, scrollbars=no");
		});

		$('#search_detail_insert').click(function(){
			window.open("mem_search.php?c_index=<?=$c_index?>","insert_pop","width=600, height=700, scrollbars=no");
		});
		
		$('#search_submit').click(function(){
			$('#searchForm').submit();
		});

	});
	function del_chk(c_index){
		if(confirm("삭제하시겠습니까?")){
			location.href="group_detail_delete.php?del_c_index="+c_index+"&page=<?=$page?><?=$search_url?>&gr_c_index=<?=$c_index?>";
			return true;
		}
	}

	function view_pop(sid){
		window.open("view.php?sid="+sid,"view_pop","width=800, height=300, scrollbars=yes");
	}

	function modify_pop(c_index){
		window.open("self_detail_insert.php?c_index="+c_index+"&mode=modify","insert_pop","width=500, height=250, scrollbars=no");
	}
</script>


<div class="searchArea">
	<form method="get" action="<?=$PHP_SELF?>" id="searchForm" name="searchForm">
	<input type="hidden" name="c_index" value="<?=$c_index?>">
	
	<div class="tblWrap">
		<table class="tblSearch" summary="메일그룹 검색 상세내역" cellspacing="0" cellpadding="0">
			<caption>메일그룹 검색</caption>
			<colgroup>
				<col style="width:20%;" />
				<col style="width:80%;" />
				<col />
			</colgroup>
			<tbody>
				<tr>
					<th scope="row"><label for="search_key">상세검색</label></th>
					<td>
						<select name="search_key" id="search_key" class="block">
							<option value="">선택</option>
							<? foreach($_SEARCH['field9'] as $tkey=>$tval):?>
								<?
									$sel = '';
									if($tkey == $search_key) $sel = 'selected';
								?>
								<option value="<?=$tkey?>" <?=$sel?>><?=$tval?></option>
							<? endforeach?>
						</select>
					<input class="block" title="상세 검색어 입력" type="text" name="search_value" id="search_value" value="<?=$search_value?>" /></td>
				</tr>
			</tbody>
		</table>
	</div>
		
	<div class="btnArea btn">
		<input class="btnDef" type="submit" value="검색" />
		<input class="btnGrey" type="button" value="검색 초기화" onclick="location.href='<?=$PHP_SELF?>?c_index=<?=$c_index?>'" />
	</div>	
	
	</form>
</div>

<div class="resultArea">

<div class="defTbl admin tm30">
	<table class="tblResult" summary="메일그룹 목록 상세내역" cellspacing="0" cellpadding="0">
		<caption>메일그룹 내 주소록</caption>
		<colgroup>
			<col style="width:8%;" />
			<col />
			<col />
			<!-- <col /> -->
			<col style="width:10%;" />
		</colgroup>
		<thead>
			<tr>
				<th scope="col">No</th>
				<th scope="col">이름</th>
				<th scope="col">이메일</th>
				<!-- <th scope="col">핸드폰</th> -->
				<th scope="col">관리</th>
			</tr>
		</thead>
		<tbody>
			<form method="post" action="mem_card.php" name="mem_frm" id="mem_frm">
			<? while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))):?>
			<tr>
				<td class="first"><?=$virtualRecordNo?></td>
				<td><?=$d['c_name']?></td>
				<td><?=$d['c_email']?></td>
				<!-- <td><?=$d['c_phone']?></td> -->
				<td>					
					<a href="#" title="팝업 - 새 창 열림" onclick="modify_pop('<?=$d['c_index']?>'); "><img src="/image/admin/modify.gif" alt="수정" /></a>&nbsp;
					<a href="#" title="팝업 - 새 창 열림" onclick="del_chk('<?=$d['c_index']?>')" ><img src="/image/admin/delete.gif" alt="삭제" /></a>
				</td>
			</tr>
			<? $virtualRecordNo--;endwhile?>
			</form>
		</tbody>
	</table>
	
	
	<div class="tp10">
		<div class="fr">
			<span class="btnAdmin medium gray"><button type="button" onclick="location.href='/admin/mail/group_list.php';">목록으로</button></span>
		</div>
		<div class="fl">
			<span class="btnAdmin medium green"><button type="button" id="excel_detail_insert">엑셀파일 등록</button></span>
			<span class="btnAdmin medium lightBlue"><button type="button" id="self_detail_insert">직접입력</button></span>
			<span class="btnAdmin medium navy"><button type="button" id="search_detail_insert">검색해서 입력</button></span>

		</div>
		<div class="clear"></div>
	</div>
	
	<?include $DOCUMENT_ROOT."admin/include.page.php"?>
	
</div>
<? require_once($_footer_file);?>