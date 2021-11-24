    <!--Carousel -- Silvena Lam-->
    <div id="carousel">
      <div id="slide">
        <div class="slideshow-container">
            <?php
              $carousel = New wp_query([
                'post_type' => 'carousel',
                'posts_per_page' => -1
              ]);
              $count = 0;
              if ($carousel->have_posts()) : while ($carousel->have_posts()) : $carousel->the_post();
				  $thumbnail_id = get_post_thumbnail_id( $post->ID );
				  $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
				  if($alt === ""){
					  $alt="/";
				  }
                  echo'<div class="mySlides fade">';
                  echo'<img src="'.get_the_post_thumbnail_url().'" alt="'.$alt.'" style="width:100%">';
                  echo'</div>';
                  $count++;
                endwhile;
              else:
                echo'<img src="'.get_the_post_thumbnail_url().'" alt="'.$alt.'" style="width:100%">';
              endif;

          ?>
          <a class="prev" onclick="plusSlides(-1)">❮</a> <a class="next" onclick="plusSlides(1)">❯</a> </div>
        <div class="slide-dots">
        <?php
          for($i=1; $i<=$count; $i++){
            echo '<span class="dot" onclick="currentSlide('.$i.')"></span>';
          }
        ?>
        </div>
      </div>
    </div>
    <!--End of Carousel-->
    <!--Program Header-->
    <section class="main-1-programs">
      <div class="grid-x grid-padding-x main-1-header">
        <div class="cell large-12">
          <div class="programs_link">
            <h2 class="button">Programs</h2>
          </div>
        </div>
      </div>
      <!--Program Content-->
      <!--Accordion - Create Tabs and Load content into Tabs dynamically - Silvena Lam-->
        <div class="grid container">
          <div class="grid-x grid-padding-x">
            <div class="cell large-12 program-tabs-style">
            <?php
            $terms = get_terms( array(
                'taxonomy' => 'show',
                'post_type' => 'programs',
            ) );
            if ( $terms && ! is_wp_error( $terms ) ){
                $radio_show = array();
                foreach ( $terms as $term ) {
                    $radio_show [] = $term->name;
                }
            }
            $key = array_search('The Drive Home', $radio_show);
            $temp=$radio_show[$key];
            unset($radio_show[$key]);
            array_unshift($radio_show, $temp);
            $key = array_search('BOOM\'s Big Breakfast', $radio_show);
            $temp=$radio_show[$key];
            unset($radio_show[$key]);
            array_unshift($radio_show, $temp);

            $show_count = count($radio_show);
            if ($show_count > 0){
                echo '<ul class="tabs hide-for-small-only" data-tabs id="program-tabs" data-deep-link="true">';
                foreach ($radio_show as $index => $show){
                  $label = "panel".($index+1);
                  $a_label = "a-".$label;
                  //$url = "#".$label;
                  if ($index == 0){
                    echo '<li class="tabs-title is-active"><a id="'.$a_label.'" role="link" aria-selected="true" onclick="myFunction(\''.$label.'\')">'.$show.'</a></li>';
                  }
                  else echo '<li class="tabs-title"><a id="'.$a_label.'" role="link" aria-selected="false" onclick="myFunction(\''.$label.'\')">'.$show.'</a></li>';
                }
                echo '</ul>';
            }
            if ($show_count > 0){
                echo '<ul class="vertical menu accordion-menu hide-for-large hide-for-medium show-dropdown" data-accordion-menu>';
                echo '<li>';
                echo '<a class="programs_link" aria-selected="true">Programs Menu</a>';
                echo '<ul class="menu vertical nested">';
                foreach ($radio_show as $index => $show){
                  $label = "panel".($index+1);
                  $a_label = "a-".$label;
                  //$url = "#".$label;
                  echo '<li class="tabs-title"><a id="'.$a_label.'" role="link" data-tabs-target="'.$label.'" onclick="myFunction(\''.$label.'\')">'.$show.'</a></li>';
                }
                echo '</ul>';
                echo '</li>';
                echo '</ul>';
            }
            echo '<div class="tabs-content" data-tabs-content="program-tabs">';
            foreach ($radio_show as $index => $show){
                $programs = New wp_query([
                  'post_type' => 'programs',
                  'posts_per_page' => 3,
                  'tax_query' => array(
                      array (
                          'taxonomy' => 'show',
                          'field' => 'name',
                          'terms' => $show,
                      ),
                  ),
                ]);
                $label = "panel".($index+1);
                $active = ($index == 0) ? "is-active" : NULL;
                echo '<div class="tabs-panel '.$active.'" id="'.$label.'">';
                echo '<div class="grid-x grid-margin-x">';
                    if ($programs->have_posts()) : while ($programs->have_posts()) : $programs->the_post();
                      $page = get_permalink();
                      $page_link="'$page'";
                      echo'<div class="cell large-4 medium-6 callout">';
                      echo'<div class="redirect" onclick="pageload('.$page_link.')"><img src="'.get_the_post_thumbnail_url().'" alt="'.$show.'"></div>';
                      echo'</div>';
                    endwhile; endif;
                  echo'</div>';
                echo'</div>';
                wp_reset_query();
            }
        ?>
            </div>
          </div>
        </div>
      </div>
      <!--End of Programs Content-->
    </section>

    <!--Contests Header -->
    <section class="main-1-contests">
      <div class="grid-x grid-padding-x main-2-header">
        <div class="cell large-12">
          <div class="contests_link">
            <h2 class="button">Contests</h2>
          </div>
        </div>
      </div>
      <!--Contests Content-->
      <!--Dynamic Contests Loader - Silvena Lam-->
      <?php
        $contests = New wp_query([
          'post_type' => 'contests',
          'posts_per_page' => 3,
        ]
        );
        $count = 0;
        if ($contests->have_posts()) : while ($contests->have_posts()) : $contests->the_post();
            $page = get_permalink();
            $page_link="'$page'";
            if ($count == 0){
              echo'<div class="grid-x grid-padding-x trending-content-style">';
                echo'<div class="cell large-12">';
                  echo'<div class="grid-x grid-margin-x">';
            }
            echo'<div class="cell large-4 medium-6">';
              echo'<div class="card">';
              echo'<div class="redirect" onclick="pageload('.$page_link.')"><img src="'.get_the_post_thumbnail_url().'" alt="'.$show.'"></div>';
                echo'<div class="card-section">';
                  echo'<h2>'.get_the_title().'</h2>';
                  echo '<p>Ends '.get_field('end_date').'</p>';
                echo'</div>';
              echo'</div>';
            echo'</div>';
             $count++;
             if ($count == 3){
                  echo'</div>';
                echo'</div>';
              echo'</div>';
            }
        endwhile; endif;
        ?>
        <!--End of Contests Content-->
    </section>
    <!--Trending Header -->
    <section class="main-1-trending">
      <div class="grid-x grid-padding-x main-3-header">
        <div class="cell large-12">
          <div class="trending_link">
            <h2 class="button">Trending</h2>
          </div>
        </div>
      </div>
      <!--Trending Content-->
      <!--Dynamic Contests Loader - Silvena Lam-->
      <?php
        $trends = New wp_query([
          'post_type' => 'trends',
          'posts_per_page' => 3,
        ]
        );
        $count = 0;
        if ($trends->have_posts()) : while ($trends->have_posts()) : $trends->the_post();
            $page = get_permalink();
            $page_link="'$page'";
            $url = home_url('/trends_c/');
            if ($count == 0){
              echo'<div class="grid-x grid-padding-x trending-content-style">';
                echo'<div class="cell large-12">';
                  echo'<div class="grid-x grid-margin-x">';
            }
            echo'<div class="cell large-4 medium-6">';
              echo'<div class="card">';
              echo'<div class="redirect" onclick="pageload('.$page_link.')"><img src="'.get_the_post_thumbnail_url().'" alt="'.$show.'"></div>';
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
                      //echo $this_url;
                      if ($i!=(count($terms)-1)){
                      echo '<span class="trends_c_link" onclick="pageload('.$this_url.')">'.$this_term.', </span> ';
                      }
                      else echo '<span class="trends_c_link" onclick="pageload('.$this_url.')">'.$this_term.'</span>';
                    }
                  }
                echo'</div>';
              echo'</div>';
            echo'</div>';
             $count++;
             if ($count == 3){
                  echo'</div>';
                echo'</div>';
              echo'</div>';
            }
        endwhile; endif;
    ?>
    <!--End of Trending Content-->
    </section>
    <div id="rs" style="display:none;"><?php echo json_encode($radio_show); ?></div>
