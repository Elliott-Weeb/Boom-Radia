<!-Custom Taxonomy Trend Categories Template  - Elliott Webb & Silvena Lam-->
<?php
//Get Custom Taxonomy Term from URL - Silvena Lam
global $wp;
$current_url = parse_url(home_url(add_query_arg(array(), $wp->request)));
$path = end($current_url);
$arr = explode("/", $path);
$temp = array_search('trends_c', $arr);
//$this_cat = end($arr);
$this_cat = $arr[$temp+1]; //cannot use end($arr) as results may be paged - SL
?>
<!--Categories Header-->
<section class="main-2-archives">
  <div class="grid-x grid-padding-x main-3-header">
    <div class="cell large-12">
      <div class="trending_link">
          <h2 class="button"><?php echo ucwords($this_cat); ?></h2>
      </div>
      <div>
      </div>
    </div>
  </div>
<!-- Define Slugs -- Silvena Lam-->
  <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
    'post_type' => 'trends',
    'posts_per_page' => 2,
    'paged' => $paged,
    'relation' => 'OR',
        'tax_query' => array(
            array(
              'taxonomy' => 'trends_c',
              'field' => 'slug',
              'terms' => $this_cat,
            ),
        ),
    );
  	$content = New wp_query($args);

//Get Posts With The Same Custom Taxonomy Term Dynamically -- Elliott Webb & Silvena Lam
  	$total_posts = $content->found_posts;
  	$count = 0;
  	if ( $content->have_posts()): while ( $content->have_posts()) : $content->the_post();
    $page = get_permalink();
    $page_link="'$page./'";
    $url = home_url('/trends_c/');
      if ($count == 0){
  			echo'<div class="grid-x grid-padding-x trending-content-style">';
                  echo'<div class="cell">';
                    echo'<div class="grid-x">';
                      echo'<div class="cell">';
                        echo'<div class="archive card">';
                          echo'<div class="redirect" onclick="pageload('.$page_link.')"><img class="archivethumb" src="'.get_the_post_thumbnail_url().'" alt="'.$show.'"></div>';
  					                echo'<div class="archive card-section">';
                            echo'<h2>'.get_the_title().'</h2>';
                            $terms = wp_get_post_terms($post->ID, 'trends_c');
                            echo'<p>Published on '.get_the_date().' in: ';
                            if (count($terms) > 0){
                              for ($i=0; $i<count($terms); $i++){
                                $this_term = $terms[$i]->name; //get custom taxonomy term name - SL
					  			$this_term = ($this_term === "Videos")?"Video":$this_term;
                                $this_url = $url.strtolower($this_term);
                                $this_url = "'$this_url'";
                                if ($i!=(count($terms)-1)){
                                echo '<span class="trends_c_link" onclick="pageload('.$this_url.')">'.$this_term.', </span>';
                                }
                                else echo '<span class="trends_c_link" onclick="pageload('.$this_url.')">'.$this_term.'</span>';
                              }
                            }
                            echo '</p><span>'.get_the_excerpt().'</span>';
                            wp_link_pages();
                          echo'</div>';
                        echo'</div>';
                      echo'</div>';
                $count++;
              }
              else if ($count % 3 == 0){
                echo'</div>';
                echo'<div class="grid-x grid-padding-x trending-content-style">';
                  echo'<div class="cell">';
                    echo'<div class="grid-x">';
                      echo'<div class="cell">';
                      echo'<div class="archive card">';
                        echo'<div class="redirect" onclick="pageload('.$page_link.')"><img class="archivethumb" src="'.get_the_post_thumbnail_url().'" alt="'.$show.'"></div>';
                          echo'<div class="archive card-section">';
                          echo'<h2>'.get_the_title().'</h2>';
                          $terms = wp_get_post_terms($post->ID, 'trends_c');
                          echo'<p>Published on '.get_the_date().' in: ';
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
                          echo '</p><span>'.get_the_excerpt().'</span>';
                          echo'</div>';
                        echo'</div>';
                      echo'</div>';
                $count++;
              }
              else {
                      echo'<div class="cell">';
                      echo'<div class="archive card">';
                        echo'<div class="redirect" onclick="pageload('.$page_link.')"><img class="archivethumb" src="'.get_the_post_thumbnail_url().'" alt="'.$show.'"></div>';
                          echo'<div class="archive card-section">';
                          echo'<h2>'.get_the_title().'</h2>';
                          $terms = wp_get_post_terms($post->ID, 'trends_c');
                          echo'<p>Published on '.get_the_date().' in: ';
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
                          echo '</p><span>'.get_the_excerpt().'</span>';
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
       endwhile;
  	 endif;
//Pagination
     $total_pages = $content->max_num_pages;
     if ($total_pages>1){
     echo'<div class="cell large-6 medium-4">';
  	 echo'<div class="paginationlinks">';
  	 echo'<p>View More Articles</p>';
  	 echo  sl_paginate_links(array(
  			'total' => $total_pages,
		  	'base' => get_pagenum_link(1) . '%_%',
		    'current' => $paged
  			));
  	 echo'</div>';
  	 echo'</div>';
     }
	 wp_reset_query();
  ?>
</section>
