<?
$view_chk = $conn->getOne("select count(sid) from booth_view_tbl where usid='".$_COOKIE['wmember_sid']."' and booth_sid='$booth_sid'");
if($view_chk==0){
    $cnt_query = "insert into booth_view_tbl set usid='".$_COOKIE['wmember_sid']."', booth_sid='$booth_sid', signdate='".time()."'";
    $cnt_result = $conn->query($cnt_query);	
}

$query = "select * from booth_company where booth_sid='$booth_sid'";
$result = $conn->query($query);
if(DB::isError($result)) {
    die($result->getMessage());
}
$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
$result->free();


$query = "select * from booth_contact_us where booth_sid='".$booth_sid."'";
$result = $conn->query($query);
if(DB::isError($result)) {
    die($result->getMessage());
}
$result->fetchInto(&$c,DB_FETCHMODE_ASSOC);
$result->free();
?>

<div class="company">
    <div class="companyBrief">
        <div class="logo">
        <?if($booth['logo_file']){?>
            <img src="<?=$_Azure['link']?>upload/booth/<?=$booth['logo_file']?>" alt="<?=$booth['title']?>">
        <?}?>
        </div>
        <dl>
            <dt><?=$booth['title']?></dt>
            <dd>
                <ul>
                    <?if($d['email']){?>
                    <li><span>E-mail :</span><a href="mailto:<?=$d['email']?>"><?=$d['email']?></a></li>
                    <?}?>
                    
                    <?if($d['fax']){?>
                    <li><span>Fax :</span><?=$d['fax']?></li>
                    <?}?>

                    <?if($d['tel']){?>
                    <li><span>Tel :</span><?=$d['tel']?></li>
                    <?}?>

                    <?if($d['cell']){?>
                    <li><span>Phone :</span><?=$d['cell']?></li>
                    <?}?>

                    <?if($d['homepage']){?>
                    <li class="wide"><span>Homepage :</span><a href="<?=$d['homepage']?>" target="_blank"><?=$d['homepage']?></a></li>
                    <?}?>

                </ul>
            </dd>
        </dl>
    </div>
    <!-- //brief -->

    <div class="col fl" <?if(!$d['vod_link']){?>style="width:100% !important;"<?}?>>
        <h3 class="subTit">Company Information</h3>
        <div class="scrollArea">
            <dl class="companyInfo">
                <dt>President</dt>
                <dd><?=$c['field1']?></dd>

                <dt>Correspondence</dt>
                <dd><?=$c['field2']?></dd>

                <dt>Product or service of company</dt>
                <dd><?=$c['field3']?></dd>

                <dt>Company Introduction</dt>
                <dd><?=$c['field4']?></dd>
            </dl>
        </div>
    </div>
    <!-- //col -->

    <?if($d['vod_link']){?>
    <div class="col fr">
        <h3 class="subTit">VOD</h3>
        <div class="vodArea">
            <iframe src="<?=$d['vod_link']?>" width="100%" height="100%" allow="autoplay" frameborder="0"  fullscreen allowfullscreen></iframe>
        </div>
    </div>
    <?}?>

</div>
<!-- //company -->