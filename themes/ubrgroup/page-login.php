<?php
/**
 * Template Name: Login Page
 */

get_header(); ?>

<div class="login-page">
    <div class="container">
        <div class="site-logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/images/your-logo.png" alt="UBR Group Logo">
            </a>
        </div>
        <div class="login-form-wrapper">
            <h2>Login</h2>
            <?php
            wp_login_form( array(
                'redirect'       => home_url(), 
                'form_id'        => 'loginform',
                'label_username' => __( 'Username or Email Address' ),
                'label_password' => __( 'Password' ),
                'label_remember' => __( 'Remember Me' ),
                'label_log_in'   => __( 'Log In' ),
                'remember'       => true
            ) );
            ?>
            <p class="register-link">Don't have an account? <a href="<?php echo home_url('/register'); ?>">Register here</a>.</p>
        </div>
    </div>
</div>

<?php get_footer(); ?>
