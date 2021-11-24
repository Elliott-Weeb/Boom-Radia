<!--Sponsors Template - Silvena Lam-->
<!--Sponsors Header -->
<section class="main-2-contests">
  <div class="grid-x grid-padding-x main-2-header">
    <div class="cell large-12">
      <div class="sponsors_link">
        <h2 class="button">Sponsors</h2>
      </div>
    </div>
  </div>
  <!--Dynmically Load Sponsors - Silvena Lam-->
  <?php
    $content = New wp_query([
      'post_type' => 'sponsors',
      'posts_per_page' => -1
    ]);
    $total_posts = $content->found_posts;
    $count = 0;
    if ($content->have_posts()) : while ($content->have_posts()) : $content->the_post();
        $this_link = get_field('hyperlink');
        if (empty($this_link) || is_null($this_link)){
          $this_link = "#";
        }
        if ($count == 0){
          echo'<div class="grid-x grid-padding-x trending-content-style">';
            echo'<div class="cell large-12">';
              echo'<div class="grid-x grid-margin-x">';
                echo'<div class="cell large-4 medium-6">';
                  echo'<div class="card">';
                    //echo'<a href="'.get_permalink().'"><img src="'.get_the_post_thumbnail_url().'"></a>';
                    echo'<a href="'.$this_link.'"><img src="'.get_the_post_thumbnail_url().'"></a>';
                    echo'<div class="card-section">';
                      echo'<h2>'.get_the_title().'</h2>';
                      echo the_excerpt();
                    echo'</div>';
                  echo'</div>';
                echo'</div>';
          $count++;
        }
        else if ($count % 3 == 0){
          echo'</div>';
          echo'<div class="grid-x grid-padding-x trending-content-style">';
            echo'<div class="cell large-12">';
              echo'<div class="grid-x grid-margin-x">';
                echo'<div class="cell large-4 medium-6">';
                  echo'<div class="card">';
                    echo'<a href="'.$this_link.'"><img src="'.get_the_post_thumbnail_url().'"></a>';
                    echo'<div class="card-section">';
                      echo'<h2>'.get_the_title().'</h2>';
                      echo the_excerpt();
                    echo'</div>';
                  echo'</div>';
                echo'</div>';
          $count++;
        }
        else {
          echo'<div class="cell large-4 medium-6">';
            echo'<div class="card">';
              echo'<a href="'.$this_link.'"><img src="'.get_the_post_thumbnail_url().'"></a>';
              echo'<div class="card-section">';
                echo'<h2>'.get_the_title().'</h2>';
                echo the_excerpt();
              echo'</div>';
            echo'</div>';
          echo'</div>';
          $count++;
        }
        if ($count == $total_posts){
                echo'</div>';
              echo'</div>';
            echo'</div>';
          echo'</div>';
        }
  endwhile; endif;
  ?>
  <!--End of Content Loader-->
</section>
