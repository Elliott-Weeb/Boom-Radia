<!--Contest Template - Silvena Lam-->
<!--Contest Header -->
<section class="main-1-contests">
  <div class="grid-x grid-padding-x main-2-header">
    <div class="cell large-12">
      <div class="contests_link">
        <h2 class="button">Contests</h2>
      </div>
    </div>
  </div>
  <!--Load Contests Dynamically- Silvena Lam-->
  <?php
    $content = New wp_query([
      'post_type' => 'contests',
      'posts_per_page' => -1
    ]
    );
    $total_posts = $content->found_posts;
    $count = 0;
    if ($content->have_posts()) : while ($content->have_posts()) : $content->the_post();
        $page = get_permalink();
        $page_link="'$page'";
        if ($count == 0){
          echo'<div class="grid-x grid-padding-x trending-content-style">';
            echo'<div class="cell large-12">';
              echo'<div class="grid-x grid-margin-x">';
                echo'<div class="cell large-4 medium-6">';
                  echo'<div class="card">';
                  echo'<div class="redirect" onclick="pageload('.$page_link.')"><img src="'.get_the_post_thumbnail_url().'"></div>';
                    echo'<div class="card-section">';
                      echo'<h2>'.get_the_title().'</h2>';
                      echo '<p>Ends '.get_field('end_date').'</p>';
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
                  echo'<div class="redirect" onclick="pageload('.$page_link.')"><img src="'.get_the_post_thumbnail_url().'"></div>';
                    echo'<div class="card-section">';
                      echo'<h2>'.get_the_title().'</h2>';
                      echo '<p>Ends '.get_field('end_date').'</p>';
                    echo'</div>';
                  echo'</div>';
                echo'</div>';
          $count++;
        }
        else {
          echo'<div class="cell large-4 medium-6">';
            echo'<div class="card">';
            echo'<div class="redirect" onclick="pageload('.$page_link.')"><img src="'.get_the_post_thumbnail_url().'"></div>';
              echo'<div class="card-section">';
                echo'<h2>'.get_the_title().'</h2>';
                echo '<p>Ends '.get_field('end_date').'</p>';
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
  <!--End of Contests Loader-->
</section>
