<?php 
if ( !empty($_POST ) ) : ?>
<div id="message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
<h2><?php _e('Try theme to develop'); ?></h2>
<form action="" method="post">
<p><?php _e('Select the template you want to develop (the users will see only with permission from "edit_theme")'); ?></p>
<?php
$ct = current_theme_info();
if ($themes = get_themes()){
ksort( $themes );
?>
	<ul>
	<?php foreach($themes as $theme) { ?>
		<li>
			<label for="templateToTry_<?= $theme["Template"]; ?>">
				<input type="radio" name="templateToTry" id="templateToTry_<?= $theme["Template"]; ?>" value="<?= $theme["Template"]; ?>" <?php if(get_option('templateToTry') == $theme["Template"]) echo 'checked="checked"'; ?>/>
				<strong><?= $theme["Name"]; ?></strong>
				<?php if ($ct->template == $theme["Template"]) echo "<strong>[".__("Public Theme")."]</strong>"; ?>
				<?php if ($theme["Description"] != '') echo ": ".$theme["Description"]; ?>
			</label>
		</li>
	<?php } ?>
	</ul>
<?php } ?>
<p class="submit"><input type="submit" name="submit" value="<?php _e('Try Theme &raquo;'); ?>" /></p>
</form>
</div>