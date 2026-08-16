<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

##ASD 300*100 ------------------------------------------ #
add_action( 'widgets_init', 'ads300_100_widget_box' );
function ads300_100_widget_box() {
	register_widget( 'ads300_100_widget' );
}

class ads300_100_widget extends WP_Widget {

	public function __construct(){
		$widget_ops = array( 'classname' => 'e3lan e3lan300_100-widget', 'description' => ''  );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'ads300_100-widget' );
		parent::__construct( 'ads300_100-widget',THEME_NAME .' - '.__( 'Ads 300*100' ) , $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title      = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$tran_bg    = ! empty( $instance['tran_bg'] )    ? true : false;
		$new_window = ! empty( $instance['new_window'] ) ? ' target="_blank" ' : '';
		$nofollow   = ! empty( $instance['nofollow'] )   ? 'rel="nofollow"'    : '';

		if( !$tran_bg ){
			echo $before_widget;
			echo $before_title;
			echo $title ;
			echo $after_title;
		}?>
		<div <?php if( $tran_bg ) echo 'id="'.$args['widget_id'].'"'; ?> class="e3lan-widget-content e3lan300-100">
		<?php for($i=1 ; $i<4 ; $i++ ){ ?>
			<?php if( !empty($instance[ 'ads'.$i.'_code' ])  ){ ?>
			<div class="e3lan-cell">
				<?php echo do_shortcode( $instance[ 'ads'.$i.'_code' ] ); ?>

			</div>
		<?php } elseif( !empty($instance[ 'ads'.$i.'_img' ])  ){ ?>
			<div class="e3lan-cell">
				<?php if( $instance[ 'ads'.$i.'_url' ] ){ ?><a href="<?php echo $instance[ 'ads'.$i.'_url' ] ?>" <?php echo $new_window ?> <?php echo $nofollow ?>><?php } ?>
					<img src="<?php echo $instance[ 'ads'.$i.'_img' ] ?>" alt="" />
				<?php if( $instance[ 'ads'.$i.'_url' ] ){ ?></a><?php } ?>
			</div>
		<?php
			}
		} ?>
		</div>
	<?php
		if( !$tran_bg )
			echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title']      = ! empty( $new_instance['title'] )      ? $new_instance['title']      : '';
		$instance['tran_bg']    = ! empty( $new_instance['tran_bg'] )    ? $new_instance['tran_bg']    : '';
		$instance['new_window'] = ! empty( $new_instance['new_window'] ) ? $new_instance['new_window'] : '';
		$instance['one_column'] = ! empty( $new_instance['one_column'] ) ? $new_instance['one_column'] : '';
		$instance['nofollow']   = ! empty( $new_instance['nofollow'] )   ? $new_instance['nofollow']   : '';

		for($i=1 ; $i<5 ; $i++ ){
			$instance['ads'.$i.'_img']  = ! empty( $new_instance['ads'.$i.'_img'] )  ? $new_instance['ads'.$i.'_img']  : '';
			$instance['ads'.$i.'_url']  = ! empty( $new_instance['ads'.$i.'_url'] )  ? $new_instance['ads'.$i.'_url']  : '';
			$instance['ads'.$i.'_code'] = ! empty( $new_instance['ads'.$i.'_code'] ) ? $new_instance['ads'.$i.'_code'] : '';
		}

		return $instance;
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __(' Advertisement', 'kavkaz') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php if( !empty( $instance['title'] ) ) echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tran_bg' ); ?>"><?php _e( 'Content Only:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'tran_bg' ); ?>" name="<?php echo $this->get_field_name( 'tran_bg' ); ?>" value="true" <?php if( !empty( $instance['tran_bg'] ) ) echo 'checked="checked"'; ?> type="checkbox" />
			<br /><small><?php _e( 'Check this box to hide widget title and background.' , 'kavkaz') ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'new_window' ); ?>"><?php _e( 'Open links in a new window:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'new_window' ); ?>" name="<?php echo $this->get_field_name( 'new_window' ); ?>" value="true" <?php if( !empty( $instance['new_window'] ) ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'nofollow' ); ?>"><?php _e( 'Nofollow:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'nofollow' ); ?>" name="<?php echo $this->get_field_name( 'nofollow' ); ?>" value="true" <?php if( !empty( $instance['nofollow'] ) ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>
		<?php
		for($i=1 ; $i<4 ; $i++ ){ ?>
		<em style="display:block; border-bottom:1px solid #CCC; margin:20px 0 5px; font-weight:bold"><?php _e( 'ADS' , 'kavkaz') ?> <?php echo $i; ?> :</em>
		<p>
			<label for="<?php echo $this->get_field_id( 'ads'.$i.'_img' ); ?>"><?php printf( __( 'Ads %s image path:', 'kavkaz' ), $i ) ?></label>
			<input id="<?php echo $this->get_field_id( 'ads'.$i.'_img' ); ?>" name="<?php echo $this->get_field_name( 'ads'.$i.'_img' ); ?>" value="<?php  if( !empty( $instance['ads'.$i.'_img'] ) ) echo $instance['ads'.$i.'_img']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'ads'.$i.'_url' ); ?>"><?php printf( __( 'Ads %s Link:', 'kavkaz' ), $i ) ?></label>
			<input id="<?php echo $this->get_field_id( 'ads'.$i.'_url' ); ?>" name="<?php echo $this->get_field_name( 'ads'.$i.'_url' ); ?>" value="<?php if( !empty( $instance['ads'.$i.'_url'] ) ) echo $instance['ads'.$i.'_url']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'ads'.$i.'_code' ); ?>"><?php printf( __( 'Ads %s Adsense code:', 'kavkaz' ), $i ) ?></label>
			<textarea id="<?php echo $this->get_field_id( 'ads'.$i.'_code' ); ?>" name="<?php echo $this->get_field_name( 'ads'.$i.'_code' ); ?>" class="widefat" ><?php if( !empty( $instance['ads'.$i.'_code'] ) ) echo $instance['ads'.$i.'_code']; ?></textarea>
		</p>
		<?php } ?>
	<?php
	}
}

