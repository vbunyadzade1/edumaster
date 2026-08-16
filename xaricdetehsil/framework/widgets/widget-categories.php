<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

##Category Posts ------------------------------------------ #
add_action( 'widgets_init', 'kavkaz_categories_widget' );
function kavkaz_categories_widget() {
	register_widget( 'kavkaz_categories' );
}
class kavkaz_categories extends WP_Widget {

	public function __construct(){
		$widget_ops 	= array( 'classname' => 'categories' );
		$control_ops 	= array( 'width' => 250, 'height' => 350, 'id_base' => 'categories-widget' );
		parent::__construct( 'categories-widget', THEME_NAME .' - '.__( "Categories" , 'kavkaz' ) , $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title      = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$count 			= $instance['count'];

		echo $before_widget;
			echo $before_title;
			echo $title ; ?>
		<?php echo $after_title; ?>
		<?php $cats = get_categories(); ?>
		<div class="sidebar-widget-content">
		<ul class="sidebar-widget-cate-list">
		<?php foreach( $cats as $cat ): ?>
        <li>
        <a href="<?php echo get_category_link( $cat->cat_ID ); ?>">
		<span class="text">
		<?php echo $cat->cat_name; ?>
		</span>
		<?php if( $count ): ?>
		<span class="count"><?php echo $cat->count; ?></span>
		<?php endif; ?>
	    </a>
        </li>
		<?php endforeach; ?>
        </ul>
		</div>
	<?php
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']       = ! empty( $new_instance['title'] )       ? $new_instance['title'] : false;
		$instance['count']       = ! empty( $new_instance['count'] )       ? $new_instance['count'] : false;
		return $instance;
	}

	public function form( $instance ) {
		$defaults = array( 'title' =>__( 'Categories' , 'kavkaz'), 'cats_id' => '1' , 'count' => 'true' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Display count :' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="true" <?php if( $instance['count'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>

	<?php
	}
}
?>
