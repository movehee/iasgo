<div class="ar tm30">* Last name alphabetical order</div>

    <div class="speaker">
        <?
        $category = 1;
        $ex_sdate = explode("-",$_Webinar['sdate']);

        $query = "select fsid,dsid,faculty_kind,category,category_sub,faculty_name,faculty_aff,faculty_photo,faculty_cv,faculty_abs,faculty_info";
        $query .= ",session_sid,session_detail_sid,lang,part,difficulty,ev_date,stime,etime,room,title,detail_time,detail_title,pre_num,count(dsid) as Dcnt from ";
        $query .= "(select t1.sid as fsid,t2.sid as dsid,t2.faculty_kind,t2.category,t2.category_sub,faculty_name,faculty_aff,faculty_photo,faculty_cv,faculty_abs,faculty_info,";
        $query .= "t2.session_sid,t2.session_detail_sid,t3.lang,t3.part,t3.difficulty,t3.ev_date,t3.stime,t3.etime,t3.room,t3.title,t4.detail_time,t4.title as detail_title,t4.pre_num from faculty_tbl as t1 ";
        $query .= "left join faculty_matching as t2 on t1.sid=t2.faculty_sid left join workshop_session_tbl as t3 on t3.sid=t2.session_sid left join workshop_session_detail_tbl as t4 on t4.sid=t2.session_detail_sid) A"; 
        $query .= " where category='$category' and fsid is not null group by fsid";
        $query .= " order by ev_date asc, room asc, stime asc, detail_time asc";
        
        $result=$conn->query($query);
        if(DB::isError($result)) die($result->getMessage());

        while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
            
            unset($onair);
            $dates = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['ev_date']-1), $ex_sdate[0]));

            $f_link = "/load/faculty_session_list.php?faculty_sid=" . $d['fsid'];
                   
        ?>
        
        <dl class="speaker">
            <dt>
                <span class="type">

                    <span class="<?=$_PROGRAM['lang_class'][$d['lang']]?>"><?=$_PROGRAM['lang_code'][$d['lang']]?></span>
                    <?if($d['part']){?><span class="ch"><?=$d['part']?></span><?}?>
                    <?if($d['difficulty']){?><span class="<?=$_PROGRAM['difficulty_code'][$d['difficulty']]?>"><?=$_PROGRAM['difficulty'][$d['difficulty']]?></span><?}?>
                </span>
                <span class="photo">
                    <?if($d['faculty_photo']){?>
						<a href="<?=$f_link?>" class="Load_Base" Wsize="800" Hsize="600" Tsize="200"><img src="<?=$_Azure['link'].'upload/faculty/'.$d['faculty_photo']?>" alt="<?=$d['faculty_name']?>"></a>
					<?}?>
                </span>
                <span class="name">
                    <a href="<?=$f_link?>" class="Load_Base" Wsize="800" Hsize="600" Tsize="200"><?=$d['faculty_name']?></a>
                </span>
                <?=$d['faculty_aff']?>
            </dt>
            <dd>
                <span class="scrollArea">
                    <?
                    if($d['Dcnt']>1){
                        $query2 = "select fsid,dsid,faculty_kind,category,category_sub,faculty_name,faculty_aff,faculty_photo,faculty_cv,faculty_abs,faculty_info";
                        $query2 .= ",session_sid,session_detail_sid,ev_date,stime,etime,room,title,detail_time,detail_title,pre_num from ";
                        $query2 .= "(select t1.sid as fsid,t2.sid as dsid,t2.faculty_kind,t2.category,t2.category_sub,faculty_name,faculty_aff,faculty_photo,faculty_cv,faculty_abs,faculty_info,";
                        $query2 .= "t2.session_sid,t2.session_detail_sid,t3.ev_date,t3.stime,t3.etime,t3.room,t3.title,t4.detail_time,t4.title as detail_title,t4.pre_num from faculty_tbl as t1 ";
                        $query2 .= "left join faculty_matching as t2 on t1.sid=t2.faculty_sid left join workshop_session_tbl as t3 on t3.sid=t2.session_sid left join workshop_session_detail_tbl as t4 on t4.sid=t2.session_detail_sid) A"; 
                        $query2 .= " where category='$category' and fsid is not null";
                        $query2 .= " /*and category_sub='$cate[sid]'*/ and fsid='$d[fsid]'";
                        $query2 .= " order by ev_date asc, room asc, stime desc, detail_time asc";
// echo $query2;exit;
                        $result2=$conn->query($query2);
                        if(DB::isError($result2)) die($result2->getMessage());

                        while(is_array($col=$result2->fetchRow(DB_FETCHMODE_ASSOC))){
                            $dates = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($col['ev_date']-1), $ex_sdate[0]));
                            
                            if(strtotime($dates.' '.$col['stime'])<$_Time['ing'] && strtotime($dates.' '.$col['etime'])>$_Time['ing']){
                                $onair = "on";
                                $_room = $col['room'];
                            }
                    ?>
                        <?=$col['detail_title'];?><br/>
                        <?=Days_convert($dates,"M D (w)")?> <?=$col['stime']?>-<?=$col['etime']?><br/>
                        <?}?>
                    <?}else{
                        
                        if(strtotime($dates.' '.$d['stime'])<$_Time['ing'] && strtotime($dates.' '.$d['etime'])>$_Time['ing']){
                            $onair = "on";
                            $_room = $d['room'];
                        }     
                    ?>
                        <?=$d['detail_title'];?><br/>
                        <?=Days_convert($dates,"M D (w)")?> <?=$d['stime']?>-<?=$d['etime']?><br/>
                    <?}?>
                </span>

                <?if($onair=='on'){?>
                    <a href="javascript:direct_room(<?=$_room?>)" class="onair">On-air</a> 
                <?}else{?>
                    <a class="onair disabled" href="javascript:alert('지금은 해당 연자의 강의시간이 아닙니다. \n강의 날짜와 시간을 확인해 주세요.\nPlease check the date and time of the lecture.')">On-air</a> 
                <?}?>
            </dd>
        </dl>
        <?}?>


    </div>