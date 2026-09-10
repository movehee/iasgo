<?php
include_once $_SERVER['DOCUMENT_ROOT']."/load/include/include.header.php";

$session_query = "select * from workshop_session_tbl where sid=" . $session_sid;
$session_result = $conn->query($session_query);
$session_result->fetchInto(&$session,DB_FETCHMODE_ASSOC);
$session_result->free();

if($session['chair']) $chair_arr[] = stripslashes($session['chair']);
if($session['chair2']) $chair_arr[] = stripslashes($session['chair2']);
if($session['chair3']) $chair_arr[] = stripslashes($session['chair3']);
if($session['chair4']) $chair_arr[] = stripslashes($session['chair4']);


if($session['chair_code']) $chair_code_arr[] = stripslashes($session['chair_code']);
if($session['chair_code2']) $chair_code_arr[] = stripslashes($session['chair_code2']);
if($session['chair_code3']) $chair_code_arr[] = stripslashes($session['chair_code3']);
if($session['chair_code4']) $chair_code_arr[] = stripslashes($session['chair_code4']);


$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
$date_count = date("d",$chkdate);
$ex_sdate = explode("-",$_Webinar['sdate']);

$to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($program_day-1), $ex_sdate[0]));

$session_favor_chk = $conn->getOne("select count(sid) from session_favor_tbl where usid='".$_COOKIE['wmember_sid']."' and session_sid='".$session['sid']."'");
?>
<div class="popupWrap" id="popupDetail">
    <h1 class="bg"><?=$session['code_title']?> (<?=$session['code']?>) <?if($session['part']){?><?=$_PROGRAM['gubun_code'][$session['part']]?><?}?></h1>
		<div class="popupCon">		
            <div class="utill">

                <?if($session['vod']){?>
                    <a href="javascript:popup_call('vod','session_sid=<?=$session_sid?>')" class="vod">VOD</a>
                <?}?>
            
                <?if($session['part2']){?><span class="typeB"><?=$session['part2']?></span><?}?>
                <?if($session['difficulty']){?><span class="<?=$_PROGRAM['difficulty_code'][$session['difficulty']]?>"><?=$_PROGRAM['difficulty'][$session['difficulty']]?></span><?}?>
                <span class="<?=$_PROGRAM['lang_class'][$session['lang']]?>"><?=$_PROGRAM['lang_code_l'][$session['lang']]?></span>
				
				<a href="javascript:session_favor('<?=$session['sid']?>','<?=$session_favor_chk ? 'del' : 'add'?>')" id="favor_btn<?=$session['sid']?>" class="favor<?if($session_favor_chk){?> on<?}?>">Favorite</a>
			</div>

            <div class="scrollArea">
				<table>
					<colgroup>
						<col style="width: 12%;">
						<col style="width: *;">
						<col style="width: 20%;">
					</colgroup>
					<tbody>
						<tr class="bg">
                            <td>
                                <?=Days_convert($to_date,"M.D(w)","s")?><br/>
						        <?=$session['stime']."-".$session['etime']?>
                            </td>
							<td><?=stripslashes($session['title'])?></td>
							<td class="ar">
                                <?=$_Day['room_title'][$session['room']]?><br/>
                                <!-- (Room <?=$session['room']?>) -->
                            </td>
						</tr>
                        <?if($chair_arr){?>
						<tr class="chairs">
							<td><span>Chair<?if(count($chair_arr)>1){?>s<?}?></span></td>
							<td colspan="2">
                                <?=implode(", ",$chair_arr)?>


                                <?if($chair_code_arr && stristr($_SERVER['REMOTE_ADDR'], '218.235.94.') ){?>
                                     / <?=implode(", ",$chair_code_arr)?>
                                <?}?>
							</td>
						</tr>
                        <?}?>

                        <?
                        $detail_query = "select * from workshop_session_detail_tbl where session_sid='".$session['sid']."' and del='N' ";
                        if($keyword){
                            $detail_query .= " and (title like '%$keyword%' or author like '%$keyword%' or author_position_co like '%$keyword%')";
                        }
                        $detail_query .= " order by sort_num asc";
                        $detail_query .= $sort_sql;
                        $detail_result=$conn->query($detail_query);
                        if(DB::isError($detail_result)) die($detail_result->getMessage());
        
                        $set_time = $ex_sdate_arr[0]." ".$session['stime'];
        
        
                        
                        while(is_array($detail=$detail_result->fetchRow(DB_FETCHMODE_ASSOC))) {
                            unset($author_arr);
					
                            unset($pt_total_time);
                            if($detail['pt_time']){
                                $ex_pt = explode("/",$detail['pt_time']);
                                $pt_total_time = $ex_pt[0]+$ex_pt[1];
                                $set_start = date("H:i",strtotime("+".$pt_total_time." minutes",strtotime($set_time)));
                            }

                            $faculty_sid = $conn->getOne("select t2.sid from faculty_matching as t1 inner join faculty_tbl as t2 on t1.faculty_sid=t2.sid where t1.session_sid='".$session_sid."' and t1.session_detail_sid='".$detail['sid']."'");
                                                    
                            $author_arr[] = $detail['author'].($detail['country']?" (".$detail['country'].")":"");
                            if(trim($detail['author2'])) $author_arr[] = $detail['author2'].($detail['country2']?" (".$detail['country2'].")":"");
                            if(trim($detail['author3'])) $author_arr[] = $detail['author3'].($detail['country3']?" (".$detail['country3'].")":"");
                            if(trim($detail['author4'])) $author_arr[] = $detail['author4'].($detail['country4']?" (".$detail['country4'].")":"");
                        ?>
							<tr>
								<td>
                                <?if($detail['time_skip']!='Y'){?>
                                <?=date("H:i",strtotime($set_time))?>-<?=$set_start?>
                                <?}?>
                                </td>
								<td class="tit">
									<?=stripslashes($detail['title'])?>
									<span class="util">
                                        <?if($detail['cv_file']){?>
                                        <a href="javascript:popup_call('Azure','kind=detail_cv&sid=<?=$detail['sid']?>')" class="cv">CV</a>
                                        <?}else{?>
                                            <?
                                                $faculty_cv = $conn->getOne("select faculty_cv from faculty_tbl where sid='$faculty_sid'");
                                                if($faculty_cv){
                                                    ?>
                                                    <a href="javascript:popup_call('Azure','kind=faculty_cv&faculty_sid=<?=$faculty_sid?>')" class="cv">CV</a>
                                                    <?
                                                }
                                            ?>
                                        <?}?>
                                        <?if($detail['abs_file']){?>
                                            <a href="javascript:popup_call('Azure','kind=detail_abs&sid=<?=$detail['sid']?>')" class="abstract">Lecture Note</a>
                                        <?}else{?>
                                            <?
                                                $faculty_abs = $conn->getOne("select faculty_abs from faculty_tbl where sid='$faculty_sid'");
                                                if($faculty_abs){
                                                    ?>
                                                    <a href="javascript:popup_call('Azure','kind=faculty_abs&faculty_sid=<?=$faculty_sid?>')" class="abstract">Lecture Note</a>
                                                    <?
                                                }
                                            ?>
                                        <?}?>
									</span>
								</td>
								<td class="ar">
                                    <?
                                    if($author_arr){
                                        foreach($author_arr as $tkey=>$tval){
                                            echo "<div>".str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",$tval)."</div>";
                                        }

                                        if(stristr($_SERVER['REMOTE_ADDR'], '218.235.94.')) {
                                            echo " / ". $detail['pre_num'];
                                        }
                                    }
                                    ?>
                                    <!-- <a href="#">Bok Ki Jung<br>(Yonsei Univ.)</a> -->
                                
                                </td>	
							</tr>
						<?
                            if($detail['pt_time']){
                                $set_time = $ex_sdate_arr[0]." ".$set_start;
                            }
                        }
                        ?>


                    </tbody>
                </table>
            </div>
		</div>

	</div>
	<!-- //popupWrap -->
</body>
<script>
    function session_favor(sid,mode){
        
        $.ajax({
            type:"POST",
            url:"/load/session_favor.php",
            data:"sid="+sid+"&mode="+mode,
            async:false,
            success:function(msg){
                var parse_data = JSON.parse(msg);
                
                if(parse_data.push=='R'){
                    //alert("이미 추가된 세션입니다.");
                    $('#favor_btn'+sid).removeClass("on");
                }else if(parse_data.push=='Y'){
                    //alert("즐겨찾기에 추가되었습니다.");
                    $('#favor_btn'+sid).addClass("on");
                }else if(parse_data.push=='D'){
                    //alert("즐겨찾기에서 삭제되었습니다.");
                    //$('#session_favor'+sid).remove();
                    $('#favor_btn'+sid).removeClass("on");
                }else{
                    alert("에러가 발생하였습니다. 잠시후에 다시 이용해주세요");
                }
            }
        });
        
    }
</script>
</html>