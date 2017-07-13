<?php

//////////////////////////////////////////////
// Random Widget: display a random project. //
//////////////////////////////////////////////

class CUUSOOList_RandomWidget extends CUUSOOList_Widget
{

	private   $widget_title = 'CUUSOO List - Random';
	protected $template     = 'widget-cuusoolist-random.php';


	function __construct()
	{
		// see http://docs.layerswp.com/doc/notice-the-called-constructor-method-for-wp_widget-is-deprecated-since-version-4-3-0-use-__construct/

		$widget_ops = array(
			'classname'   => 'widget_cuusoolist widget_cuusoolist_random',
			'description' => __( 'Displays a random LEGO Ideas project.', CUUSOOList::TEXT_DOMAIN )
		);

		parent::__construct(
			false,
			$this->widget_title,
			$widget_ops
		);
	}


	function select_projects( $projects, $instance )
	{
		if ( $instance['projects'] && count( $instance['projects'] ) )
		{
			// Select from only the selected projects.
			$list = array();
			foreach ( $instance['projects'] as $id )
			{
				$list[ $id ] = $projects[ $id ];
			}
		}
		else
		{
			// Select from all projects.
			$list = $projects;
		}
		$random = array_rand( $list, 1 );
		return array( $random => $list[ $random ] );
	}


	function update( $new_instance, $old_instance )
	{
		$instance             = parent::update( $new_instance, $old_instance );
	    $instance['projects'] = esc_sql( $new_instance['projects'] );
	    return $instance;
	}


	function form( $instance )
	{
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : null;
		if ( ! ( $selected_projects = $instance['projects'] ) )
		{
			$selected_projects = array();
		}
?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget title' ); ?>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
	</label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'project_id' ); ?>"><?php _e( 'Select from these projects:' ); ?>
<?php
if ( $projects = CUUSOOList::get() ) :
?>
		<select multiple size="<?php echo min( count( $projects ), 6 ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'projects' ); ?>[]" id="<?php echo $this->get_field_id( 'projects' ); ?>">
<?php
	foreach ( $projects as $id => $row ) :
?>
			<option value="<?php echo $id; ?>" <?php if ( in_array( $id, $selected_projects ) ) :?>selected<?php endif; ?>><?php echo $row['title']; ?></option>
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
	your theme's folder. Rename it to <code>widget-cuusoolist-random.php</code> to customise CUUSOO List random widgets.</small></p>
<?php
	}
}
