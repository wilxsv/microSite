<?php

class LateralView extends WP_Widget {

    /** 
     * constructor 
    */
    function __construct() {
		parent::__construct( 'LateralView', "Vista Lateral de herramientas", $widget_options = array(), $control_options = array()
		);
		
		add_action( 'widgets_init', array( $this, 'register_LateralView' ) );
    }
	
	// register Foo_Widget widget
	function register_LateralView() {
	    register_widget( 'LateralView' );
	}

    /** 
     * @see WP_Widget::widget 
    */
    public function widget( $args, $instance ) {
        extract( $args );
		global $wpdb;
		
      	$title = apply_filters( 'widget_title', $instance['title'] );
		$limit = ! empty ( $instance['limit'] ) ? $instance['limit'] : '';
		$ramdom = ! empty( $instance['ramdom'] ) ? $instance['ramdom'] : '';
		$images = ! empty ( $instance['images'] ) ? $instance['images'] : ''; 

        echo $before_widget;
        
        if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
        }
        $query = "SELECT h.nombre, h.objetivo, h.idherramienta AS id";
        if ( ! empty( $images ) ) { $query.=", p.portada AS portada"; }
        $query.=" FROM dgpc_herramienta AS h, dgpc_publicacion AS p WHERE h.idherramienta = p.idherramienta ";
        if ( ! empty( $ramdom ) && $ramdom == 1 ) { $query.=" ORDER BY RAND()"; }
        if ( ! empty( $limit ) && $limit > 2 ) { $query.=" LIMIT ".$limit; }
        else { $query.=" LIMIT 2"; }
        $lista=$wpdb->get_results($query);        
        foreach ($lista as $i) {
			echo '<a href="'.site_url().'/index.php/buscar-herramienta?herramienta='.$i->id.'" ><p>'.$i->nombre.'<br />';
			if ( ! empty( $images ) ) { echo '<img src="'.$i->portada.'" alt="'.$i->nombre.'" height="128" width="128" class="img-responsive img-thumbnail"/>'; }
			echo '</p></a>';
		}
		
		echo $after_widget;
    }
	
    /** 
     * @see WP_Widget::form 
    */
    public function form( $instance ) {

    	$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$limit = isset( $instance['limit'] ) ? esc_attr( $instance['limit'] ) : '';
		$ramdom = isset( $instance['ramdom'] ) ? esc_attr( $instance['ramdom']) : '';
		$images = isset( $instance['images'] ) ? esc_attr( $instance['images'] ) : '';
        ?>
		<p>
        	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo "Titulo"; ?></label> 
          	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
         	<input id="<?php echo $this->get_field_id( 'ramdom' ); ?>" name="<?php echo $this->get_field_name( 'ramdom' ); ?>" type="checkbox" value="1" <?php checked( '1', $ramdom ); ?>/>
          	<label for="<?php echo $this->get_field_id( 'ramdom' ); ?>"><?php echo "Orden aleatorio"; ?></label> 
        </p>
        <p>
        	<input id="<?php echo $this->get_field_id( 'images' ); ?>" name="<?php echo $this->get_field_name( 'images' ); ?>" type="checkbox" value="1" <?php checked( '1', $images ); ?>/>
        	<label for="<?php echo $this->get_field_id( 'images' ); ?>"><?php echo "Mostrar portadas"; ?></label>
        </p>
		<p>
          	<input id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="number" value="<?php echo $limit; ?>" />
          	<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php echo "Limite"; ?></label> 
        </p>
        <?php 
    }

	/** 
     * @see WP_Widget::update 
    */
    public function update( $new_instance, $old_instance ) {
    	
		$instance = $old_instance;
		$instance['title'] = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['limit'] = isset( $new_instance['limit'] ) ? strip_tags( $new_instance['limit'] ) : '';
		$instance['ramdom'] = isset( $new_instance['ramdom'] ) ? strip_tags( $new_instance['ramdom'] ) : '';
		$instance['images'] = isset( $new_instance['images'] ) ? strip_tags( $new_instance['images'] ) : '';
		
		return $instance;
    }

} // END of Class LateralView

?>
