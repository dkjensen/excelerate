<div class="site-branding">
    <?php
    the_custom_logo();
    if ( is_front_page() && is_home() ) :
        ?>
        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
        <?php
    else :
        ?>
        <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
        <?php
    endif;
    $excelerate_description = get_bloginfo( 'description', 'display' );
    if ( $excelerate_description || is_customize_preview() ) :
        ?>
        <p class="site-description"><?php echo $excelerate_description; /* WPCS: xss ok. */ ?></p>
    <?php endif; ?>
</div><!-- .site-branding -->

<nav id="site-navigation" class="main-navigation">
    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'excelerate' ); ?></button>
    <?php
    wp_nav_menu( array(
        'theme_location' => 'menu-1',
        'menu_id'        => 'primary-menu',
    ) );
    ?>
</nav><!-- #site-navigation -->