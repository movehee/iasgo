<?php
$query = "select t1.* from booth as t1 left join booth_grade as t2 on t1.booth_sid=t2.sid where t1.op6='Y' and t1.del='N' ";
$query .= "order by t2.sort_num asc, t1.sort_num asc";
$result=$conn->query($query);
if(DB::isError($result)) die($result->getMessage());

$query_cnt = $conn->getOne("SELECT COUNT(t1.sid) FROM booth t1 LEFT JOIN booth_stamp t2 ON t1.sid=t2.booth_sid AND t2.usid=".$_COOKIE['wmember_sid']."  WHERE t1.op6='Y' AND t1.del='N' AND t2.sid IS NULL");
?>
<div class="qrEvent">
    <ul class="eventBooth">
    <?php
        $cnt = 1;
        $mycnt=0;
        while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
        if($d['stamp_file']){	
            $my_stamp = $conn->getOne("select count(*) from booth_stamp where usid='".$_COOKIE['wmember_sid']."' and booth_sid='".$d['sid']."'");
            if($my_stamp>0){
                $mycnt++;
            }
        ?>
        <li <?if($my_stamp>0){?>class="comp"<?}?>>
        <a href="#"><img src="<?=$_Azure['link']?>upload/booth/<?=$d['stamp_file']?>"></a>
        </li>
    <?
        }
        if($cnt == 12 ) {
	?>
            <li <?if(!$query_cnt){?>style="display:none;"<?}?>><a><img src="<?=$_Azure['link']?>upload/booth/center2.png"></a></li>
	<?
        }
        $cnt++;
    }
    ?>
    </ul>

    <?if($_COOKIE['wmember_country']=='K'){?>
    <div class="eventInfo">

        <h3>Scan the QR images and Complete Puzzle!</h3>

        <dl>
            <dt>참여 방법</dt>
            <dd>
                1. 코엑스 3층 전시장 D홀에 위치한 24개의 후원사 부스에 방문해주세요.<br>
				2. 모바일 QR Code를 통해 각 부스의 QR Code를 스캔하고 이미지를 완성해주세요.<br>
				3. 완성된 이미지를 가지고 AOCR 2022 & KCR 2022 전시 사무국으로 방문해주세요
            </dd>

            <dt>상품</dt>
            <dd>
                · 국내 참가자 : 스타벅스 상품권 1만원권 + 경품 추첨권<br>
                · 국외 참가자 : 도자 코스터
            </dd>

            <dt>비고</dt>
            <dd>
                중복 참여는 불가, 5일 간 현장 1회 참여 가능<br>
                현장 참여 상품은 일 별 선착순으로 지급
            </dd>
        </dl>
    </div>

    <?} else {?>

	<!--eng-->
    <div class="eventInfo">
    
        <h3>Scan the QR images and Complete Puzzle!</h3>

        <dl>
            <dt>참여 방법</dt>
            <dd>
            1. Enter the Exhibition Hall D (3F) and visit the 24 sponsor booths.<br>
            2. Scan the QR Code of each booth through QR Code on mobile and complete the image.<br>
            3. The Completed image and submit it to the AOCR 2022 & KCR 2022 Secretariat.

            </dd>

            <dt>상품</dt>
            <dd>
                · (Domestic) Gift Certificate<br>
                · (Overseas) Ceramic Costars
            </dd>

            <dt>Remarks</dt>
            <dd>
                Duplicated participation per booth will not be allowed.<br>
                The event items will be provided during the congress on a first-come, first-served basis.

            </dd>
        </dl>
    </div>
    <?}?>

    <!-- //eventInfo -->


</div>