<!--Trending Template - Silvena Lam-->
<!--Trending Header -->
<section class="main-1-trending">
  <div class="grid-x grid-padding-x main-3-header">
    <div class="cell large-12">
      <div class="trending_link">
        <h2 class="button">Trending</h2>
      </div>
    </div>
  </div>
  <!--Dynamically Load Trending Articles - Silvena Lam-->
        <?php
        $content = New wp_query([
            'post_type' => 'trends',
            'posts_per_page' => -1
          ]);
        $total_posts = $content->found_posts;
        $count = 0;
        if ($content->have_posts()) : while ($content->have_posts()) : $content->the_post();
            $page = get_permalink();
            $page_link="'$page'";
            $url = home_url('/trends_c/');
            if ($count == 0){
              echo'<div class="grid-x grid-padding-x trending-content-style">';
                echo'<div class="cell large-12">';
                  echo'<div class="grid-x grid-margin-x">';
                    echo'<div class="cell large-4 medium-6">';
                      echo'<div class="card">';
                      echo'<div class="redirect" onclick="pageload('.$page_link.')"><img src="'.get_the_post_thumbnail_url().'"></div>';
                        echo'<div class="card-section">';
                          echo'<h2>'.get_the_title().'</h2>';
                          $terms = wp_get_post_terms($post->ID, 'trends_c');
                          //$tax = array();
                          echo'<p>Categories: ';
                          if (count($terms) > 0){
                            for ($i=0; $i<count($terms); $i++){
                              $this_term = $terms[$i]->name;
					 		  $this_term = ($this_term === "Videos")?"Video":$this_term;
                              $this_url = $url.strtolower($this_term);
                              $this_url = "'$this_url'";
                              if ($i!=(count($terms)-1)){
                              echo '<span class="trends_c_link" onclick="pageload('.$this_url.')">'.$this_term.', </span>';
                              }
                              else echo '<span class="trends_c_link" onclick="pageload('.$this_url.')">'.$this_term.'</span>';
                            }
                          }
                          echo '</p>';
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
                          $terms = wp_get_post_terms($post->ID, 'trends_c');
                          echo'<p>Categories: ';
                          if (count($terms) > 0){
                            for ($i=0; $i<count($terms); $i++){
                              $this_term = $terms[$i]->name;
							  $this_term = ($this_term === "Videos")?"Video":$this_term;
                              $this_url = $url.strtolower($this_term);
                              $this_url = "'$this_url'";
                              if ($i!=(count($terms)-1)){
                              echo '<span class="trends_c_link" onclick="pageload('.$this_url.')">'.$this_term.', </span>';
                              }
                              else echo '<span class="trends_c_link" onclick="pageload('.$this_url.')">'.$this_term.'</span>';
                            }
                          }
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
                  $terms = wp_get_post_terms($post->ID, 'trends_c');
                  echo'<p>Categories: ';
                  if (count($terms) > 0){
                    for ($i=0; $i<count($terms); $i++){
                      $this_term = $terms[$i]->name;
					  $this_term = ($this_term === "Videos")?"Video":$this_term;
                      $this_url = $url.strtolower($this_term);
                      $this_url = "'$this_url'";
                      if ($i!=(count($terms)-1)){
                      echo '<span class="trends_c_link" onclick="pageload('.$this_url.')">'.$this_term.', </span>';
                      }
                      else echo '<span class="trends_c_link" onclick="pageload('.$this_url.')">'.$this_term.'</span>';
                    }
                  }
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
