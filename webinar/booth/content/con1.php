   
<h3><img src="/asset/spon/tit_platinum.png" alt="Platinum"></h3>
<ul class="sponsor">
    <?
    $query = "select * from booth where del='N' and booth_sid='1' order by sort_num asc";
    $result=$conn->query($query);
    if(DB::isError($result)) die($result->getMessage());
    while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
		$homepage = $conn->getOne("select homepage from booth_company where booth_sid='".$d['sid']."'");
    ?>
    <li>
        <a href="<?=$homepage?>" target="_blank" -href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="-Load_Base Booth_cnt" Wsize='1302'  Hsize='822' Tsize='3%' key="<?=$d['sid']?>">
        <img src="<?=$_Azure['link']?>upload/booth/<?=$d['booth_file']?>" alt="" style="height:70px;"></a>
    </li>
    <?}?>
</ul>


<h3><img src="/asset/spon/tit_gold.png" alt="Gold"></h3>
<ul class="sponsor">
    <?
    $query = "select * from booth where del='N' and booth_sid='2' order by sort_num asc";
    $result=$conn->query($query);
    if(DB::isError($result)) die($result->getMessage());
    while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {

		$homepage = $conn->getOne("select homepage from booth_company where booth_sid='".$d['sid']."'");
    ?>
    <li>
        <a href="<?=$homepage?>" target="_blank" -href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="-Load_Base Booth_cnt" Wsize='1302'  Hsize='822' Tsize='3%'  key="<?=$d['sid']?>">
        <img src="<?=$_Azure['link']?>upload/booth/<?=$d['booth_file']?>" alt="" style="height:70px;"></a>
    </li>
    <?}?>
</ul>


<h3><img src="/asset/spon/tit_silver.png" alt="Silver"></h3>
<ul class="sponsor" style="    height: 75px;">
    <?
    $query = "select * from booth where del='N' and booth_sid='3' order by sort_num asc";
    $result=$conn->query($query);
    if(DB::isError($result)) die($result->getMessage());
    while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
		$homepage = $conn->getOne("select homepage from booth_company where booth_sid='".$d['sid']."'");
    ?>
    <li>
        <a href="<?=$homepage?>" target="_blank" -href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="-Load_Base Booth_cnt" Wsize='1302'  Hsize='822' Tsize='3%'  key="<?=$d['sid']?>">
        <img src="<?=$_Azure['link']?>upload/booth/<?=$d['booth_file']?>" alt="" style="height:70px;"></a>
    </li>
    <?}?>
</ul>


<h3><img src="/asset/spon/tit_bronze.png" alt="Bronze"></h3>
<ul class="sponsor">
    <?
    $query = "select * from booth where del='N' and booth_sid='4' order by sort_num asc";
    $result=$conn->query($query);
    if(DB::isError($result)) die($result->getMessage());
    while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
		$homepage = $conn->getOne("select homepage from booth_company where booth_sid='".$d['sid']."'");
    ?>
    <li>
        <a href="<?=$homepage?>" target="_blank" -href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="-Load_Base Booth_cnt" Wsize='1302'  Hsize='822' Tsize='3%'  key="<?=$d['sid']?>">
        <img src="<?=$_Azure['link']?>upload/booth/<?=$d['booth_file']?>" alt="" style="height:70px;"></a>
    </li>
    <?}?>
</ul>


<h3><img src="/asset/spon/tit_support.png" alt="Bronze"></h3>
<ul class="sponsor">
    <?
    $query = "select * from booth where del='N' and booth_sid='5' order by sort_num asc";
    $result=$conn->query($query);
    if(DB::isError($result)) die($result->getMessage());
    while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
		$homepage = $conn->getOne("select homepage from booth_company where booth_sid='".$d['sid']."'");
    ?>
    <li>
        <a href="<?=$homepage?>" target="_blank" -href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="-Load_Base Booth_cnt" Wsize='1302'  Hsize='822' Tsize='3%'  key="<?=$d['sid']?>">
        <img src="<?=$_Azure['link']?>upload/booth/<?=$d['booth_file']?>" alt="" style="height:70px;"></a>
    </li>
    <?}?>
</ul>