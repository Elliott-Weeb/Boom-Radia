<!--Single Trend Page Template -- Silvena Lam-->
<section class="main-1-content">
  <div class="grid-x grid-padding-x main-1-header">
    <div class="cell large-12">
<!--Get All Taxonomy Terms of Current Post - Silvena Lam-->
      <?php $post_terms = get_the_terms($post->id, 'trends_c');
      //get_the_terms, returns objects of all terms of the current article - SL
      //get_terms, returns array of all terms of given taxonomies - SL
      foreach ( $post_terms as $post_term ) {
        $all_terms[] = $post_term->slug;
      };
      ?>
<!--Get Link of Custom Post Type - Silvena Lam-->
      <div class="trending_link">
        <h2 class="button">Trending</h2>
      </div>
    </div>
  </div>
<?php $this_post_id = get_the_id();?>
<!--Dynmically Load Post Content - Chad Yusoff-->
<div class="grid-x grid-margin-x grid-margin-y align-center article-content">
  <div class="cell large-6 medium-9 small-9">
     <?php echo '<img src="'.get_the_post_thumbnail_url().'">'; ?>
  </div>
  <div class="cell large-11 medium-11 small-11 content">
	<?php the_title('<h3>', '</h3>'); ?>
	<?php
		the_content('<p>','</p>');
	?>
	</div>
</div>
</section>
<!--Get Related Articles if Post Type is Trends - Silvena Lam-->
<?php
  echo '<section class="main-2-content">';
    echo '<div class="grid-x grid-padding-x main-2-header">';
  		echo '<div class="cell large-12">';
  			echo '<div class="related">';
  				echo '<h2 class="button">Related</h2>';
  			echo '</div>';
  		echo '</div>';
    echo '</div>';
//Query on all articles with the taxonomy trends_c and matching terms - SL
//Exclude current post from result - SL
  $args = array(
  		'post_type' => 'trends',
      'posts_per_page' => 3,
      'post__not_in' => array($this_post_id),
      'tax_query' => array(
        'relation' => 'OR',
            array(
              'taxonomy' => 'trends_c',
              'field' => 'slug',
              'terms' => $all_terms,
              'operator' => 'IN'
            ),
      ),
  );
	$content = New wp_query($args);
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
					  //$tax = get_the_taxonomies();
					  //echo '<p>'.implode(",", $tax).'</p>';
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
					  //$tax = get_the_taxonomies();
					  //echo '<p>'.implode(",", $tax).'</p>';
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
				//$tax = get_the_taxonomies();
				//echo '<p>'.implode(",", $tax).'</p>';
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
echo '</section>';
?>
