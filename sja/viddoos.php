<?php

	if (isset($vid)) :

?>

<div class='vid-doos' <?=isset($doos_id)?"id='$doos_id'":""?> title='klik voor pauze/start'>
	<video
		<?=isset($vid_id)?"id='$vid_id'":""?>
		width="<?=$vid['width']?>"
		height="<?=$vid['height']?>"
		src="<?=$vid['url']?>"
		<?php if (isset($poster)) : echo "poster='$poster'"; endif; ?>

		<?=isset($vid_attr)?"$vid_attr":""?>
	></video>
	<div class='vid-onder-buiten'>
		<div class='vid-onder-binnen'>
			<?=isset($vid_onder)?$vid_onder:""?>
		</div>
	</div>
</div>

<?php endif; ?>