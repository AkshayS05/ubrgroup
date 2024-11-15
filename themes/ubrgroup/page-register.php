<?php
/**
 * Template Name: Register Page
 */

get_header(); ?>

<div class="register-page">
    <div class="container">
        <div class="site-logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/images/your-logo.png" alt="UBR Group Logo">
            </a>
        </div>
        <div class="register-form-wrapper">
            <h2>Register</h2>
            <?php
            if ( isset( $_POST['submit'] ) ) {
                $username   = sanitize_user( $_POST['username'] );
                $email      = sanitize_email( $_POST['email'] );
                $password   = esc_attr( $_POST['password'] );
                $errors     = array();

                if ( username_exists( $username ) ) {
                    $errors[] = 'Username already exists.';
                }

                if ( !is_email( $email ) || email_exists( $email ) ) {
                    $errors[] = 'Invalid or existing email.';
                }

                if ( empty( $errors ) ) {
                    $user_id = wp_create_user( $username, $password, $email );
                    if ( !is_wp_error( $user_id ) ) {
                        wp_redirect( home_url( '/login' ) );
                        exit;
                    } else {
                        $errors[] = $user_id->get_error_message();
                    }
                }

                if ( !empty( $errors ) ) {
                    echo '<div class="registration-errors">';
                    foreach ( $errors as $error ) {
                        echo '<p>' . $error . '</p>';
                    }
                    echo '</div>';
                }
            }
            ?>

            <form action="" method="post" class="register-form">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>

                <button type="submit" name="submit">Register</button>
            </form>
            <p class="login-link">Already have an account? <a href="<?php echo home_url('/login'); ?>">Login here</a>.</p>
        </div>
    </div>
</div>

<?php get_footer(); ?>
