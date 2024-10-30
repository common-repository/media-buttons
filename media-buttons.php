<?php
/**
 * Plugin Name: Media Buttons
 * Plugin URI: http://www.avefm.net
 * Description: A widget to display buttons of a specific streaming
 * Version: 1.0 
 * Author: César Araújo
 * Author URI: http://cesararaujo.net
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
error_reporting(-1);

add_action( 'widgets_init', 'media_buttons_load_widgets' );

/**
 * Register our widget.
 * 'media_buttons_Widget' is the widget class used below.
 */
function media_buttons_load_widgets() {
	register_widget( 'media_buttons_Widget' );
}

/**
 * mb Status Widget class.
 */
error_reporting(1);

class media_buttons_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function media_buttons_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'mbstatus', 'description' => __('Create playlist for several audio players.', 'mbstatus') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'mb-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'mb-widget', __('Media Buttons', 'mbstatus'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$server1 = $instance['servername1'];
		$mount1= $instance['mount1'];
		$server2 = $instance['servername2'];
		$mount2= $instance['mount2'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		 if ( $title ){
			echo $before_title . $title . $after_title; 
		}
$imgwidth=43;
$imgmrg=5;

		if($server1){
			echo '<div id="l1" style="display: inline-block; height:'. $imgwidth .'px;">
						<a href="#">
							<img src="'. plugin_dir_url('media-buttons' ) . '/media-buttons/flash.png" width="'. $imgwidth .'px" height="'. $imgwidth .'px" >
						</a>
						<a href="'. plugin_dir_url('media-buttons' ) . '/media-buttons/playlist.php?ip='.$server1.'&mountpoint='.$mount1.'&format=ASX">
							<img src="'. plugin_dir_url('media-buttons' ) . '/media-buttons/wmplay.png" width="'. $imgwidth .'px" height="'. $imgwidth .'px"  style="margin-left:'. $imgmrg .'px;" />
						</a>
					
						<a href="'. plugin_dir_url('media-buttons' ) . '/media-buttons/playlist.php?ip='.$server1.'&mountpoint='.$mount1.'&format=M3U">
							<img src="'. plugin_dir_url('media-buttons' ) . '/media-buttons/winamp.png" width="'. $imgwidth .'px" height="'. $imgwidth .'px" style="margin-left:'. $imgmrg .'px;" />
						</a>
						
						<a href="'. plugin_dir_url('media-buttons' ) . '/media-buttons/playlist.php?ip='.$server1.'&mountpoint='.$mount1.'&format=PLS">
							<img src="'. plugin_dir_url('media-buttons' ) . '/media-buttons/itunes.png" width="'. $imgwidth .'px" height="'. $imgwidth .'px" style="margin-left:'. $imgmrg .'px;" />
						</a>
						
						<a href="'. plugin_dir_url('media-buttons' ) . '/media-buttons/playlist.php?ip='.$server1.'&mountpoint='.$mount1.'&format=RAM">
							<img src="'. plugin_dir_url('media-buttons' ) . '/media-buttons/real.png" width="'. $imgwidth .'px" height="'. $imgwidth .'px" style="margin-left:'. $imgmrg .'px;" />
						</a>
					</div>';		
		}

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		/* Necessary for form data persistance. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['servername1'] = strip_tags( $new_instance['servername1'] );
		$instance['servername2'] = strip_tags( $new_instance['servername2'] );
		$instance['mount1'] = strip_tags( $new_instance['mount1'] );
		$instance['mount2'] = strip_tags( $new_instance['mount2'] );
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
			'title' => __('AveFm', 'mbstatus'),
			'servername1' => __('127.0.0.1:8000', 'mbstatus'),
			'servername2' => __('127.0.0.1:8000', 'mbstatus'),
			'mount1' => __('/ices', 'mbstatus'),
			'mount2' => __('/mpd', 'mbstatus')
			);


		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	      <!-- Widget Title: Text Input -->
                <p>
                        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
                        <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
                </p>


		<!-- Server Name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'servername1' ); ?>"><?php _e('server name:port', 'mbstatus'); ?></label>
			<input id="<?php echo $this->get_field_id( 'servername1' ); ?>" name="<?php echo $this->get_field_name( 'servername1' ); ?>" value="<?php echo $instance['servername1']; ?>" style="width:100%;" />
		</p>
		
		<!-- Mount: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'mount1' ); ?>"><?php _e('mount 1:', 'mbstatus'); ?></label>
			<input id="<?php echo $this->get_field_id( 'mount1' ); ?>" name="<?php echo $this->get_field_name( 'mount1' ); ?>" value="<?php echo $instance['mount1']; ?>" style="width:100%;" />
		</p>
			<p>
			<label for="<?php echo $this->get_field_id( 'servername2' ); ?>"><?php _e('server2 name:port', 'mbstatus'); ?></label>
			<input id="<?php echo $this->get_field_id( 'servername2' ); ?>" name="<?php echo $this->get_field_name( 'servername2' ); ?>" value="<?php echo $instance['servername2']; ?>" style="width:100%;" />
		</p>
		
		<!-- Mount: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'mount2' ); ?>"><?php _e('mount 2:', 'mbstatus'); ?></label>
			<input id="<?php echo $this->get_field_id( 'mount2' ); ?>" name="<?php echo $this->get_field_name( 'mount2' ); ?>" value="<?php echo $instance['mount2']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>
