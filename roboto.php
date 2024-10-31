<?php
/*
Plugin Name: Robo.to widget
Plugin URI: http://blog.iandundas.co.uk/2009/08/robo-to-wordpress-widget/
Version: 1.0
Author: Ian Dundas
Description: Displays your latest robo.to video as a widget on your blog
 */

add_action('widgets_init', 'roboto_load_widgets');

function roboto_load_widgets() {

    if ( !function_exists('register_sidebar_widget') )
            return;

    register_widget( 'Roboto_Widget' );
}

class Roboto_Widget extends WP_Widget {
    function Roboto_Widget()
    {
        /* Widget settings. */
        $widget_ops = array( 'classname' => 'roboto', 'description' => 'An example widget for robo.to' );

        /* Widget control settings. */
        $control_ops = array( 'height' => 300, 'id_base' => 'roboto-widget' );

        /* Create the widget. */
        $this->WP_Widget( 'roboto-widget', 'Roboto Widget', $widget_ops, $control_ops );

    }

    function widget( $args, $instance ) {
            extract( $args );

            /* User-selected settings. */
            $title = apply_filters('widget_title', $instance['title'] );
            $roboto_id      = $instance['roboto_id'];
            $roboto_uuid    = $instance['roboto_uuid'];
            $roboto_width   = $instance['roboto_width'];
            $roboto_height  = $instance['roboto_height'];

            $roboto_style   = "height:{$roboto_height}px; width:{$roboto_width}px;".$instance['roboto_style']; //"border:1px solid #111; padding:1px; height:{$roboto_height}px; width:{$roboto_width}px; display:block; ";
            $roboto_url     = "http://robo.to/swf/smirk.swf?href=http://robo.to/{$roboto_id}&sName=SmirksController&fx=1&hideBlerb=0&target=_blank&loop=1&cURI=rtmp://robo.to/smirk_ul&sURL=http://robo.to/amf/gateway&uuid={$roboto_uuid}";

            /* Before widget (defined by themes). */
            echo $before_widget;

            /* Title of widget (before and after defined by themes). */
            if ( $title )
                    echo $before_title . $title . $after_title;
        
            ?>	<!-- wordpress robo.to widget by Ian Dundas: http://b.id8.eu/?p=409 -->
                <object width="<?php echo $roboto_width ?>" height="<?php echo $roboto_height ?>" style="<?php echo $roboto_style ?>">
                    <param name="movie" value="<?php echo $roboto_url ?>"></param>
                    <param name="allowFullScreen" value="true"></param>
                    <param name="allowscriptaccess" value="always"></param>
                    <embed src="<?php echo $roboto_url ?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="<?php echo $roboto_width ?>" height="<?php echo $roboto_height ?>"></embed>
                </object>
            <?php
            
            /* After widget (defined by themes). */
            echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            /* Strip tags (if needed) and update the widget settings. */
            $instance['title'] = strip_tags( $new_instance['title'] );
            $instance['roboto_id'] = strip_tags( $new_instance['roboto_id'] );
            $instance['roboto_uuid'] = strip_tags( $new_instance['roboto_uuid'] );
            $instance['roboto_height'] = strip_tags( $new_instance['roboto_height'] );
            $instance['roboto_width'] = strip_tags( $new_instance['roboto_width'] );
            $instance['roboto_style'] = strip_tags( $new_instance['roboto_style'] );

            return $instance;
    }


    function form( $instance )
    {

		/* Set up some default widget settings. */
                $defaults = array(  'title' => 'Robo.to',
                                    'roboto_id' => '',
                                    'roboto_uuid' => '',
                                    'roboto_height' => '180',
                                    'roboto_width' => '180',
                                    'roboto_style'=>"border:1px solid #111; padding:1px; display:block; "
                                );

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>



		<p>
			<label for="<?php echo $this->get_field_id( 'roboto_width' ); ?>">Width (px):</label>
			<input id="<?php echo $this->get_field_id( 'roboto_width' ); ?>" name="<?php echo $this->get_field_name( 'roboto_width' ); ?>" value="<?php echo $instance['roboto_width']; ?>" style="width:100%;" />
		</p>


		<p>
			<label for="<?php echo $this->get_field_id( 'roboto_height' ); ?>">Height (px):</label>
			<input id="<?php echo $this->get_field_id( 'roboto_height' ); ?>" name="<?php echo $this->get_field_name( 'roboto_height' ); ?>" value="<?php echo $instance['roboto_height']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'roboto_style' ); ?>">Height (px):</label>
			<input id="<?php echo $this->get_field_id( 'roboto_style' ); ?>" name="<?php echo $this->get_field_name( 'roboto_style' ); ?>" value="<?php echo $instance['roboto_style']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'roboto_id' ); ?>">Your Robo.to username:</label>
			<input id="<?php echo $this->get_field_id( 'roboto_id' ); ?>" name="<?php echo $this->get_field_name( 'roboto_id' ); ?>" value="<?php echo $instance['roboto_id']; ?>" style="width:100%;" />
		</p>


		<p>     To find the UUID, login at <a href="http://robo.to">Robo.to</a> and click 'Share My Face'. 
                        <br />It's the code at the bottom, e.g.:
                        <br /><b>'<em style="font-size:0.7em">88213a1c45127cb0a0a1d4621c0029434c310b5c</em>'</b>
                        <br />

			<label for="<?php echo $this->get_field_id( 'roboto_uuid' ); ?>">Your Robo.to uuid:</label>
			<input id="<?php echo $this->get_field_id( 'roboto_uuid' ); ?>" name="<?php echo $this->get_field_name( 'roboto_uuid' ); ?>" value="<?php echo $instance['roboto_uuid']; ?>" style="width:100%;" />
		</p>


    <?php
    }
}
?>