##ASD 300*250 ------------------------------------------ #
add_action( 'widgets_init', 'ads300_250_widget_box' );
function ads300_250_widget_box() {
	register_widget( 'ads300_250_widget' );
}

class ads300_250_widget extends WP_Widget {

	public function __construct(){
		$widget_ops = array( 'classname' => 'e3lan e3lan300_250-widget', 'description' => ''  );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'ads300_250-widget' );
		parent::__construct( 'ads300_250-widget',THEME_NAME .' - '.__( 'Ads 300*250', 'kavkaz' ) , $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title      = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$tran_bg    = ! empty( $instance['tran_bg'] )    ? true : false;
		$new_window = ! empty( $instance['new_window'] ) ? ' target="_blank" ' : '';
		$nofollow   = ! empty( $instance['nofollow'] )   ? 'rel="nofollow"'    : '';

		if( !$tran_bg ){
			echo $before_widget;
			echo $before_title;
			echo $title ;
			echo $after_title;
		}?>
		<div <?php if( $tran_bg ) echo 'id="'.$args['widget_id'].'"'; ?> class="e3lan-widget-content e3lan300-250">
		<?php $i=1 ; ?>
			<?php if( !empty($instance[ 'ads'.$i.'_code' ])  ){ ?>
			<div class="e3lan-cell">
				<?php echo do_shortcode( $instance[ 'ads'.$i.'_code' ] ); ?>

			</div>
		<?php } elseif( !empty($instance[ 'ads'.$i.'_img' ])  ){ ?>
			<div class="e3lan-cell">
				<?php if( $instance[ 'ads'.$i.'_url' ] ){ ?><a href="<?php echo $instance[ 'ads'.$i.'_url' ] ?>" <?php echo $new_window ?> <?php echo $nofollow ?>><?php } ?>
					<img src="<?php echo $instance[ 'ads'.$i.'_img' ] ?>" alt="" />
				<?php if( $instance[ 'ads'.$i.'_url' ] ){ ?></a><?php } ?>
			</div>
		<?php
			}
		?>
		</div>
	<?php
		if( !$tran_bg )
			echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title']      = ! empty( $new_instance['title'] )      ? $new_instance['title']      : '';
		$instance['tran_bg']    = ! empty( $new_instance['tran_bg'] )    ? $new_instance['tran_bg']    : '';
		$instance['new_window'] = ! empty( $new_instance['new_window'] ) ? $new_instance['new_window'] : '';
		$instance['one_column'] = ! empty( $new_instance['one_column'] ) ? $new_instance['one_column'] : '';
		$instance['nofollow']   = ! empty( $new_instance['nofollow'] )   ? $new_instance['nofollow']   : '';

		$i=1 ;
		$instance['ads'.$i.'_img']  = ! empty( $new_instance['ads'.$i.'_img'] )  ? $new_instance['ads'.$i.'_img']  : '';
		$instance['ads'.$i.'_url']  = ! empty( $new_instance['ads'.$i.'_url'] )  ? $new_instance['ads'.$i.'_url']  : '';
		$instance['ads'.$i.'_code'] = ! empty( $new_instance['ads'.$i.'_code'] ) ? $new_instance['ads'.$i.'_code'] : '';

		return $instance;
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __(' Advertisement', 'kavkaz') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php if( !empty( $instance['title'] ) ) echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tran_bg' ); ?>"><?php _e( 'Content Only:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'tran_bg' ); ?>" name="<?php echo $this->get_field_name( 'tran_bg' ); ?>" value="true" <?php if( !empty( $instance['tran_bg'] ) ) echo 'checked="checked"'; ?> type="checkbox" />
			<br /><small><?php _e( 'Check this box to hide widget title and background.' , 'kavkaz') ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'new_window' ); ?>"><?php _e( 'Open links in a new window:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'new_window' ); ?>" name="<?php echo $this->get_field_name( 'new_window' ); ?>" value="true" <?php if( !empty( $instance['new_window'] ) ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'nofollow' ); ?>"><?php _e( 'Nofollow:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'nofollow' ); ?>" name="<?php echo $this->get_field_name( 'nofollow' ); ?>" value="true" <?php if( !empty( $instance['nofollow'] ) ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>
		<?php $i=1 ?>
		<em style="display:block; border-bottom:1px solid #CCC; margin:20px 0 5px; font-weight:bold"><?php _e( 'ADS:' , 'kavkaz') ?></em>
		<p>
			<label for="<?php echo $this->get_field_id( 'ads'.$i.'_img' ); ?>"><?php _e( 'Ads image path:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'ads'.$i.'_img' ); ?>" name="<?php echo $this->get_field_name( 'ads'.$i.'_img' ); ?>" value="<?php  if( !empty( $instance['ads'.$i.'_img'] ) ) echo $instance['ads'.$i.'_img']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'ads'.$i.'_url' ); ?>"><?php _e( 'Ads Link:', 'kavkaz' ) ?></label>
			<input id="<?php echo $this->get_field_id( 'ads'.$i.'_url' ); ?>" name="<?php echo $this->get_field_name( 'ads'.$i.'_url' ); ?>" value="<?php if( !empty( $instance['ads'.$i.'_url'] ) ) echo $instance['ads'.$i.'_url']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'ads'.$i.'_code' ); ?>"><?php _e( ' Ads Adsense code:', 'kavkaz' ) ?></label>
			<textarea id="<?php echo $this->get_field_id( 'ads'.$i.'_code' ); ?>" name="<?php echo $this->get_field_name( 'ads'.$i.'_code' ); ?>" class="widefat" ><?php if( !empty( $instance['ads'.$i.'_code'] ) ) echo $instance['ads'.$i.'_code']; ?></textarea>
		</p>
	<?php
	}
}

?>
