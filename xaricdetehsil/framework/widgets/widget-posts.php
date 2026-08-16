<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

##Posts ------------------------------------------ #
add_action( 'widgets_init', 'kavkaz_posts_list_widget' );
function kavkaz_posts_list_widget() {
	register_widget( 'kavkaz_posts_list' );
}
class kavkaz_posts_list extends WP_Widget {

	public function __construct(){
		$widget_ops 	= array( 'classname' => 'posts-list'  );
		$control_ops 	= array( 'width' => 250, 'height' => 350, 'id_base' => 'posts-list-widget' );
		parent::__construct( 'posts-list-widget',THEME_NAME .' - '. __( 'Latest Posts' , 'kavkaz'), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title      = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$no_of_posts 	= $instance['no_of_posts'];
		$posts_order 	= $instance['posts_order'];

		echo $before_widget;
			echo $before_title;
			echo $title ; ?>
		<?php echo $after_title; ?>
		<ul class="widget-latest-posts">
		<?php

		if( $posts_order == 'latest' ){
			kavkaz_last_posts($no_of_posts);
		}elseif( $posts_order == 'random' ){
			kavkaz_random_posts($no_of_posts);
		}elseif( $posts_order == 'popular' ){
			kavkaz_popular_posts($no_of_posts);
		}elseif( $posts_order == 'views' ){
			kavkaz_most_viewed($no_of_posts);
		}else {
			kavkaz_last_posts($no_of_posts);
		}

		?>

	</ul>
	<?php
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']       = ! empty( $new_instance['title'] )       ? $new_instance['title']       : false;
		$instance['no_of_posts'] = ! empty( $new_instance['no_of_posts'] ) ? $new_instance['no_of_posts'] : false;
		$instance['posts_order'] = ! empty( $new_instance['posts_order'] ) ? $new_instance['posts_order'] : false;
		return $instance;
	}

	public function form( $instance ) {
		$defaults = array( 'title' =>__('Latest Posts' , 'kavkaz') , 'no_of_posts' => '5' , 'posts_order' => 'latest' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php if( !empty($instance['posts_order']) ) echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'no_of_posts' ); ?>"><?php _e( 'Number of posts to show:' , 'kavkaz') ?></label>
			<input id="<?php echo $this->get_field_id( 'no_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'no_of_posts' ); ?>" value="<?php if( !empty($instance['no_of_posts']) ) echo $instance['no_of_posts']; ?>" type="text" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_order' ); ?>"><?php _e( 'Posts order' , 'kavkaz') ?></label>
			<select id="<?php echo $this->get_field_id( 'posts_order' ); ?>" name="<?php echo $this->get_field_name( 'posts_order' ); ?>" >
				<option value="latest" <?php if( !empty($instance['posts_order']) && $instance['posts_order'] == 'latest' ) echo "selected=\"selected\""; else echo ""; ?>><?php _e( 'Most recent' , 'kavkaz') ?></option>
				<option value="random" <?php if( !empty($instance['posts_order']) && $instance['posts_order'] == 'random' ) echo "selected=\"selected\""; else echo ""; ?>><?php _e( 'Random' , 'kavkaz') ?></option>
				<option value="popular" <?php if( !empty($instance['posts_order']) && $instance['posts_order'] == 'popular' ) echo "selected=\"selected\""; else echo ""; ?>><?php _e( 'Popular / Comments' , 'kavkaz') ?></option>
				<option value="views" <?php if( !empty($instance['posts_order']) && $instance['posts_order'] == 'views' ) echo "selected=\"selected\""; else echo ""; ?>><?php _e( 'Popular / Views' , 'kavkaz') ?></option>
			</select>
		</p>
	<?php
	}
}
