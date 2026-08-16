<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

##Category Posts ------------------------------------------ #
add_action( 'widgets_init', 'kavkaz_tags_widget' );
function kavkaz_tags_widget() {
	register_widget( 'kavkaz_tags' );
}
class kavkaz_tags extends WP_Widget {

	public function __construct(){
		$widget_ops 	= array( 'classname' => 'tags' );
		$control_ops 	= array( 'width' => 250, 'height' => 350, 'id_base' => 'tags-widget' );
		parent::__construct( 'tags-widget', THEME_NAME .' - '.__( "Tags" , 'kavkaz' ) , $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title      = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $before_widget;
			echo $before_title;
			echo $title ; ?>
		<?php echo $after_title; ?>
		<?php $tags = get_tags(); ?>
		<div class="sidebar-widget-content">
        <div class="tagcloud">
		<?php foreach( $tags as $tag ): ?>
        <a href="<?php echo get_term_link( $tag->term_id ); ?>"><?php echo $tag->name; ?></a>
		<?php endforeach; ?>
        </div>
		</div>
	<?php
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']       = ! empty( $new_instance['title'] )       ? $new_instance['title'] : false;
		return $instance;
	}

	public function form( $instance ) {
		$defaults = array( 'title' =>__( 'Tags' , 'kavkaz'), 'cats_id' => '1' , 'count' => 'true' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>

	<?php
	}
}
?>
