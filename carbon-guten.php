<?php
/**
 * Plugin Name:     PDF Carbon Fields Block
 * @package         Carbon_Guten
 */

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
	require_once( 'vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
	Block::make( 'PDF' )
	     ->add_fields( [
		     Field::make( 'complex', 'files', 'Files' )
		          ->add_fields( array(
			          Field::make( 'file', 'file', 'file' )
		          ) ),
	     ] )
	     ->set_render_callback( function( $files ) {

		     ?>
             <div class="wp-block-file">
             <ul>
                 <?php
                 foreach ( $files['files'] as $file ){
                     $file_url = wp_get_attachment_url( $file['file'] );
                     $file_thumb = wp_get_attachment_thumb_url( $file['file'] );
                     ?>
                     <div>
                         <img style="max-width:800px" src="<?php echo $file_thumb ?>">
                         <span><?php echo get_the_title( $file['file'] ) ?></span>

                         <a href="<?php echo $file_url ?>" class="wp-block-file__button">View</a>
                         <a href="<?php echo $file_url ?>" class="wp-block-file__button" download="">Download</a>
                     </div>
                     <?php
                 }
                 ?>
             </ul>
             </div>
		     <?php
	     });

}

