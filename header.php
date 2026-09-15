<?php
/**
 * The header for the theme, converted from the Tistory skin's <header> block.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body id="<?php echo esc_attr( tistory_style_body_id() ); ?>" <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="wrap" class="wrap-right">

	<header class="header">
		<div class="line-bottom display-none"></div>

		<div class="inner-header">
			<div class="box-header">
				<h1 class="title-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" class="link_logo">
						<?php if ( has_custom_logo() ) : ?>
							<?php the_custom_logo(); ?>
						<?php else : ?>
							<?php bloginfo( 'name' ); ?>
						<?php endif; ?>
					</a>
				</h1>

				<div class="util use-top">
					<?php get_search_form(); ?>
				</div>

				<button type="button" class="button-menu" aria-label="<?php esc_attr_e( '메뉴 열기', 'tistory-style' ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="14" viewBox="0 0 20 14">
						<path fill="#333" fill-rule="evenodd" d="M0 0h20v2H0V0zm0 6h20v2H0V6zm0 6h20v2H0v-2z" />
					</svg>
				</button>
			</div>

			<div class="area-align">
				<?php if ( is_active_sidebar( 'sidebar-main' ) && get_bloginfo( 'description' ) ) : ?>
					<div class="area-slogun">
						<strong><?php bloginfo( 'name' ); ?></strong>
						<?php if ( get_bloginfo( 'description' ) ) : ?>
							<p><?php bloginfo( 'description' ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="area-gnb">
					<?php
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container'      => 'nav',
								'container_class'=> 'topnavmenu',
								'items_wrap'     => '<ul class="category_list">%3$s</ul>',
								'walker'         => new Tistory_Style_Nav_Walker(),
							)
						);
					} else {
						tistory_style_fallback_menu();
					}
					?>
				</div>
			</div>
			<!-- // area-align -->
		</div>
		<!-- // inner-header -->

		<?php if ( is_home() || is_front_page() ) : ?>
			<div class="home-hero">
				<div class="home-hero-inner">
					<strong><?php echo esc_html( get_bloginfo( 'description' ) ?: get_bloginfo( 'name' ) ); ?></strong>
				</div>
			</div>
		<?php elseif ( is_category() ) : ?>
			<?php
			$cat_desc   = category_description();
			$cat_title  = single_cat_title( '', false );
			$banner_txt = $cat_desc ? wp_strip_all_tags( $cat_desc ) : $cat_title;
			?>
			<div class="home-hero sub-hero">
				<div class="home-hero-inner">
					<strong><?php echo esc_html( $banner_txt ); ?></strong>
				</div>
			</div>
		<?php elseif ( is_archive() || is_search() || is_tag() ) : ?>
			<div class="home-hero sub-hero">
				<div class="home-hero-inner">
					<strong><?php the_archive_title(); ?></strong>
				</div>
			</div>
		<?php endif; ?>
	</header>
	<!-- // header -->

	<div id="container">
		<main class="main">
			<div class="area-main">
