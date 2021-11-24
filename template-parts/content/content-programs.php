<!--Program Template - Silvena Lam-->
<!--Program Header-->
<section class="main-1-programs">
  <div class="grid-x grid-padding-x main-1-header">
    <div class="cell large-12">
      <div class="programs_link">
        <h2 class="button">Programs</h2>
      </div>
    </div>
  </div>
<!--Load Radio Show Dynamically - Silvena Lam-->
<!--Create Tabs and Load Content into Tabs Dynamically-->
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
            echo '<li class="tabs-title"><a id ="'.$a_label.'" data-tabs-target="'.$label.'" aria-selected="true" onclick="myFunction(\''.$label.'\')">'.$show.'</a></li>';
          }
          else echo '<li class="tabs-title"><a id="'.$a_label.'" data-tabs-target="'.$label.'" aria-selected="false" onclick="myFunction(\''.$label.'\')">'.$show.'</a></li>';
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
          echo '<li class="tabs-title"><a id ="'.$a_label.'"  data-tabs-target="'.$label.'" onclick="myFunction(\''.$label.'\')">'.$show.'</a></li>';
        }
        echo '</ul>';
        echo '</li>';
        echo '</ul>';
    }
    echo '<div class="tabs-content" data-tabs-content="program-tabs">';
    foreach ($radio_show as $index => $show){
        $content = New wp_query([
          'post_type' => 'programs',
          'posts_per_page' => -1,
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
            if ($content->have_posts()) : while ($content->have_posts()) : $content->the_post();
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
<!--End of Content Loader-->
<div id="rs" style="display:none;"><?php echo json_encode($radio_show); ?></div>
</section>
