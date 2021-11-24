<?php get_template_part( 'template-parts/footer-widgets' ); ?>
<?php wp_footer(); ?>
<script src="<?php echo get_template_directory_uri().'/'; ?>js/howler.core.js"></script>
<script src="<?php echo get_template_directory_uri().'/'; ?>js/radio.js"></script>
<!-- Change aria-selected attribute after load - Silvena Lam  -->
<!-- This is a fix for anchor element not working when content is load through ajax (becasue of the url masking invovled)  -->
<script type="text/javascript">
    //function to read json in a hidden div on page
    function myFunc(variable){
        var s = document.getElementById(variable);
        htmlContent = JSON.parse(s.innerHTML);
    }
    myFunc("rs");
    //function to change aria-selected attribute after load
    function myFunction(selected) {
      for (var i = 1; i < htmlContent.length+1; i++) {
          var label = "panel" + i;
          var a_label = "a-panel" + i;
          document.getElementById(label).className = "tabs-panel";
          document.getElementById(a_label).setAttribute("aria-selected", false);
      }
      document.getElementById(selected).className = "tabs-panel is-active";
      var a_selected = "a-" + selected;
      document.getElementById(a_selected).setAttribute("aria-selected", true);
    }
</script>
<!--End of aria-selected changer-->

<!-- Get Album Cover and Title of the Song being played - Silvena Lam  -->
<script>
    var refresh = 30000;
    $(document).ready(loadCover);
    function loadCover(){
        var url =  "https://feed.tunein.com/profiles/s195836/nowPlaying";
        var getCover = $.getJSON(url, function(result){
             $("#title0").text(result.Secondary.Title);
             $(".album-cover").attr("src", result.Secondary.Image);
        });
        setTimeout(loadCover, 30000);
    }
</script>
</html>
