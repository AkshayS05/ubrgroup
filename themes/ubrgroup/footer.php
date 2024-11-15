<footer>
    <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
</footer>

<!-- Include the JavaScript before the closing </body> tag -->
<script>
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');

    hamburger.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });
</script>

<?php wp_footer(); ?> <!-- Important hook -->
</body>
</html>
