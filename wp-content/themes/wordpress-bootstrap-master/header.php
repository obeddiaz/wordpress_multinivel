<!doctype html>  

<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?>class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php wp_title('|', true, 'right'); ?></title>	
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

        <!-- wordpress head functions -->
        <?php wp_head(); ?>
        <!-- end of wordpress head -->
        <!-- IE8 fallback moved below head to work properly. Added respond as well. Tested to work. -->
        <!-- media-queries.js (fallback) -->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>			
        <![endif]-->

        <!-- html5.js -->
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->	

        <!-- respond.js -->
        <!--[if lt IE 9]>
                  <script type='text/javascript' src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
        <![endif]-->	
    </head>

    <body <?php body_class(); ?>>
        <header role="banner">
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container">

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <a class="navbar-brand" title="<?php echo get_bloginfo('description'); ?>" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
                    </div>

                    <div class="collapse navbar-collapse navbar-responsive-collapse">
                        <?php wp_bootstrap_main_nav(); // Adjust using Menus in Wordpress Admin ?>

                        <?php //if(of_get_option('search_bar', '1')) {?>
<!--                        <form class="navbar-form navbar-right" role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
                            <div class="form-group">
                                <input name="s" id="s" type="text" class="search-query form-control" autocomplete="off" placeholder="<?php _e('Search', 'wpbootstrap'); ?>" data-provide="typeahead" data-items="4" data-source='<?php echo $typeahead_data; ?>'>
                            </div>
                        </form>-->
                        <?php //} ?>
                        <div class="navbar-right">
                            <?php if (is_user_logged_in()) { ?>
                                <ul id="menu-right-menu" class="nav navbar-nav">
                                    <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page">
                                        <a href="<?php echo admin_url(); ?>" title="Logout">
                                            Mi Oficina
                                        </a>
                                    </li>
                                    <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page">
                                        <a href="<?php echo wp_logout_url(); ?>" title="Logout">
                                            Cerrar Sesion
                                        </a>
                                    </li>
                                </ul>
                                <?php
                            } else {
                                wp_bootstrap_right_nav();
                            }
                            ?>
                        </div>
                    </div>

                </div> <!-- end .container -->
            </div> <!-- end .navbar -->
        </header> <!-- end header -->

        <div class="container">
            <img src="http://regalosalinstante.org/uploads/3/5/2/8/3528263/header_images/1414005849.jpg" class="img-responsive" style="margin: 0 auto;" alt="Responsive image">
