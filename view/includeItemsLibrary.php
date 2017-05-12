<?php 
	$rol = 'edit_posts'; //Role o capacidad que se asigna a la persona que puede sugerir herramientas
	if ( strnatcasecmp(get_query_var('pagename'), "buscar-herramienta") == 0 )
	{
		if ( $_GET['herramienta'] )
		{
			include WP_PLUGIN_DIR."/biblioteca/view/verHerramienta.php";
		}
		elseif ( $_GET['categoria'] || $_GET['componente'] || $_GET['tipo'] )
			include WP_PLUGIN_DIR."/biblioteca/view/verCategoria.php";
		else
			include WP_PLUGIN_DIR."/biblioteca/view/contentSearch.php";
	}
    elseif ( strnatcasecmp(get_query_var('pagename'), "sugerir-herramienta") == 0 )
    {
		if ( current_user_can( $rol ) )
		{
			include WP_PLUGIN_DIR."/biblioteca/view/forms/formularioHerramienta.php";
		}
		else
		{
			echo "<h1>Aviso...</h1><p>No tienes permisos pasa subir herramientas, por favor escribe a: ".get_bloginfo( 'admin_email' )."</p>";
		}
	}
	else
	{ ?>
		<?php get_template_part( 'templates/page-title' ); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
			<?php get_template_part( 'templates/post-formats/format', get_post_format() ); ?>
			<div class="post-content clearfix"><?php the_content(); ?></div>
			<?php wp_link_pages( array(
				'before' => '<div class="post-page-links header-font">'.__( 'Pages:' ),
					'pagelink' => '<span>%</span>',
					'after' => '</div>',
				)
			 ); ?>
		</article>
<?php	} ?>
