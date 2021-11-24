<!--Single Program/Host Bio Page Template -- Silvena Lam-->
<section class="main-1-programs">
  <div class="grid-x grid-padding-x main-1-header">
    <div class="cell large-12">
      <div class="programs_link">
        <h2 class="button">
          <?php //get taxonomy term of currnet post i.e. the name of the show
           $term_list = wp_get_post_terms( $post->ID, 'show', array( 'fields' => 'names' ) );
           echo $term_list[0]; ?>
        </h2>
      </div>
    </div>
  </div>
  <div class="grid container biopage">
    <div class="grid-x grid-padding-x biocontent">
      <div class="row large-11">
        <div class="grid-x grid-margin-x grid-margin-y align-center">
          <div class="cell large-12 callout">
            <img src="<?php echo get_field('banner');?>">
          </div>
          <div class="cell large-12 medium-12 small-12 bio">
            <h3>About</h3>
            <p><?php echo get_field('show_description');?></p>
          </div>
          <div class="cell large-12 medium-12 small-12">
          </div>
        </div>
      </div>
      <div class="row large-11">
        <div class="grid-x grid-margin-x grid-margin-y align-center">
          <div class="cell large-3 medium-7 small-8">
            <img class="bio-portrait" src="<?php echo get_field('host_1_image');?>" alt="Image of Host 1">
          </div>
          <div class="cell large-3 medium-11 small-11 bio">
            <h4><?php echo get_field('host_1_name');?></h4>
            <p><?php echo get_field('host_1_description');?></p>          </div>
          <div class="cell large-3 medium-7 small-8">
            <img class="bio-portrait" src="<?php echo get_field('host_2_image');?>" alt="Image of Host 2">
          </div>
          <div class="cell large-3 medium-11 small-11 bio">
            <h4><?php echo get_field('host_2_name');?></h4>
            <p><?php echo get_field('host_2_description');?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
