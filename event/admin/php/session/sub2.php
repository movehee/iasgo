<?include "./../header2.php";?>

<?

$num_per_page = 200;
if(empty($page)) $page = 0;

$query="SELECT * FROM session_set_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$s = mysqli_fetch_array($result);


$query="SELECT * FROM session_tbl where code='".$code."' and type='2' and link_session='".$session."'";

$result = mysqli_query($conn, "SELECT count(*) cnt FROM session_tbl where code='".$code."' and type='2' and link_session='".$session."'");
$row = mysqli_fetch_array($result);
$totalRecord = $row['cnt'];

$query.=" order by session_tbl.orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;


$result = mysqli_query($conn, "select max(orderby) maxs from session_tbl where code='".$code."' and type='2' and link_session='".$session."'");
$row = mysqli_fetch_array($result);
$max = $row['maxs'];


$theme_result = mysqli_query($conn, "select theme from session_tbl where code='".$code."' and type='1' and sid='".$session."'");
 

$theme_row = mysqli_fetch_array($theme_result);
 
$result = mysqli_query($conn, $query);
?>
<div id="container" class="sessionsubWrap" >
	
		<h2 ><?=$theme_row['theme']?></h2>
		<div class="contents member">
			

			<!--
			<p class="btn" style="top: -44px; right: 460px; position: absolute;"><a href="" onclick="javascript:css('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>CSS �ㅼ�</a></p>
			-->
			
		
			
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><input type="text" style="width:40px;padding:0px;margin-right:5px" name="session_add_cnt" id="session_add_cnt"  value="" /><a  onclick="javascript:add_speaker('<?=$session?>')" class="btnDef"><i class="fas fa-plus-circle"></i>Session 추가</a></p>
			

			<table class="tblList bgOver">
				<thead>

					<tr >
						<th width="3%">NO</th>
						<th width="12%">time</th>
					
						<th width="12%">speaker</th>
						<?if($s['etc_speaker']!="N"){?>
						<th width="12%">etc_speaker</th>
						<?}?>
						<?if($s['title']=="Y"){?>
						<th >title</th>
						<?}?>
						<?if($s['abs_sid']!="N"){?>
						<th width="8%">abs_sid</th>
						<?}?>
						<?if($s['abs_no']!="N"){?>
						<th width="8%">abs_no</th>
						<?}?>


						<th width="5%">관리</th>
					</tr>
				</thead>

				<tbody>
				<?while(is_array($col = mysqli_fetch_array($result))){?>
				<tr id="<?=$col['sid']?>">
					<td><?=$col['orderby']?></td>
					<td><input onchange="changeVal(this,'time','<?=$col['sid']?>')" type="text" name="time" id="time"  value="<?=htmlspecialchars($col['time'])?>" /></td>
				
					<?if($s['faculty_type']==1){?>
					<?
					$faculty_query="SELECT b.name FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='speaker' and a.session_sid='".$col['sid']."' order by a.sid asc";
					$faculty_result=mysqli_query($conn, $faculty_query);
					
					$chair="";
					$i = 0;
					while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
						if($i!=0){
							$chair = $chair . ", ";
						}

						$chair .= $faculty_d['name'];
						$i++;
					}
					?>
						<td><input onchange="changeVal2(this,'speaker','<?=$col['sid']?>')" type="text" name="speaker" id="speaker"  value="<?=htmlspecialchars($chair)?>" /></td>
					<?}else{?>
						<td><input onchange="changeVal(this,'speaker','<?=$col['sid']?>')" type="text" name="speaker" id="speaker"  value="<?=htmlspecialchars($col['speaker'])?>" /></td>
					<?}?>

				

					<?if($s['etc_speaker']!="N"){?>
					<td><input onchange="changeVal(this,'etc_speaker','<?=$col['sid']?>')" type="text" name="etc_speaker" id="etc_speaker"  value="<?=htmlspecialchars($col['etc_speaker'])?>" /></td>
					<?}?>

					<?if($s['title']=="Y"){?>
					<td><input onchange="changeVal(this,'title','<?=$col['sid']?>')" type="text" name="title" id="title"  value="<?=htmlspecialchars($col['title'])?>" /></td>
					<?}?>
					<?if($s['abs_sid']!="N"){?>
					<td><input onchange="changeVal(this,'abs_sid','<?=$col['sid']?>')" type="text" name="abs_sid" id="abs_sid"  value="<?=htmlspecialchars($col['abs_sid'])?>" /></td>
					<?}?>
					<?if($s['abs_no']!="N"){?>
					<td><input onchange="changeVal(this,'abs_no','<?=$col['sid']?>')" type="text" name="abs_no" id="abs_no"  value="<?=htmlspecialchars($col['abs_no'])?>" /></td>
					
					<?}?>
					<td>

						<a onclick="javascript:modify('<?=$col['sid']?>','<?=$session?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
						<a onclick="javascript:del('<?=$col['sid']?>','<?=$session?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
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
 $(function() {
      $('.bgOver tr').mouseover(function(){
         $(this).addClass('bg_over');
      }).mouseout(function() {
         $(this).removeClass('bg_over');

      });

   });

$(function() {
 $(".tblList tbody").sortable( {
	update: function( event, ui ) {
    $(this).children().each(function(index) {
			index = index+1;
			$.ajax({
			type:"POST",
			url:"./session_order2.php",
			data:"sid="+$(this).attr('id')+"&orderby="+index,
			success:function(msg){

			}
		});


    });
  }
});
});

function changeVal2(val,info,sid) {


	$.ajax({
		type:"POST",
		url:"./update_session2.php",
		data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid,
		success:function(msg){
			//console.log(msg);
			obj = JSON.parse(msg);

			$(val).val(obj.new_list)
			if(obj.err_list) {
				alert("입력실패 : " + obj.err_list);
			}
		},error : function(request, status, error ) { 
			alert("입력실패 : " + val.value);
		
		}
	});
}


function changeVal(val,info,sid) {
	//alert(val.value);
	$.ajax({
		type:"POST",
		url:"./update_session.php",
		data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid,
		success:function(msg){
		},error : function(request, status, error ) {   // 
			alert("입력실패 : " + val.value);
		}
	});
}


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

function add(session) {
	window.open("sub_add.php?session="+session,"","width=900,height=1000");
}

function add_speaker(session) {

	value="1";
	if(document.getElementById("session_add_cnt").value>0){
		value = document.getElementById("session_add_cnt").value;
	}


	$.ajax({
		type:"POST",
		url:"./add_speaker.php",
		data:"session="+session+"&value="+value,
		success:function(msg){
			location.reload();
		}
	});
}



function set() {
	window.open("set.php","","width=950,height=1000");
}


function room() {
	window.open("room.php","");
}

function timeset() {
	window.open("time.php","");
}


function css() {
	window.open("css.php","","width=530,height=700");
}
function view(code) {
	window.open("/php/feedback/view.php?code="+code,"","width=530,height=800");
}


function modify(sid,session) {
	window.open("sub_add.php?session="+session+"&sid="+sid,"","width=900,height=1000");
}	

function del(sid,session) {
	if(confirm("삭제하시겠습니까?")){

		$.ajax({
		type:"POST",
		url:"./del_sub.php",
		data:"sid="+sid+"&session="+session,
		success:function(msg){
			location.reload();
		}
	});
	}
}


</script>

   
<?include "./../footer.php";?>