<?php
/**
 * Template footer, included in the main and detail files
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
?>

<!-- ********** FOOTER ********** -->
<div id="dokuwiki__footer"><div class="pad">
	<div class="full_divider"></div>
    <?php html_msgarea() ?>
    <div class="buttons">
		<span><font color=#8D8D8D>&copy; 1997-<?php print(date("Y")) ?>&nbsp;<b>McNeel</b> &bull;
		<a title="Seattle: US, Canada, Australia, &amp; New Zealand" href="http://www.en.na.mcneel.com/contact.htm">North America</a> &bull;
		<a title="Barcelona: Europe, Middle East, &amp; Africa" href="http://www.en.emea.mcneel.com">Europe</a> &bull;
		<a title="Miami: Latin American &amp; Southeast US" href="http://www.en.la.mcneel.com">Latin America</a> &bull;
		<a href="http://www.en.as.mcneel.com">Asia</a></font>&nbsp;&nbsp;&nbsp;&nbsp;
		</span>
        <?php
            tpl_license('button', true, false, false); // license button, no wrapper
            $target = ($conf['target']['extern']) ? 'target="'.$conf['target']['extern'].'"' : '';
        ?>
        <a href="feed.php" title="Recent Changes RSS Feed" <?php echo $target?>><img
            src="<?php echo tpl_basedir(); ?>images/button-rss.png" width="80" height="15" alt="Recent Changes RSS Feed" /></a>
        <a href="http://dokuwiki.org/" title="Driven by DokuWiki" <?php echo $target?>><img
            src="<?php echo tpl_basedir(); ?>images/button-dw.png" width="80" height="15" alt="Driven by DokuWiki" /></a>
    </div>
</div></div><!-- /footer -->

<!-- Google GA3 tracking -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-512742-6', 'auto');
  ga('send', 'pageview');

</script>

<!-- Google tag GA4 --> 
<script async src="https://www.googletagmanager.com/gtag/js?id=G-EQ9K187465"></script> 
<script> 
    window.dataLayer = window.dataLayer || []; 
    function gtag(){dataLayer.push(arguments);} 
    gtag('js', new Date()); 
    
    gtag('config', 'G-EQ9K187465'); 
</script>

<?php
tpl_includeFile('footer.html');
