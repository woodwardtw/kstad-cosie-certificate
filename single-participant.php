<?php acf_form_head(); ?>

<?php
/**
 * The template for displaying all single participants
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package suffice
 */

get_header(); ?>

<?php
/**
 * suffice_before_body_content hook
 */
do_action( 'suffice_before_body_content' ); ?>

<div id="primary" class="content-area participant">
	<main id="main" class="site-main" role="main">
		<?php
		// $fields = array('field_605ded9481995','field_605df51a632e1','field_605df521632e2','field_605df528632e3');
		$args =  array(
					'field_el' => 'div',
				);
		
		while ( have_posts() ) : the_post();
            
			// foreach ($fields as $key => $field) {
			// 	# code...
			// 	$args =  array(
			// 		'field_el' => 'div',
			// 		//'fields' => array($field),
			// 	);
			// 	$num = $key+1;
			// 	$title = get_field('prompt_' . $num . '_title', 'option' );
			// 	$prompt = get_field('prompt_' . $num, 'option');
			// 	echo "<button class='accordion'>Section {$title}</button>
			// 			<div class='panel'>
			// 			<div class='prompt'>{$prompt}</div>
			// 			<div class='counter' id='counter{$key}'></div>
			// 	";
			// 	echo "</div>";
			// }
			acf_form($args);

			get_template_part( 'template-parts/content', get_post_format() );

			if ( true == suffice_get_option( 'suffice_blog_single_show_navigation', true ) ) {
				the_post_navigation();
			}

			// If related post is active, then show related posts.
			if ( true == suffice_get_option( 'suffice_blog_single_show_related', true ) ) {
				get_template_part( 'template-parts/related/related', 'post' );
			}

			// If comments are set to be shown in single.

				/**
				 * suffice_before_comments_template hook
				 */
				do_action( 'suffice_before_comments_template' );

			if ( true == suffice_get_option( 'suffice_blog_single_show_comments', true ) ) {

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				/**
				 * suffice_after_comments_template hook
				 */
				do_action( 'suffice_after_comments_template' );

			}

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
/**
 * suffice_after_body_content hook
 */
do_action( 'suffice_after_body_content' ); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
