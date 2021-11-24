<!--Get menu items -- Silvena Lam-->
<?php
$menuLocations = get_nav_menu_locations();
$menuID = $menuLocations['boom-radio-menu'];
$primaryNav = wp_get_nav_menu_items($menuID);
$menuItems = array();
foreach ( $primaryNav as $navItem ) {
    array_push($menuItems, strtolower($navItem->title));
}
?>
<!--End of menu items retrieval -->
<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BOOM Radio - Not Just Noise</title>
<?php wp_head(); ?>
</head>
<body>
<header>
<!--Top Nav-->
<nav>
  <div class="title-bar" data-responsive-toggle="example-menu" data-hide-for="medium">
    <button class="menu-icon" type="button" data-toggle="example-menu"></button>
    <div class="title-bar-title"></div>
  </div>
  <div class="top-bar" id="example-menu">
    <div class="top-bar-left">
      <div id="home"><img class="boom-logo-1" src="<?php echo get_template_directory_uri(); ?>/img/boom-logo-a1-white.png" alt="BOOM Radio logo"></div>
    </div>
    <div class="top-bar-right">
      <!--Navigation menu -- Silvena Lam-->
      <?php
      echo '<ul class="dropdown menu vertical medium-horizontal">';
      foreach ( $primaryNav as $navItem ) {
          $menuTitle = $navItem->title;
          echo '<li><a id="'.strtolower($menuTitle).'">'.$menuTitle.'</a></li>';
      }
      echo '</ul>';
      ?>
      <!--End of Navigation Menu-->
      <ul class="menu simple align-center hide-for-large hide-for-medium top-nav-sm">
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/sm-1.png" alt="Facebook Icon"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/sm-2.png" alt="Twitter Icon"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/sm-3.png" alt="LinkedIn Icon"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/sm-4.png" alt="Instagram Icon"></a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Radio Player -- Elliott Web-->
<section class="radio-player">
  <div class="grid-container">
    <div class="grid-x">
      <!-- Dynamic Images -->
      <div class="cell large-2">
        <!-- <img class="album-cover" src="<?php echo get_template_directory_uri(); ?>/img/radiosquare.jpg" alt="Album Cover"> -->
        <img class="album-cover" src="<?php echo get_template_directory_uri(); ?>/img/radiosquare.jpg" alt="Album Cover">
      </div>
      <div class="cell large-2">
      <!-- Dynamic Song Titles -->
      <div id="title0" class="subtitle"></div>
      </div>
      <!-- Wave Animation -- Elliott Web  -->
      <div class="cell large-4">
        <div class="wave-bars">
          <div class="wave wave-1 no-animation"></div>
          <div class="wave wave-2 no-animation"></div>
          <div class="wave wave-3 no-animation"></div>
          <div class="wave wave-4 no-animation"></div>
          <div class="wave wave-5 no-animation"></div>
          <div class="wave wave-1 no-animation"></div>
          <div class="wave wave-2 no-animation"></div>
          <div class="wave wave-3 no-animation"></div>
          <div class="wave wave-4 no-animation"></div>
          <div class="wave wave-5 no-animation"></div>
          <div class="wave wave-1 no-animation"></div>
          <div class="wave wave-2 no-animation"></div>
          <div class="wave wave-3 no-animation"></div>
        </div>
      </div>
      <!-- Play/Pause Button -- Elliott Web-->
      <div class="cell large-2">
        <div id="station0" class="station">
          <div class="controlsOuter">
           <div class="controlbutton button-play">
            <i class="fa fa-play" aria-hidden="true" ></i>
           </div>
          </div>
        </div>
      </div>
      <!-- External Radio Player -- Elliott Web-->
      <!-- <div class="cell large-2">
       <p id="external">Or use the external player <a href="http://tun.in/se72I" target="popup" onclick="window.open('http://tun.in/se72I','name','width=600,height=150')">here </a>
      </div> -->
    </div>
  </div>
</section>
<!--JQuery script to load content into a DOM element-- Silvena Lam-->
<script type="text/javascript" language="javascript">
//Loop items from WP menu and load dynamic content into home container on click - Silvena Lam
function getMenuElements(){
      var menu_arr = <?php echo json_encode($menuItems); ?>;
      $.each(menu_arr, function(index, val) {
          $(document).ready( function() {
              $('#' + val + '').on('click', function() {
                  $('#home-container').load('<?php echo home_url(); ?>/' + val + ' #home-container');
              });
              $('body').on('click', '.' + val + '_link', function() {
                  $('#home-container').load('<?php echo home_url(); ?>/' + val + ' #home-container', function() {
                  $("html, body").animate({ scrollTop: 0 }, 600, function(){
                    setTimeout(function() {
                    }, 5000);
                  });
                });
              });
          });
      });
  }
getMenuElements();

//Reload index page content into home container on click and reinitiate foundation plugins - Silvena Lam
$(document).ready( function() {
    $('#home').on('click', function() {
        $('#home-container').load("<?php echo home_url()?>" + ' #home-container', function() {
          $.getScript("<?php echo get_template_directory_uri().'/'; ?>js/app.js");
        });
    });
});

//Ajax Load New Page - Silvena Lam
function pageload(url){
  $('#home-container').load(url + ' #home-container', function() {
    $("html, body").animate({ scrollTop: 0 }, 600);
  });
}
</script>
<!--End of Ajax Load script -->
</header>
