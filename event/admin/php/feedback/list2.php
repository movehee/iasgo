<?include "./../header.php";?>
<link type="text/css" rel="stylesheet" href="/css/feedback.css" />
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
			
			<p class="btn" style="top: -44px; right: 460px; position: absolute;"><a href="" onclick="javascript:result()" class="btnDef"><i class="fas fa-eye"></i>결과보기</a></p>


			<p class="btn" style="top: -44px; right: 330px; position: absolute;"><a href="" onclick="javascript:css('<?=$_COOKIE['code']?>')" class="btnDef"><i class="fas fa-cog"></i>CSS 설정</a></p>


			<p class="btn" style="top: -44px; right: 200px; position: absolute;"><a href="" onclick="javascript:view('<?=$_COOKIE['code']?>')" class="btnDef"><i class="fas fa-eye"></i>미리보기</a></p>
			
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a href="" onclick="javascript:add()" class="btnDef"><i class="fas fa-plus-circle"></i>Feedback 등록</a></p>
			
			<table class="tblList">
				<colgroup>
					<col style="width:10px;">
					<col style="width:20px;">
					<col style="width:10px;">
					<col style="width:600px;">
					<col style="width:60px;">
					<col>
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th>NO</th>
						<th></th>
						<th>정보</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($col=$result->fetchRow(DB_FETCHMODE_ASSOC))){?>

				<tr id="<?=$col['sid']?>">
						<td onclick="javascript:up('<?=$col['orderby']?>')">▲</td>
						<td><?=$col['orderby']?></td>
						<td onclick="javascript:down('<?=$col['orderby']?>','<?=$max?>')">▼</td>


						<td>
						<div class="feedbackArea">
							<?if($col['type']=="0"){?>
				<h2 class="subTitBg" style="background-color:<?=$css_col['main_color']?>"><span style="background-color:<?=$css_col['bold_color']?>;height:100%"><?=$col['val1']?></span><?=$col['val2']?></h2>
			<?}?>


			<?if($col['type']=="1"){?>
				<h2 class="subTitBg" style="background-color:<?=$css_col['main_color']?>;padding: 10px 10px 10px 10px;"><?=$col['val1']?></h2>
			<?}?>
			
			<?if($col['type']=="2"){?>
				<dl class='feedbackItem'>
					<dt class="subTit2"><?=$col['val1']?></dt>
				</dl>
			<?}?>

			<?if($col['type']=="3"){?>
				<dl class='feedbackItem'>
					<dt class="subTit" style="color:<?=$css_col['sub_color']?>"><b>ㆍ</b><?=$col['val1']?></dt>
				</dl>
			<?}?>


			<?if($col['type']=="11"){?>
				<dl class='feedbackItem'>
					<dd class="multi">
					<?for($i=1;$i<=$col['cnt'];$i++){?>
						
						<span class="changeBg inputR <?if ($d['answer'.$j]==$i){?> on<?}?>" id="q<?=$j?>_<?=$i?>" onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>)">
						<i class="fas fa-check"></i></span><label for=""><?=$col['sub'.$i]?></label>
					<?}?>
					<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
					<?$j++;?>
					</dd>
				</dl>
			<?}?>

			<?if($col['type']=="12"){?>
				<ul class='feedbackItem'>

					<?for($i=1;$i<=$col['cnt'];$i++){?>
						<li onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>)">
						<span class="changeBg inputR <?if ($d['answer'.$j]==$i){?> on<?}?>" id="q<?=$j?>_<?=$i?>" >
						<i class="fas fa-check"></i></span><label for=""><?=$col['sub'.$i]?></label>
					<?}?>
					<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
					<?$j++;?>

				</ul>
			<?}?>


			<?if($col['type']=="21"){?>
				<dl class='feedbackItem'>
				<dd>
					<select name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">

					<?for($i=1;$i<=$col['cnt'];$i++){?>

						<option <?if ($d['answer'.$j]==$i){?> selected<?}?> value="<?=$i?>"><?=$col['sub'.$i]?></option>

					<?}?>
					<?$j++;?>
					</select>
				</dd>
				</dl>
			<?}?>

			<?if($col['type']=="31"){?>
			<dl class='feedbackItem'>
				<dd>
				<dl>
					<dd>
						<ul class="changeBg">

							<?for($i=1;$i<=5;$i++){?>

							<li><a id="q<?=$j?>_<?=$i?>" class="<?if ($d['answer'.$j]==$i){?> on<?}?>" onclick="chk_qu(<?=$j?>,<?=$i?>,'5')"><?=$i?></a></li>
							<?}?>
							<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
							<?$j++;?>
						</ul>
					</dd>
				</dl>
				</dd>
			</dl>
			<?}?>

			<?if($col['type']=="32"){?>
			<dl class='feedbackItem'>
				<dd>
				<dl>
					<dd>
						<ul class="changeBg">

						<?for($i=1;$i<=$col['cnt'];$i++){?>

							<li style="width:<?=100/$col['cnt']?>%"><a id="q<?=$j?>_<?=$i?>" class="<?if ($d['answer'.$j]==$i){?> on<?}?>" onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>)">✔</a>
							<label style="margin-top:5px" for=""><?=$col['sub'.$i]?></label>
							</li>
						<?}?>
						<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
						<?$j++;?>

						</ul>
					</dd>
				</dl>
				</dd>
			</dl>
			<?}?>

			<?if($col['type']=="41"){?>
				<p class="border"><textarea  name="memo<?=$q?>" id="memo<?=$q?>" cols="30" rows="10"><?=$d['memo'.$q]?></textarea></p>
				<?$q++;?>
				
			<?}?>
						
						
						
						</div>
						</td>
				
						<td>
							<a href="" onclick="javascript:modify('<?=$col['sid']?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
							<a href="" onclick="javascript:del('<?=$col['sid']?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
						</td>
					</tr>
				<?}?>
					
				</tbody>
			</table>

			<ul class="pager">
			<?
				for($i = 0 ; $i*$num_per_page < $totalRecord ; $i++)
				{?>	
					<li <?if($i==$page){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$i?><?if($search){?>&search=<?=$search?><?}?>"><?=$i+1?></a></li>
				<?}
			?>
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
	window.open("add.php","","width=530,height=800");
}

function css() {
	window.open("css.php","","width=530,height=700");
}
function view(code) {
	window.open("/php/feedback/view.php?code="+code,"","width=530,height=800");
}

function result() {
	window.open("excel.php","","width=530,height=500");
}


function modify(sid) {
	window.open("add.php?sid="+sid,"","width=530,height=500");
}	

function del(sid) {
	window.open("del.php?sid="+sid,"","width=530,height=520");
}

</script>

   
<?include "./../footer.php";?>