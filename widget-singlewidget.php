<?php

//////////////////////////////////////////////
// Single Widget: display a single project. //
//////////////////////////////////////////////

class CUUSOOList_SingleWidget extends CUUSOOList_Widget
{

	private   $widget_title = 'CUUSOO List - Single';
	protected $template     = 'widget-cuusoolist-single.php';


	function __construct()
	{
		// see http://docs.layerswp.com/doc/notice-the-called-constructor-method-for-wp_widget-is-deprecated-since-version-4-3-0-use-__construct/

		$widget_ops = array(
			'classname'   => 'widget_cuusoolist widget_cuusoolist_single',
			'description' => __( 'Displays a single LEGO Ideas project', CUUSOOList::TEXT_DOMAIN )
		);

		parent::__construct(
			false,
			$this->widget_title,
			$widget_ops
		);
	}


	function select_projects( $projects, $instance )
	{
		if ( isset( $projects[ $instance['project_id'] ] ) )
		{
			// Display the chosen project.
			return array( $instance['project_id'] => $projects[ $instance['project_id'] ] );
		}
		else
		{
			// Display the first defined project.
			return array_slice( $projects, 0, 1 );
		}
	}


	function update( $new_instance, $old_instance )
	{
		$instance               = parent::update( $new_instance, $old_instance );
		$instance['project_id'] = $new_instance['project_id'];
	    return $instance;
	}


	function form( $instance )
	{
		$title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : null;
		$project_id = isset( $instance['project_id'] ) ? esc_attr( $instance['project_id'] ) : null;
?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget title' ); ?>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
	</label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'project_id' ); ?>"><?php _e( 'Display this project:' ); ?>
<?php
if ( $projects = CUUSOOList::get() ) :
?>
		<select class="widefat" name="<?php echo $this->get_field_name( 'project_id' ); ?>" id="<?php echo $this->get_field_id( 'project_id' ); ?>">
<?php
	foreach ( $projects as $id => $row ) :
?>
			<option value="<?php echo $id; ?>" <?php selected( $id, $project_id ); ?>><?php echo $row['title']; ?></option>
<?php
	endforeach;
?>
		</select>
<?php
else:
?>
		<em>No projects added!</em>
<?php
endif;
?>
	</label>
	</p>

	<p><small>You can override the default template by copying <code>templates<?php echo DIRECTORY_SEPARATOR; ?>widget-cuusoolist.php</code> from the plugin folder to
	your theme's folder. Rename it to <code>widget-cuusoolist-single.php</code> to customise CUUSOO List single widgets.</small></p>
<?php
	}
}
