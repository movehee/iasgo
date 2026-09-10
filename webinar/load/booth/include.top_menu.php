<ul class="subMenu">
    <li <?php if($mn=='1'):?>class="on"<?php endif;?>><a href="?booth_sid=<?=$booth_sid?>&mn=1">Company</a></li>
    <?php if($booth['ai_stage']):?>
        <li <?php if($mn=='2'):?>class="on"<?php endif;?>><a href="?booth_sid=<?=$booth_sid?>&mn=2">AI Stage</a></li>
    <?php endif;?>

    <?php if($booth['in_theater']):?>
    <li <?php if($mn=='3'):?>class="on"<?php endif;?>><a href="?booth_sid=<?=$booth_sid?>&mn=3">Industry Theater</a></li>
    <?php endif;?>

    <!-- <li <?php if($mn=='4'):?>class="on"<?php endif;?>><a href="?booth_sid=<?=$booth_sid?>&mn=4">QR Code Event</a></li> -->
</ul>