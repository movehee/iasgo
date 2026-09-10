<input type="hidden" name="set_alarm" id="set_alarm" value="<?=$setting_col['alarm']?>">
<?if($setting_col['alarm']=="Y"){?>
	<dl class="popupBottom" id="sessionAlarm" style="display:none">
		<dt><?=$string['alarm_info']?></dt>
		<dd>
			<ul>
				<li onclick="javascript:add_alarm()"><?=$string['ok_info']?></li>
				<li onclick="javascript:hide_alarm()"><?=$string['cancel_info']?></li>
			</ul>
		</dd>
	</dl>
<?}?>

<script>

	var alarm_sid;
	var alarm_tab;
	var alarm_time;
	var alarm_subject;

	function add_alarm() {
		location.href = "add_alarm.php?sid="+alarm_sid+"&tab="+alarm_tab+"&time="+alarm_time+"&subject="+encodeURIComponent(alarm_subject);
		$('#sessionAlarm').hide();
	}

	function hide_alarm() {
		$('#sessionAlarm').hide();
	}

	function favor(sid,deviceid,time,subject,tab,tab2){

		alarm_sid = sid;
		alarm_time = time;
		alarm_subject = subject;
		alarm_tab = tab;
		$.ajax({
			type:"POST",
			url:"./favor.php",
			data:"code=<?=$code?>&type=1&session_sid="+sid+"&deviceid="+deviceid,
			success:function(msg){
				//lert(msg);
				if(msg == "Y"){
					$('#favor'+sid).addClass("on");
					$('#sessionAlarm').show();
				}else{
					$('#favor'+sid).removeClass("on");
					$('#sessionAlarm').hide();
					if(tab2=="-2"){
						location.reload(true);
					}
					if($("#set_alarm").val()=="Y"){
						location.href = "remove_alarm.php?sid="+alarm_sid;
					}
				}
				
			}
		});
	}

</script>