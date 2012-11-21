<?php
/**
 * Widget Name
 */

class MAB_Widget extends WP_Widget{

	/**
	 * Prefix for the widget.
	 * @since 0.1
	 */
	var $prefix;

	/**
	 * Textdomain for the widget.
	 * @since 0.1
	 */
	var $textdomain;
	
	/**
	 * ID for the widget
	 */
	 var $widget_id;
	 
	function  MAB_Widget(){

		$this->textdomain = MAB_DOMAIN;
		
		$this->widget_id = 'mab-widget';
		
		$widget_options = array(
						'classname' => "mab-widget",
						'description' => esc_html__( 'Display your action boxes on the sidebar or any widget areas.', $this->textdomain )
					);
		
		$control_options = array(
						'height' => '300',
						'width' => '240',
						'id_base' => "{$this->widget_id}"
					);
		
		$this->WP_Widget( $this->widget_id, esc_attr__( 'Magic Action Box Widget', $this->textdomain ), $widget_options, $control_options );
		
	}
	
	function form( $instance ){
		//setup default values
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = isset( $instance['title'] ) ?esc_attr($instance['title']) : '';
		$selected_action_box = isset( $instance['actionbox-id'] ) ? $instance['actionbox-id'] : '';
		$textdomain = $this->textdomain;
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', $textdomain); ?></label>
			<input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('actionbox-id'); ?>"><?php _e('Action box to display:',MAB_DOMAIN);?></label>
			<select name="<?php echo $this->get_field_name('actionbox-id'); ?>" class="widefat">
				<?php
				global $MabBase;
				/** Get available actionboxes **/
				$mab = get_posts( array( 'numberposts' => -1, 'orderby' => 'title date', 'post_type' =>$MabBase->get_post_type()) );
				foreach( $mab as $box ):
				?>
					<option value="<?php echo $box->ID; ?>" <?php selected( $selected_action_box, $box->ID ); ?>><?php echo $box->post_title; ?></option>
				<?php endforeach;?>
			</select>
			<br/>
			<small><?php _e('Select an action box to display on your widget area.',MAB_DOMAIN); ?></small>
		</p>

		<?php
	}
	
	function update( $new_instance, $old_instance ){
		$instance['title'] = esc_attr( $new_instance['title'] );
		$instance['actionbox-id'] = esc_attr( $new_instance['actionbox-id'] );
		return $instance;
	}
	
	function widget( $args, $instance){
		extract( $args );
		$unique_id = $args['widget_id'];
		$title = $instance['title'];
		$action_box_id= isset($instance['actionbox-id']) ?$instance['actionbox-id'] : false;

		$textdomain = $this->textdomain;
		
		?>
		<?php echo $before_widget; ?>
		
		<?php
		/* If a title was input by the user, display it. */
		if ( !empty( $title ) ){ 
			echo $before_title . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $after_title;
		} ?>
		
		<div class="mab-inside-wrap">
		<?php if( $action_box_id ===false ): ?>
			<!-- display notice -->
			Magic Action Box widget not configured correctly. Please select an action box to display from the <a href="<?php echo admin_url('widgets.php'); ?>">widgets settings</a>.
		<?php else: ?>
			
			<?php echo mab_get_actionbox($action_box_id); ?>
			
		<?php endif; ?>
		</div>
		
		<?php echo $after_widget; ?>
		
	<?php
	}

}

