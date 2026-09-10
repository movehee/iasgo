<?include "./../header.php";?>


<?

$num_per_page = 10;
if(!$page) $page = 0;
$query="SELECT * FROM voting_tbl where code='".$_COOKIE['code']."' and lecture='".$lecture."' and del='N'";

$totalRecord = $conn->getOne(str_replace("*","COUNT(*)",$query));

$query.=" order by sid asc LIMIT ".$page*$num_per_page.",".$num_per_page;

$result=$conn->query($query);

?>
<div id="container">
	
		<h2>Voting 관리</h2>
		<div class="contents member">
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a href="" onclick="javascript:add(<?=$lecture?>)" class="btnDef">Voting 등록</a></p>

			
			<ul class="section">
			<?
			while ($col = $result->fetchRow(DB_FETCHMODE_ASSOC)) {?>
				<li class="more">
					<p class="view"><a href="#" class="toggle">
					<div style ="width:60px;height:70px;display:block;float:left;background-color:#173464">
						<span style="font-size:18px;text-align:center;line-height:37px;width:60px;height:40px;display:block;float:left;background-color:#3368c9;color:#ffffff">Q<?=$col['orderby']?></span>
						<span style="font-size:18px;text-align:center;margin-top:1px;line-height:24px;width:29.5px;height:29px;display:block;float:left;background-color:#3368c9;color:#ffffff">▲</span>
						<span style="font-size:18px;text-align:center;margin-top:1px;margin-left:1px;line-height:24px;width:29.5px;height:29px;display:block;float:left;background-color:#3368c9;color:#ffffff">▼</span>
					</div>
				

					<span style="font-size:15px;padding: 5px 11px 5px;width:900px;height:60px;display:block;float:left;"><?=$col['question']?></span>

					<span style="display:block;float:left;width:98px;height:70px;background-color:#00ff00"></span>
					
					</a></p>
					<ul class="programList toggleCon">
						<li>1번</li>
						<li>2번</li>
						<li>3번</li>
						<li>4번</li>
					</ul>
				</li>

			<?}?>


			</ul>

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


function voting(sid) {
	location.href="./voting.php?lecture="+sid;
}


function add(lecture) {
	window.open("voting_add.php?lecture="+lecture,"","width=530,height=770");
}

function modify(lecture,sid) {
	window.open("voting_add.php?lecture="+lecture+"&sid="+sid,"","width=530,height=770");
}	

function del(sid) {
	window.open("voting_del.php?sid="+sid,"","width=530,height=520");
}

</script>

   
<?include "./../footer.php";?>