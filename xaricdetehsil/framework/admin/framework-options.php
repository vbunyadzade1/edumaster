<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Build The options
/*-----------------------------------------------------------------------------------*/
function kavkaz_options_build( $value, $option_name, $data ){
?>
	<div class="option-item" id="<?php echo $value['id'] ?>-item">
		<span class="label">
		<?php if( !empty($value['name']) ) echo $value['name']; ?></span>

	<?php
	switch ( $value['type'] ) {

		//Text Option
		case 'text': ?>
			<input name="<?php echo $option_name ?>" id="<?php  echo $value['id']; ?>" type="text" value="<?php if( !empty( $data ) ) echo $data; elseif( !empty( $value['default'] ) ) echo $value['default'];  ?>" />
			<?php
				if( $value['id']=="slider_tag" || $value['id']=="featured_posts_tag" || $value['id']=="breaking_tag"){
				$tags = get_tags('orderby=count&order=desc&number=50'); ?>
				<a style="cursor:pointer" title="<?php _e( 'Choose from the most used tags', 'kavkaz' )  ?>" onclick="toggleVisibility('<?php echo $value['id']; ?>_tags');"><img src="<?php echo get_template_directory_uri(); ?>/framework/admin/images/expand.png" alt="" /></a>
				<span class="tags-list" id="<?php echo $value['id']; ?>_tags">
					<?php foreach ($tags as $tag){?>
						<a style="cursor:pointer" onclick="if(<?php echo $value['id'] ?>.value != ''){ var sep = ' , '}else{var sep = ''} <?php echo $value['id'] ?>.value=<?php echo $value['id'] ?>.value+sep+(this.rel);" rel="<?php echo $tag->name ?>"><?php echo $tag->name ?></a>
					<?php } ?>
				</span>
			<?php } ?>
		<?php
		break;


		//Array Option
		case 'arrayText':  $currentValue = $data;?>
			<input name="<?php echo $option_name ?>[<?php echo $value['key']; ?>]" id="<?php  echo $value['id']; ?>[<?php echo $value['key']; ?>]" type="text" value="<?php if( !empty( $currentValue[$value['key']] ) ) echo $currentValue[$value['key']] ?>" />
		<?php
		break;


		//Short-Text Option
		case 'short-text': ?>
			<input style="width:50px" name="<?php echo $option_name ?>" id="<?php  echo $value['id']; ?>" type="text" value="<?php if( !empty( $data ) ) echo $data; elseif( !empty( $value['default'] ) ) echo $value['default']; ?>" />
		<?php
		break;


		//Checkbox Option
		case 'checkbox':
			if( $data ){$checked = "checked=\"checked\"";  } else{$checked = "";} ?>
				<input class="on-of" type="checkbox" name="<?php echo $option_name ?>" id="<?php echo $value['id'] ?>" value="true" <?php echo $checked; ?> />
		<?php
		break;


		//Radio Option
		case 'radio':
		?>
			<div class="option-contents">
				<?php
				$i = 0;
				foreach ($value['options'] as $key => $option) { $i++; ?>
				<label style="display:block; margin-bottom:8px;"><input name="<?php echo $option_name ?>" id="<?php echo $value['id']; ?>" type="radio" value="<?php echo $key ?>" <?php if ( ( !empty(  $data ) && $data == $key ) || ( empty( $data ) && $i==1 ) ) { echo ' checked="checked"' ; } ?>> <?php echo $option; ?></label>
				<?php } ?>
			</div>
		<?php
		break;


		//Select Menu Option
		case 'select':
		?>
			<select name="<?php echo $option_name ?>" id="<?php echo $value['id']; ?>">
				<?php
				$i = 0;
				foreach ($value['options'] as $key => $option) {  $i++; ?>
				<option value="<?php echo $key ?>" <?php if ( ( !empty(  $data ) && $data == $key ) || ( empty( $data ) && $i==1 ) ) { echo ' selected="selected"' ; } ?>><?php echo $option; ?></option>
				<?php } ?>
			</select>
		<?php
		break;


		//Textarea Option
		case 'textarea':
		?>
			<textarea style="direction:ltr; text-align:left; width:350px;" name="<?php echo $option_name ?>" id="<?php echo $value['id']; ?>" type="textarea" rows="3" tabindex="4"><?php echo $data;  ?></textarea>
		<?php
		break;


		//Upload Option
		case 'upload':
		?>
				<input id="<?php echo $value['id']; ?>" class="img-path" type="text" size="56" style="direction:ltr; text-align:left" name="<?php echo $option_name ?>" value="<?php echo $data; ?>" />
				<input id="upload_<?php echo $value['id']; ?>_button" type="button" class="button" value="<?php _e( 'Upload', 'kavkaz' )  ?>" />

				<?php if( isset( $value['extra_text'] ) ) : ?><span class="extra-text"><?php echo $value['extra_text'] ?></span><?php endif; ?>

				<div id="<?php echo $value['id']; ?>-preview" class="img-preview" <?php if( !$data ) echo 'style="display:none;"' ?>>
					<img src="<?php if( $data ) echo $data; else echo get_template_directory_uri().'/framework/admin/images/empty.png'; ?>" alt="" />
					<a class="del-img" title="Delete"></a>
				</div>
				<script type='text/javascript'>
					jQuery('#<?php echo $value['id']; ?>').change(function(){
						jQuery('#<?php echo $value['id']; ?>-preview').show();
						jQuery('#<?php echo $value['id']; ?>-preview img').attr("src", jQuery(this).val());
					});
					kavkaz_set_uploader( '<?php echo $value['id']; ?>' );
				</script>
		<?php
		break;


		//Slider Option
		case 'slider':
		?>
				<div id="<?php echo $value['id']; ?>-slider"></div>
				<input type="text" id="<?php echo $value['id']; ?>" value="<?php if( !empty( $data ) ) echo $data; elseif( !empty( $value['default'] ) ) echo $value['default']; else echo 0; ?>" name="<?php echo $option_name ?>" style="width:50px;" /> <?php echo $value['unit']; ?>
				<script>
				  jQuery(document).ready(function() {
					jQuery("#<?php echo $value['id']; ?>-slider").slider({
						range: "min",
						min: <?php echo $value['min']; ?>,
						max: <?php echo $value['max']; ?>,
						value: <?php if( !empty( $data ) ) echo $data; elseif( !empty( $value['default'] ) ) echo $value['default']; else echo 0; ?>,

						slide: function(event, ui) {
						jQuery('#<?php echo $value['id']; ?>').attr('value', ui.value );
						}
					});
				  });
				</script>
		<?php
		break;

		//Color Option
		case 'color':
		?>
			<div id="<?php echo $value['id']; ?>colorSelector" class="color-pic"><div style="background-color:<?php echo $data; ?>"></div></div>
			<input style="width:80px;"  name="<?php echo $option_name ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php echo $data ; ?>" />

			<script>
				jQuery('#<?php echo $value['id']; ?>colorSelector').ColorPicker({
					color: '<?php echo $data; ?>',
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						jQuery('#<?php echo $value['id']; ?>colorSelector div').css('backgroundColor', '#' + hex);
						jQuery('#<?php echo $value['id']; ?>').val('#'+hex);
					}
				});
				</script>
		<?php
		break;
	}
	?>
	<?php if( isset( $value['extra_text'] ) && $value['type'] != 'upload' ) : ?><span class="extra-text"><?php echo $value['extra_text'] ?></span><?php endif; ?>
	<?php if( isset( $value['help'] ) ) : ?>
		<a class="kavkaz-help kavkaz-tooltip"  title="<?php echo $value['help'] ?>"></a>
		<?php endif; ?>
		<?php if( isset( $value['tax'] ) ): ?>
		<script type="text/javascript">
		var <?php echo $value['id']; ?> = '#tax-input-<?php echo $value['id']; ?>';
		jQuery('#<?php echo $value['id']; ?>-item input, #<?php echo $value['id']; ?>-item textarea').keyup(function() {
			val = jQuery('#<?php echo $value['id']; ?>-item input, #<?php echo $value['id']; ?>-item textarea').val();
			jQuery('#tax-input-<?php echo $value['id']; ?>').html(val);
		});
		
		jQuery('#tagsdiv-<?php echo $value['id']; ?>').hide();
		</script>
		<?php endif; ?>		
	</div>
<?php
}

?>