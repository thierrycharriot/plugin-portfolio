<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://thierrycharriot.github.io
 * @since      1.0.0
 *
 * @package    Plugin_Portfolio
 * @subpackage Plugin_Portfolio/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php get_header(); ?>

<div class="container-fluid">
	<div class="h-100 p-3 bg-light border rounded-3 m-3">
		<div class="text-center">
			<?php 
				// https://developer.wordpress.org/reference/functions/wp_get_current_user/
				// wp_get_current_user()
				// Retrieve the current user object.
				//$user_infos = wp_get_current_user(); 
				//var_dump($user_infos)

				// https://developer.wordpress.org/reference/functions/get_userdata/
				// get_userdata( int $user_id ): WP_User|false
				// Retrieves user info by user ID.
				$user_infos = get_userdata(1); 
				//var_dump($user_infos)
			?>
			</h1>
			<div class="portfolio_photo">
				<?php 
					// https://developer.wordpress.org/reference/functions/the_post_thumbnail/
					// the_post_thumbnail( string|int[] $size = 'post-thumbnail', string|array $attr = '' )
					// Displays the post thumbnail.
					the_post_thumbnail( 'thumbnail' );
					//the_post_thumbnail( 'medium' ); 
				?>
			</div>
			<h1 class="fw-bold text-secondary">
				<?php echo $user_infos->usermeta_user_profession; ?>
			</h1>
			<p class="h2 fw-bold">
			<?php $user_info = get_userdata(1); echo $user_infos->first_name .  " " . $user_infos->last_name; ?>
			</p>
			<a href="<?php echo $user_infos->usermeta_cv_link; ?>" class="btn btn-success" type="button">Télécharger mon CV!</a>
		</div>
	</div>
</div>

<h2 class="fw-bold text-secondary text-center">A propos</h2>

<div class="container-md">
<div class="row">

	<main id="primary" class="col-12 col-md-12">

		<?php
		if ( have_posts() ) :
			
			if ( $post->post_name == 'portfolio' ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
				<?php echo the_content(); ?>
				<?php
			endif;

			//the_posts_navigation();
			/**
			 * Load pagination in functions.php
			 */
			//underscores_pagination ();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

	<?php
	//get_sidebar();
	?>

</div><!-- row-->
</div><!-- container -->

<div class="parallax parallax-001 mt-3 mb-3"></div>

<h2 class="fw-bold text-secondary text-center">Réalisations</h2>

<div class="container-md">
	<div class="row">

		<?php

			// https://developer.wordpress.org/reference/classes/wp_query/
			// WP_Query
			// The WordPress Query class.
			$args = array(
				'post_type' => 'realisation',
				'posts_per_page' => 18,
				'orderby' => 'title',
				'order'   => 'DESC', 
				#'order'   => 'ASC',
			);
			// The Query
			$loop = new WP_Query( $args );
			//var_dump( $loop->get_posts() ); // Debug OK

			// https://developer.wordpress.org/reference/functions/have_posts/
			// have_posts()
			// Determines whether current WordPress query has posts to loop over.
			while( $loop->have_posts() ): $loop->the_post();
		?>

		<div class="col-md-4">
			<div class="card border-dark mb-3">
				<?php 

					// https://developer.wordpress.org/reference/functions/the_post_thumbnail/
					// the_post_thumbnail( string|int[] $size = 'post-thumbnail', string|array $attr = '' )
					// Displays the post thumbnail.
					if ( has_post_thumbnail() ) : 
				?>
					<!--<a href="<?php #the_permalink(); ?>" title="<?php #the_title_attribute(); ?>">-->
						<?php the_post_thumbnail(); ?>
					<!--</a>-->
				<?php endif; ?>
				<div class="card-body">
					<h3 class="card-title"><?php the_title(); ?></h3>
					<p class="card-text"><?php the_content(); ?></p>
				</div><!--/card-body-->
			</div>
		</div><!--/col-md-4-->

		<?php
			// https://developer.wordpress.org/reference/functions/wp_reset_postdata/
			// wp_reset_postdata()
			// After looping through a separate query, this function restores the $post global to the current post in the main query
			endwhile; wp_reset_postdata();
		?>

	</div><!--/row-->
</div><!--/container-md-->

<div class="parallax parallax-002 mt-3 mb-3"></div>

<h2 class="fw-bold text-secondary text-center">Formations</h2>

<div class="container-md">
	<div class="row">

		<?php
			// https://developer.wordpress.org/reference/classes/wp_query/
			// WP_Query
			// The WordPress Query class.
			$args = array(
				'post_type' => 'formation',
				'posts_per_page' => 18,
				'orderby' => 'date',
				'order'   => 'DESC', 
				#'order'   => 'ASC',
			);
			// The Query
			$loop = new WP_Query( $args );
			//var_dump( $loop->get_posts() ); // Debug OK

			// https://developer.wordpress.org/reference/functions/have_posts/
			// have_posts()
			// Determines whether current WordPress query has posts to loop over.
			while( $loop->have_posts() ): $loop->the_post();
		?>

		<div class="col-md-6">
			<div class="card border-success mb-3">
				<div class="card-body">
					<h3 class="card-title"><?php the_title(); ?></h3>							
					<span class="entry-date"><?php echo get_the_date(); ?></span>
					<p class="card-text"><?php the_content(); ?></p>
				</div><!--/card-body-->
			</div>
		</div><!--/col-md-4-->

		<?php
			// https://developer.wordpress.org/reference/functions/wp_reset_postdata/
			// wp_reset_postdata()
			// After looping through a separate query, this function restores the $post global to the current post in the main query
			endwhile; wp_reset_postdata();
		?>

	</div><!--/row-->
</div><!--/container-md-->

<div class="parallax parallax-005 mt-3"></div>

<?php
get_footer();