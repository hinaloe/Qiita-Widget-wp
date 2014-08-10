<?
/*
Plugin Name: qiita widget
Author: Hinaloe
*/

/**
 *
 * Qiita Widget
 * @link http://qiita.com/kimama1997/items/3b78ffe5a1a0041cf93b
 */

/**
 * Class Qiita_Widget
 *
 * @author hinaloe
 */
class Qiita_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		// widget actual processes
		parent::__construct('qiita_widget',"Qiita Widget",array("description"=>"Qiita Widget on your WP site!"));
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];
			?><div data-qiita-widget="true" data-name="<?=$instance['url_name'] ?>"></div><?
			echo $args['after_widget'];


	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
			$url_name = $instance['url_name'];
		}
		else {
			$title = "Qiita Widget";
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?= $this->get_field_id('url_name') ?>"><? _e('Username:'); ?></label>
			<input type="text" class="widefat" id="<?= $this->get_field_id('url_name') ?>" name="<?= $this->get_field_name('url_name') ?>" value="<?= esc_attr( $url_name) ?>" placeholder="url-name">
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['url_name'] = ( ! empty( $new_instance['url_name'] )) ? strip_tags( $new_instance['url_name'] ) : '';

		return $instance;

	}
}
add_action( 'widgets_init', function(){
     register_widget( 'Qiita_Widget' );
});

wp_register_script("qiita_widget", plugins_url(null,__FILE__) . "/widget.js?async",null,null,true);

add_filter( 'clean_url', function( $url )
{
    if ( FALSE === strpos( $url, '.js?async' ) )
    { // not our file
    return $url;
    }
    // Must be a ', not "!
    return "$url' async='async";
}, 11, 1 );



add_action( 'wp_enqueue_scripts', function(){
wp_enqueue_script('qiita_widget');
} );
