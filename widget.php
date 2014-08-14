<?
/*
 * Plugin Name: qiita widget
 * Author: Hinaloe
 * Plugin URI: http://qiita.com/kimama1997/items/3b78ffe5a1a0041cf93b
 * Description: Simple Qiita Widget
 * Author URI: http://hinaloe.net/
 * Version: 0.0.3
 * Licence: GPL2
*/

/**
 *
 * Qiita Widget
 * @link http://qiita.com/kimama1997/items/3b78ffe5a1a0041cf93b
 */

/**
 * Do you use included js?
 *	if you won't use our script, please set false and
 * use own script build with "qiita-widget.coffee".
 */
defined("QW_INCLUDE_JS") or define("QW_INCLUDE_JS" , true);

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
			?><div data-qiita-widget="true" data-name="<?=$instance['url_name'] ?>"<? if(isset($instance['count'])&&!empty($instance['count'])){?>data-count="<?=$instance['count']?>"<?} ?>></div><?
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
		}
		else {
			$title = "Qiita Widget";
		}
		if ( isset( $instance[ 'url_name' ]))
		{
			$url_name = $instance['url_name'];
		}
		else
		{
			$url_name = "";
		}
		if ( isset( $instance[ 'count' ]))
		{
			$count = $instance[ 'count' ];
		}
		else
		{
			$count = "";
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
		<p>
			<label for="<?= $this->get_field_id('count') ?>"><? _e('Count:'); ?></label>
			<input type="number" class="widefat" id="<?= $this->get_field_id('count')?>" name="<?= $this->get_field_name('count')?>" value="<?= esc_attr( $count ) ?>">
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
		$instance['count'] = ( ! empty( $new_instance['count'] )) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;

	}
}
add_action( 'widgets_init', function(){
     register_widget( 'Qiita_Widget' );
});


add_filter( 'clean_url', function( $url )
{
    if ( FALSE === strpos( $url, '.js?async' ) )
    { // not our file
    return $url;
    }
    // Must be a ', not "!
    return "$url' async='async";
}, 11, 1 );


if (!defined("QW_INCLUDE_JS") or QW_INCLUDE_JS )
add_action( 'wp_enqueue_scripts', function(){
wp_enqueue_script('qiita_widget', plugins_url(null,__FILE__) . "/widget.js?async",null,null,true);
} );
