<?php



/**



 * The header for our theme.



 *



 * Displays all of the <head> section and everything up till <div id="content">



 *



 */







$site_logo_default = get_theme_mod( 'site_logo_default' );



$site_logo_inverse = get_theme_mod( 'site_logo_inverse' );







?><!DOCTYPE html>



<html <?php language_attributes(); ?>>



<head>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '1414706478557005');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1414706478557005&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->


<meta charset="<?php bloginfo( 'charset' ); ?>"/>



<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">



<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />



<link rel="profile" href="http://gmpg.org/xfn/11">



<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">



<!--link href='//fonts.googleapis.com/css?family=Ultra' rel='stylesheet' type='text/css'-->

<link href='//fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>





<script>



  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){



  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),



  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)



  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');







  ga('create', 'UA-3602052-49', 'auto');



  ga('send', 'pageview');







</script>







<?php wp_head(); ?>



</head>







<body <?php body_class(); ?> id="single_staff_page">



	<a class="skip-link screen-reader-text sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'stylish' ); ?></a>



	



	<header id="masthead" class="site-header navbar navbar-inverse navbar-static-top" role="banner">



		<div class="container">



			<div class="site-branding navbar-header">



				<?php if( has_nav_menu( 'primary' ) ) : ?>



					<div class="menu-icon-mobile">

                    	<button class="menu-toggle navbar-toggle" aria-controls="primary-menu" aria-expanded="false" data-toggle="collapse" data-target="">



						<span class="navbar-toggle-text"><?php printf( esc_html__( '%1$sToggle%2$s ', 'stylish' ), '<span class="screen-reader-text sr-only">', '</span>' ); ?></span>



						<span class="icon-bar"></span>



					</button>

                    </div>



				<?php endif; ?>



				<div class="menu-icon-desktop">

				<?php



						wp_nav_menu( array(



							'theme_location'  => 'primary',



							'container'       => '',



							'menu_class'      => 'menu nav navbar-nav navbar-right',



							'menu_id'         => 'primary-menu',



							'fallback_cb'     => '',



							'walker'          => new stylish_Walker_Nav_Menu,



						) );



					?>

                 </div>



				<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">



					<span class="navbar-brand-default">



						<?php if( '' != $site_logo_default ) : ?>



							<img class="site-logo" src="<?php echo esc_url( $site_logo_default ); ?>" />



						



<?php endif; ?>



											



					</span>



					



					<span class="navbar-brand-inverse">



						<?php if( '' != $site_logo_inverse ) : ?>



							<img class="site-logo" src="<?php echo esc_url( $site_logo_inverse ); ?>" />



						<?php endif; ?>





					</span>



				</a>



			</div><!-- .site-branding -->



			



			<nav id="site-navigation" class="main-navigation" role="navigation">



				<div class="container">



					



					<h2 class="screen-reader-text sr-only"><?php esc_html_e( 'Primary Menu', 'stylish' ); ?></h2>



					



					<?php



						wp_nav_menu( array(



							'theme_location'  => 'primary',



							'container'       => '',



							'menu_class'      => 'menu nav navbar-nav navbar-right',



							'menu_id'         => 'primary-menu',



							'fallback_cb'     => '',



							'walker'          => new stylish_Walker_Nav_Menu,



						) );



					?>



				</div>



			</nav><!-- #site-navigation -->



		</div>



	</header><!-- #masthead -->



	



	<div id="page" class="hfeed site">



		<div id="content" class="site-content">