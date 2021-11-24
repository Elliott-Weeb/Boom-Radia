<!-- Contact Header -->
<section class="main-3-contact">
<div class="grid-x grid-padding-x main-4-header">
  <div class="cell large-12">
    <div class="contact_link">
      <h2 class="button">Connect</h2>
    </div>
  </div>
</div>
<!--Footer Widgets for Social Media - Silvena Lam-->
<?php
$has_sidebar_1 = is_active_sidebar( 'sidebar-1' );
$has_sidebar_2 = is_active_sidebar( 'sidebar-2' );
$has_sidebar_3 = is_active_sidebar( 'sidebar-3' );
if ( $has_sidebar_1 || $has_sidebar_2 || $has_sidebar_3 ) {
	?>
			<?php if ( $has_sidebar_1 || $has_sidebar_2 || $has_sidebar_3 ) { ?>
				<div class="footer-nav-widgets-wrapper header-footer-group">
					<div class="footer-inner section-inner">
          <div class="grid-x grid-padding-x contact-content-style">
            <div class="cell large-12">
              <div class="grid-x grid-margin-x">
     						<?php if ( $has_sidebar_1 ) { ?>
     							<div class="large-4 medium-4 cell callout form-style">
     								<?php dynamic_sidebar( 'sidebar-1' ); ?>
     							</div>
     						<?php } ?>

     						<?php if ( $has_sidebar_2 ) { ?>
     							<div class="large-4 medium-4 cell callout">
     								<?php dynamic_sidebar( 'sidebar-2' ); ?>
     							</div>
     						<?php } ?>
     						<?php if ( $has_sidebar_3 ) { ?>
     							<div class="large-4 medium-4 cell callout">
     								<?php dynamic_sidebar( 'sidebar-3' ); ?>
     							</div>
     						<?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
			<?php } ?>
  </section>
</main>
<?php } ?>
<!--End of Footer Widgets-->
<footer>
 <div class="grid-container">
   <div class="grid-x">
     <div class="cell large-12">
       <ul class="menu simple align-center">
         <li><a href="#"><img class="img-socmed" src="<?php echo get_template_directory_uri(); ?>/img/sm-1.png" alt="Facebook Icon"></a></li>
         <li><a href="#"><img class="img-socmed" src="<?php echo get_template_directory_uri(); ?>/img/sm-2.png" alt="Twitter Icon"></a></li>
         <li><a href="#"><img class="img-socmed" src="<?php echo get_template_directory_uri(); ?>/img/sm-3.png" alt="LinkedIn Icon"></a></li>
         <li><a href="#"><img class="img-socmed" src="<?php echo get_template_directory_uri(); ?>/img/sm-4.png" alt="Instagram Icon"></a></li>
       </ul>
       <br>
       <ul class="menu simple align-center">
         <li><a href="#">Terms</a></li>
         <li><a href="#">Privacy</a></li>
         <li><a href="#">Login</a></li>
       </ul>
     </div>
   </div>
 </div>
</footer>
