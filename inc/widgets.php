<?php


//add_action( 'widgets_init', 'registreer_sidebars' );

/*class Ag_agenda_w extends WP_Widget {

    function __construct() {

    parent::__construct(
        	// Base ID of your widget
	        'agenda',

	        // Widget name will appear in UI
	        __('agenda', 'agenda_domain'),

	        // Widget description
	        array( 'description' => __( 'Zet de agenda erin.', 'krant-carousel_domain' ), )
        );

    }

    // Frontend
    public function widget($args, $instance) {

		$agenda = new Ag_agenda(array(
			'aantal' => 5,
			'omgeving' => 'widget'
		));
		$agenda->print();


    }

    // Backend
    public function form($instance) {

	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		return $instance;
	}
}*/

class Ag_pag_familie_w extends WP_Widget
{

	function __construct()
	{

		parent::__construct(
			// Base ID of your widget
			'Ag_pag_familie_w',

			// Widget name will appear in UI
			__('pagina familie', 'pagina_familie_domain'),

			// Widget description
			array('description' => __('als een pagina onderdeel van een familie is wordt deze widget actief.', 'pagina_familie_domain'),)
		);
	}

	// Frontend
	public function widget($args, $instance)
	{
		$leesverder = ucfirst(\agitatie\taal\streng('lees verder'));
		$fam = new Ag_pag_fam($leesverder);
		$fam->maak();
		$fam->print();
	}

	// Backend
	public function form($instance)
	{
	}

	public function update($new_instance, $old_instance)
	{
		$instance = array();
		return $instance;
	}
}

class Ag_agenda_widget extends WP_Widget
{

	function __construct()
	{

		parent::__construct(
			// Base ID of your widget
			'Ag_agenda_widget',

			// Widget name will appear in UI
			__('Agenda widget', 'Ag_agenda_widget_domain'),

			// Widget description
			array('description' => __('Indien er actieve agendaitems zijn wordt deze widget getoond.', 'Ag_agenda_widget_domain'),)
		);
	}

	// Frontend
	public function widget($args, $instance)
	{

		echo "<section id='agenda-widget' class='widget widget_block sticky-widget agenda-widget-buiten'>";
		$agenda = new Ag_agenda(array(
			'aantal' => 5,
			'omgeving' => 'widget'
		));

		$agenda->print();

		// $naar_agenda = new Ag_knop(array(
		//   'class' 	=> 'in-wit ikoon-rechts',
		//   'link' 		=> get_post_type_archive_link('agenda'),
		//   'tekst'		=> 'Agenda',
		//   'ikoon'		=> 'arrow-right-thick'
		// ));		
		// $naar_agenda->print();
		echo "</section>";
	}

	// Backend
	public function form($instance)
	{
	}

	public function update($new_instance, $old_instance)
	{
		$instance = array();
		return $instance;
	}
}

/**
 * wordt bij desktop gebruikt om de sharedaddy heen te verplaatsen.
 */
class Ag_social_widget_container extends WP_Widget
{

	function __construct()
	{

		parent::__construct(
			// Base ID of your widget
			'Ag_social_widget_container',

			// Widget name will appear in UI
			__('sharedaddy container', 'sharedaddy_container_domain'),

			// Widget description
			array('description' => __('Op desktop wordt naar deze container de share knoppen heen verplaatst.', 'sharedaddy_container_domain'),)
		);
	}

	// Frontend
	public function widget($args, $instance)
	{

		echo "<section id='sharedaddy-in-sidebar' class='widget sticky-widget widget_block sharedaddy-in-sidebar'></section>";
	}

	// Backend
	public function form($instance)
	{
	}

	public function update($new_instance, $old_instance)
	{
		$instance = array();
		return $instance;
	}
}


// Register and load the widget
function widget_wrap()
{
	register_widget('ag_pag_familie_w');
	register_widget('ag_social_widget_container');
	register_widget('ag_agenda_widget');
}

add_action('widgets_init', 'widget_wrap');
