<?php
$header_class = is_singular() && get_post_meta( get_the_ID(), "header_color", true ) ? get_post_meta( get_the_ID(), "header_color", true ) : ""; 
$header_class = apply_filters( 'avf_header_class_filter', $header_class );
?>

<div id="header" class="header <?php echo $header_class; ?>">
	<?php if( avia_get_option( 'announcement_banner' )){ ?>
		<div class="announcement-banner">
			<div class="announcement-banner-inner">
				<?php echo avia_get_option( 'announcement_banner' ); ?>
				<button class="close-bar" onClick="(function(){ document.getElementById('header').classList.remove('has-bar') })()">X</button>
			</div>
		</div>
	<?php } ?>
	<div class="top-menu">
		<div class="top-menu-inner">
			<div class="header-search-container">
				<button class="header-search-toggle"></button>
				<div class="header-search-form">
					<?php get_search_form(); ?>
				</div>
			</div>
			<?php
				$args = array(
					'items_wrap'        => '<ul id="%1$s" class="%2$s" role="menu">%3$s</ul>',
					'theme_location'	=> 'avia2',
					'menu_id' 			=> '',
					'menu_class'		=> 'secondary-menu',
					'container_class'	=> 'secondary-menu-container',
					'fallback_cb' 		=> 'avia_fallback_menu',
					'walker' 			=> new avia_responsive_mega_menu()
				);
				wp_nav_menu( $args );
			?>
		</div>
	</div>
	<div class="header-inner">
		<div class="header-logo">
			<?php echo punch_logo( true ); ?>
		</div>
		<div class="header-menu">
			<?php
				$args = array(
					'items_wrap'        => '<ul id="%1$s" class="%2$s" role="menu">%3$s</ul>',
					'theme_location'	=> 'avia',
					'menu_id' 			=> '',
					'menu_class'		=> 'main-menu',
					'container_class'	=> '',
					'fallback_cb' 		=> 'avia_fallback_menu',
					'walker' 			=> new avia_responsive_mega_menu()
				);
				wp_nav_menu( $args );
			?>
		</div>
		<button class="hamburger-toggle" aria-label="Mobile Menu Toggle">
			<div class="burger-box"></div>
		</button>
	</div>
	<div class="hamburger-overlay"></div>
	<div class="hamburger-content">
		<div class="hamburger-content-inner">
			<?php
				$args = array(
					'items_wrap'        => '<ul id="%1$s" class="%2$s" role="menu">%3$s</ul>',
					'theme_location'	=> 'avia',
					'menu_id' 			=> '',
					'menu_class'		=> 'main-menu',
					'container_class'	=> '',
					'fallback_cb' 		=> 'avia_fallback_menu',
					'walker' 			=> new avia_responsive_mega_menu()
				);
				wp_nav_menu( $args );
			?>
		</div>
	</div>
</div>