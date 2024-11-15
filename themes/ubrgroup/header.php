<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Head content -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="container header-container">
        <!-- Company Name -->
        <h1 class="site-logo">
            <a href="<?php echo home_url(); ?>">UBR Group</a>
        </h1>

        <!-- Hamburger Button -->
        <button class="hamburger" id="hamburger">
            <span class="bar top-bar"></span>
            <span class="bar middle-bar"></span>
            <span class="bar bottom-bar"></span>
        </button>

        <!-- Navigation Menu -->
        <nav class="header-nav" id="nav-menu">
            <ul class="nav-links">
                <li><a href="<?php echo home_url(); ?>">Home</a></li>
                <li><a href="<?php echo home_url('/about'); ?>">About Us</a></li>
                <li><a href="<?php echo home_url('/services'); ?>">Services</a></li>
                <li><a href="<?php echo home_url('/contact'); ?>">Contact</a></li>
            </ul>
            <div class="auth-buttons">
                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo wp_logout_url( home_url() ); ?>" class="logout-button">Logout</a>
                <?php else : ?>
                    <a href="<?php echo wp_login_url(); ?>" class="login-button">Login</a>
                    <a href="<?php echo wp_registration_url(); ?>" class="signup-button">Sign Up</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>
