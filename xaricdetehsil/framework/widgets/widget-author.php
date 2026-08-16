<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

## Author Widget
add_action( 'widgets_init', 'kavkaz_Author_widget_box' );
function kavkaz_Author_widget_box(){
	register_widget( 'kavkaz_author_widget' );
}
class kavkaz_author_widget extends WP_Widget {

	public function __construct(){
		$widget_ops = array( 'classname' => 'widget_author' );
		parent::__construct( 'author_widget',THEME_NAME .' - '.__( 'Post Author' , 'kavkaz' ) , $widget_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		if ( is_single() ) :

		wp_reset_query();

		$avatar = $instance['avatar'];
		$social = $instance['social'];

		echo $before_widget;

		kavkaz_author_box_widget( $avatar , $social );

		echo $after_widget;
		endif;
	}


	public function update( $new_instance, $old_instance ) {
		$instance 			= $old_instance;
		$instance['avatar'] = ! empty( $new_instance['avatar'] ) ? $new_instance['avatar'] : false;
		$instance['social'] = ! empty( $new_instance['social'] ) ? $new_instance['social'] : false;
		return $instance;
	}

	public function form( $instance ) {
		$defaults = array( 'avatar' => 'true' , 'social' => 'true' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p><em style="color:red;"><?php _e( 'This Widget appears in single post only.' , 'kavkaz') ?></em></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'avatar' ); ?>"><?php _e( "Author's avatar:" , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'avatar' ); ?>" name="<?php echo $this->get_field_name( 'avatar' ); ?>" value="true" <?php if( $instance['avatar'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'social' ); ?>"><?php _e( 'Social icons:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'social' ); ?>" name="<?php echo $this->get_field_name( 'social' ); ?>" value="true" <?php if( $instance['social'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>

	<?php
	}
}

?>
