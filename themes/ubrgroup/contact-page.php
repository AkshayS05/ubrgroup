<?php
/**
 * Template Name: Contact Page
 */
get_header(); ?>

<main id="main-content">
    <div class="container">
        <h1>Contact Us</h1>

        <div class="contact-info">
            <p><strong>Address:</strong> 123 Trucking Lane, Cityville, ON</p>
            <p><strong>Phone:</strong> <a href="tel:+1234567890">+1 (234) 567-890</a></p>
            <p><strong>Email:</strong> <a href="mailto:info@ubrgroup.com">info@ubrgroup.com</a></p>
        </div>

        <div class="contact-form">
            <h2>Send Us a Message</h2>
            <form action="#" method="POST">
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
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509213!2d144.95373531535243!3d-37.8162791797517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577fa18c62b0e17!2sTrucking%20Lane!5e0!3m2!1sen!2sca!4v1600011728468!5m2!1sen!2sca" 
                width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>
</main>

<?php get_footer(); ?>
