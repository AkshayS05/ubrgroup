<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    
    <head>
        <!-- Head content -->
        <?php wp_head(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="<?php bloginfo('charset'); ?>">
    <!-- Favicon -->
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/ubr_group_logo.png" type="image/png">
</head>
<body <?php body_class(); ?>>

<header class="site-header">
  <div class="container header-container">
    <!-- Company Logo -->
    <h1 class="site-logo">
      <a href="<?php echo home_url(); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/images/ubr_group_logo.png" alt="UBR Group Logo">
      </a>
    </h1>

    <!-- Hamburger Menu -->
    <button class="hamburger" id="hamburger" aria-expanded="false" aria-label="Toggle navigation">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </button>

    <!-- Navigation Menu -->
    <nav class="header-nav" id="nav-menu">
      <ul class="nav-links">
        <li><a href="<?php echo home_url(); ?>">Home</a></li>
        <li><a href="<?php echo home_url('/about'); ?>">About Us</a></li>
        <li><a href="<?php echo home_url('/services'); ?>">Services</a></li>
        <li><a href="<?php echo home_url('/review-form'); ?>">Review Us</a></li>
        <li><a href="<?php echo home_url('/contact'); ?>">Contact</a></li>
      </ul>
      <div class="auth-buttons">
        <?php if (is_user_logged_in()) : ?>
          <a href="<?php echo wp_logout_url(home_url()); ?>" class="logout-button">Logout</a>
        <?php else : ?>
          <a href="<?php echo wp_login_url(); ?>" class="login-button">Login</a>
          <a href="<?php echo wp_registration_url(); ?>" class="signup-button">Sign Up</a>
        <?php endif; ?>
      </div>
    </nav>
  </div>
</header>

