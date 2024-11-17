<?php
/**
 * Template Name: Contact Page
 */
get_header(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input to prevent XSS attacks
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    // Prepare email to be sent
    $to = 'your-outlook-email@outlook.com';  // Replace this with your Outlook email address
    $subject = 'New Contact Form Submission from ' . $name;
    $body = "Name: $name\nEmail: $email\nMessage:\n$message";
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <no-reply@' . $_SERVER['SERVER_NAME'] . '>',
        'Reply-To: ' . $email
    ];

    // Send the email
    if (wp_mail($to, $subject, $body, $headers)) {
        echo '<p class="success-message">Thank you for contacting us! Your message has been sent successfully.</p>';
    } else {
        echo '<p class="error-message">Sorry, there was an error sending your message. Please try again later.</p>';
    }
}
?>

<main id="main-content">
    <div class="container">
        <h1>Contact Us</h1>

        <div class="contact-info">
            <p><strong>Address:</strong> 17 Blue Silo Way, Brampton, ON</p>
            <p><strong>Phone:</strong> <a href="tel:+1234567890">+1 (905)-234-6700</a></p>
            <p><strong>Email:</strong> <a href="mailto:Dispatch@ubrgroup.ca">Dispatch@ubrgroup.ca</a></p>
        </div>

        <div class="contact-form">
            <h2>Send Us a Message</h2>
            <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="POST">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="message">Your Message</label>
                <textarea id="message" name="message" rows="5" placeholder="Enter your message" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>

        <div class="map">
            <h2>Find Us Here</h2>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2886.6932499230516!2d-79.76389622424483!3d43.76869924623914!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b3f95b765c0c7%3A0xa9a24bd313a2d66c!2s17%20Blue%20Silo%20Way%2C%20Brampton%2C%20ON!5e0!3m2!1sen!2sca!4v1699906123506!5m2!1sen!2sca"
                width="600"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</main>

<?php get_footer(); ?>
