<div class="movie scrollArea">
    <div class="note">
        Through the Industry Theater, you can check the contents of lectures from partnering companies.
    </div>

    <?php if($booth['in_theater'] && $booth['in_theater_open'] == 'Y'):?>
    <dl class="vod">
        <dt>
            <?=$booth['in_theater_title']?>
        </dt>
        <dd>
            <div class="vodArea">
                <iframe src="<?=$booth['in_theater']?>" width="100%" height="100%" allow="autoplay" frameborder="0"  fullscreen allowfullscreen></iframe>
            </div>
        </dd>
    </dl>
    <?php endif;?>
</div>
<!-- //movie -->