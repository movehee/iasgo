<?include "./../header.php";?>
<script>
jQuery(function($) {
	$("#sortable").sortable({
		axis: "y",
		containment: "parent",
		update: function (event, ui) {
			var order = $(this).sortable('toArray', {
				attribute: 'data-order'
			});

			//data-order, list_order 재정의
			$(this).find('li.sort_li').each(function(i){
				$(this).attr('data-order',i+1);
				$(this).find('input[name="list_order[]"]').val(i+1);
			});

			//리스트 순서 재정의 후 DB저장
			var $form = $(this).parents('form');
			$.post("/app/admin/session_program/daily_api/ajax/order_save.php", $form.serialize(), function(r) {
				if(r._return){
					alert('순서가 변경되었습니다.');
					location.reload();
				}else{
					alert('순서 변경에 실패하였습니다.');
					return false;
				}
			}, 'json');
		}
	});
});
</script>
<?

$num_per_page = 100;
if(!$page) $page = 0;
$query="SELECT * FROM feedback_tbl where code='".$_COOKIE['code']."' and  del='N'";

$totalRecord = $conn->getOne(str_replace("*","COUNT(*)",$query));

$query.=" order by orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;

$result=$conn->query($query);

$max = $conn->getOne("select max(orderby) from feedback_tbl where code='".$_COOKIE['code']."' and del='N'");

?>
<div id="container">
	
		<h2>Feedback 관리</h2>
		<div class="contents member">
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a href="" onclick="javascript:add()" class="btnDef">Feedback 등록</a></p>

			<ul id='sortable' style="width:300px">
			<?while(is_array($col=$result->fetchRow(DB_FETCHMODE_ASSOC))){?>
			<?if($col['type']==10){?>
				<li class="feedback_txt"><?=$col['val2']?></li>
			<?}else if($col['type']==20){?>
				<li class="feedback_txt2"><?=$col['val2']?></li>
			<?}else if($col['type']==30){?>
				<li>
					<div style="position:relative;top:1em;width:96%;text-align:center">
						<?for($i=1;$i<7;$i++){?>
							<img src="/image/feedback/feedback_b<?=$i?>.png" id="q<?=$j?>_<?=$i?>" style ="width:16.6%;height:auto;padding:0%;display:block;float:left;">
						<?}?>
					</div>
				</li>
			<?}else if($col['type']==40){?>
			<li><textarea class="txt_tp1"></textarea></li>
			<?}?>
			<?}?>
			</ul>
		</div>
		<!-- //contents -->
			
		
    
    </div> <!-- //container -->
	
<script type="text/javascript">

function up(sid) {
	if(sid>1)
	{
		val2 = sid-1;
		window.open("order.php?val1="+sid+"&val2="+val2,"","width=530,height=770");
	}
}
function down(sid,max) {
	if(sid<max)
	{
		val2 = Number(sid)+Number(1);
		window.open("order.php?val1="+sid+"&val2="+val2,"","width=530,height=770");
	}
}


function showYN(val,sid) {
	window.open("show.php?show="+val+"&sid="+sid,"","width=530,height=500");
}

function add() {
	window.open("add.php","","width=530,height=500");
}

function modify(sid) {
	window.open("add.php?sid="+sid,"","width=530,height=500");
}	

function del(sid) {
	window.open("del.php?sid="+sid,"","width=530,height=520");
}
</script>

   
<?include "./../footer.php";?>