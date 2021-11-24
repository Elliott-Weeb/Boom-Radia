<?php get_header(); ?>
<main id="container">
<div id="home-container">
<?php
    // Include the page content template.
    get_template_part( 'template-parts/content/content', 'programs' );
    // If comments are open or we have at least one comment, load up the comment template.
    // if ( comments_open() || get_comments_number() ) {
    //     comments_template();
    // }
    // End of the loop.
?>
</div>
<?php get_footer(); ?>
