<div class="movie scrollArea">
    <div class="note">
        Taking place in Exhibition Hall D 15-minute presentations on the AI Stage will offer participants the chance to learn about the latest radiology AI innovations. Presentations also are available the day after each of the onsite presentations.<br>
       <a href="https://virtual.aocr2022.org/booth/AOCR 2022_KCR 2022_Onsite Presentatin Time Table.pdf" target="_blank">Onsite Presentation Time Table</a>
    </div>

    <?php if($booth['ai_stage'] && $booth['ai_stage_open'] == 'Y'):?>
    <dl class="vod">
        <dt>
            <?=$booth['ai_stage_title']?>
        </dt>
        <dd>
            <div class="vodArea">
                <iframe src="<?=$booth['ai_stage']?>" width="100%" height="100%" allow="autoplay" frameborder="0"  fullscreen allowfullscreen></iframe>
            </div>
        </dd>
    </dl>
    <?php endif;?>

    <?php if($booth['ai_stage2'] && $booth['ai_stage_open2'] == 'Y') :?>
    <dl class="vod">
        <dt>
            <?=$booth['ai_stage_title2']?>
        </dt>
        <dd>
            <div class="vodArea">
                <iframe src="<?=$booth['ai_stage2']?>" width="100%" height="100%" allow="autoplay" frameborder="0"  fullscreen allowfullscreen></iframe>
            </div>
        </dd>
    </dl>
    <?php endif;?>


</div>
<!-- //movie -->