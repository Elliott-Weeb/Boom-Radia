<!--About Template - Chad Yusoff-->
<!--About Header -->
<section class="main-2-contests">
  <div class="grid-x grid-padding-x main-2-header">
    <div class="cell large-12">
      <div class="about_link">
        <h2 class="button">About</h2>
      </div>
    </div>
  </div>
  <!--Load About Elements Dynamically- Chad Yusoff and Silvena Lam-->
  <?php
    $content = New wp_query([
      'post_type' => 'about',
      'posts_per_page' => -1
    ]);
    $total_posts = $content->found_posts;
    $count = 0;
    if ($content->have_posts()) : while ($content->have_posts()) : $content->the_post();
        if ($count == 0){
          echo'<div class="grid-x grid-padding-x trending-content-style">';
            echo'<div class="cell large-12">';
					echo '<div class="card">';
						echo '<img src="'.get_template_directory_uri().'/img/boom-team.jpg" alt="About 1">';
						echo '<div class="card-section">';
							echo '<h2>About BOOM Radio</h2>';
							echo '<p>Officially launched in 2012, BOOM Radio is a student run, not-for-profit online radio station operating out
							of North Metropolitan TAFE, Leederville.</p>';
						echo '</div>';
					echo '</div>';
              echo'<div class="grid-x grid-margin-x">';
                echo'<div class="cell large-6 medium-6">';
                  echo'<div class="card">';
                  echo'<img src="'.get_the_post_thumbnail_url().'">';
                    echo'<div class="card-section">';
                      echo'<h2>'.get_the_title().'</h2>';
                      echo the_content();
                    echo'</div>';
                  echo'</div>';
                echo'</div>';
          $count++;
        }
        else if ($count % 2 == 0){
          echo'</div>';
          echo'<div class="grid-x grid-padding-x trending-content-style">';
            echo'<div class="cell large-12">';
              echo'<div class="grid-x grid-margin-x">';
                echo'<div class="cell large-6 medium-6">';
                  echo'<div class="card">';
                  echo'<img src="'.get_the_post_thumbnail_url().'">';
                    echo'<div class="card-section">';
                      echo'<h2>'.get_the_title().'</h2>';
                      echo the_content();
                    echo'</div>';
                  echo'</div>';
                echo'</div>';
          $count++;
        }
        else {
          echo'<div class="cell large-6 medium-6">';
            echo'<div class="card">';
            echo'<img src="'.get_the_post_thumbnail_url().'">';
              echo'<div class="card-section">';
                echo'<h2>'.get_the_title().'</h2>';
                echo the_content();
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
  <!--End of About Elements Loader-->
</section>
