<!--Single Page Template - Chad Yusoff & Silvena Lam-->
<?php
//Array to match taxonomy terms with name of css classes for onclick Ajax load script - Silvena Lam
  $links = array(
    "sponsors" => "sponsor_link",
    "contests" => "contests_link"
  );
?>
<section class="main-1-content">
  <div class="grid-x grid-padding-x main-1-header">
    <div class="cell large-12">
<!--Get Post Type- Silvena Lam-->
      <?php
      $type = get_post_type();
      //Get Link of Custom Post Type - Silvena Lam-->
      if($type!="page"){
            echo '<div class="'.$links[$type].'">';
            if($type=="trends"){
            echo '<h2 class="button">Trending</h2>';
            }
            else echo '<h2 class="button">'.$type.'</h2>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
      }
      ?>
<!--End of Get Post Type-->
<?php $this_post_id = get_the_id();?>
<!--Dynmically Load Single Page Content - Chad Yusoff-->
<section class="main-1-content">
<?php $this_post_id = get_the_id();?>
<div class="grid-x grid-margin-x grid-margin-y align-center article-content">
  <?php
  //Display featured image if it is available - Silvena Lam
  $img=get_the_post_thumbnail_url();
  if ($img!==FALSE){
      echo '<div class="cell large-11 medium-11 small-11">';
         echo '<img src="'.$img.'">';
      echo '</div>';
  }
  ?>
  <div class="cell large-11 medium-11 small-11 content">
	<?php the_title('<h3>', '</h3>'); ?>
	<?php
		the_content('<p>','</p>');
	?>
	</div>
</div>
</section>
