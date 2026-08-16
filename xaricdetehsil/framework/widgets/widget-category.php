<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

##Category Posts ------------------------------------------ #
add_action( 'widgets_init', 'kavkaz_categort_posts_widget' );
function kavkaz_categort_posts_widget() {
	register_widget( 'kavkaz_categort_posts' );
}
class kavkaz_categort_posts extends WP_Widget {

	public function __construct(){
		$widget_ops 	= array( 'classname' => 'categort-posts' );
		$control_ops 	= array( 'width' => 250, 'height' => 350, 'id_base' => 'categort-posts-widget' );
		parent::__construct( 'categort-posts-widget', THEME_NAME .' - '.__( "Category Posts" , 'kavkaz' ) , $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title          = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$no_of_posts 	= $instance['no_of_posts'];
		$cats_id 		= $instance['cats_id'];
		$thumb 			= $instance['thumb'];
		$posts_count    = $instance['count'];

		echo $before_widget;
			echo $before_title;
			echo $title ; ?>
		<?php echo $after_title; ?>
				<ul class="widget-latest-posts">
					<?php kavkaz_last_posts_cat($no_of_posts , $thumb , $posts_count , $cats_id)?>
				</ul>
	<?php
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']       = ! empty( $new_instance['title'] )       ? $new_instance['title'] : false;
		$instance['no_of_posts'] = ! empty( $new_instance['no_of_posts'] ) ? $new_instance['no_of_posts'] : false;
		$instance['cats_id']     = ! empty( $new_instance['cats_id'] )     ? implode(',' , $new_instance['cats_id'] ) : false;
		$instance['thumb']       = ! empty( $new_instance['thumb'] )       ? $new_instance['thumb'] : false;
		$instance['count']       = ! empty( $new_instance['count'] )       ? $new_instance['count'] : false;
		return $instance;
	}

	public function form( $instance ) {
		$defaults = array( 'title' =>__( 'Category Posts' , 'kavkaz'), 'no_of_posts' => '5' , 'cats_id' => '1' , 'thumb' => 'true' , 'count' => 'true' );
		$instance = wp_parse_args( (array) $instance, $defaults );

		$categories_obj = get_categories();
		$categories 	= array();

		foreach ($categories_obj as $pn_cat) {
			$categories[$pn_cat->cat_ID] = $pn_cat->cat_name;
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'no_of_posts' ); ?>"><?php _e( 'Number of posts to show:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'no_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'no_of_posts' ); ?>" value="<?php echo $instance['no_of_posts']; ?>" type="text" size="3" />
		</p>
		<p>
			<?php $cats_id = explode ( ',' , $instance['cats_id'] ) ; ?>
			<label for="<?php echo $this->get_field_id( 'cats_id' ); ?>"><?php _e( 'Category:' , 'kavkaz') ?></label>
			<select multiple="multiple" id="<?php echo $this->get_field_id( 'cats_id' ); ?>[]" name="<?php echo $this->get_field_name( 'cats_id' ); ?>[]">
				<?php foreach ($categories as $key => $option) { ?>
				<option value="<?php echo $key ?>" <?php if ( in_array( $key , $cats_id ) ) { echo ' selected="selected"' ; } ?>><?php echo $option; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb' ); ?>"><?php _e( 'Display Thumbnails :' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'thumb' ); ?>" name="<?php echo $this->get_field_name( 'thumb' ); ?>" value="true" <?php if( $instance['thumb'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Display Count :' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="true" <?php if( $instance['count'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>
	<?php
	}
}
?>
