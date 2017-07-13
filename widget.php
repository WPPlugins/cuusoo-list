<?php

// Base widget class.
abstract class CUUSOOList_Widget extends WP_Widget
{
	protected $template;

	/**
	 * CUUSOOList_Widget::widget()
	 * Creates a widget.
	 *
	 * @return void
	 */
	final function widget( $args, $instance )
	{
		$projects    = CUUSOOList::get();
		$last_update = CUUSOOList::last_update();

		if ( ! ( $projects && count( $projects ) > 0 ) )
		{
			return;
		}

		extract( $args, EXTR_SKIP );
		$title = apply_filters( 'widget_title	', $instance['title'] );

		// Beginning of widget.
		echo $before_widget;

		// Widget title.
		if ( $title )
		{
			echo $before_title . $title . $after_title;
		}

		// Choose which projects we want to display.
		$selected_projects = $this->select_projects( $projects, $instance );

		// Find a template to use for this widget's output:
		// - specific template defined by the widget class;
		// - widget-cuusoolist.php in the current theme's folder;
		// - widget-cuusoolist.php in the plugin folder.
		$templates = array(
			get_stylesheet_directory() . DIRECTORY_SEPARATOR . $this->template,
			get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'widget-cuusoolist.php',
			plugin_dir_path( __FILE__ ) . 'templates' . DIRECTORY_SEPARATOR . 'widget-cuusoolist.php'
		);
		foreach ( $templates as $tpl )
		{
			if ( file_exists( $tpl ) )
			{
				include $tpl;

				// End of widget.
				echo $after_widget;
				return;
			}
		}

		// Warning message if a template was not found.
		echo 'Template not found!';

		// End of widget.
		echo $after_widget;
	}


	/**
	 * CUUSOOList_Widget::select_projects()
	 * Returns an array of projects to use in the displayed widget.
	 *
	 * @return array
	 */
	protected function select_projects($projects, $instance)
	{
		return $projects;
	}


	/**
	 * CUUSOOList_Widget::update()
	 * Updates the widget's settings.
	 *
	 * @return
	 */
	function update( $new_instance, $old_instance )
	{
		$instance          = $old_instance;
	    $instance['title'] = $new_instance['title'];
	    return $instance;
	}

}

// The different kinds of widgets.
require 'widget-listwidget.php';
require 'widget-randomwidget.php';
require 'widget-singlewidget.php';
