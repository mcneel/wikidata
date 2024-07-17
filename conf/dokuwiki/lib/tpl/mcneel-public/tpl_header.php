<?php
/**
 * Template header, included in the main and detail files
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
?>

<!-- ********** HEADER ********** -->
<div id="dokuwiki__header"><div class="pad group">

    <?php tpl_includeFile('header.html') ?>

    <div class="headings group">
        <h1><?php
            // get logo either out of the template images folder or data/media folder
            $logoSize = array();
            $logo = tpl_getMediaFile(array(':wiki:logo.png', 'images/logo.png'), false, $logoSize);

            // display logo and wiki title in a link to the home page
            tpl_link(
                wl(),
                '<span>'.$conf['title'].'</span>',
                'accesskey="h" title="[H]"'
            );
        ?>!!!</h1>
        <?php if ($conf['tagline']): ?>
            <p class="claim"><?php echo $conf['tagline']; ?></p>
        <?php endif ?>
    </div>

    <div class="tools group">
        <!-- SITE TOOLS -->
        <div id="dokuwiki__sitetools">
            <h3 class="a11y"><?php echo $lang['site_tools']; ?></h3>
            <form id="cref" action="https://www.rhino3d.com/searchresults/">
                <label for="search"><input id="searchtext" type="text" name="q" size="24" value="" placeholder="{{ i18n "search-navbar" }}" /></label>  
                <input class="searchBox" type="submit" name="sa" size="2" aria-label="Search" value=" "/>
            </form>
<!---            <?php tpl_searchform(); ?>  -->
            <div class="mobileTools">
                <?php tpl_actiondropdown($lang['tools']); ?>
            </div>
        </div>

        <!--
		<ul id="navmenu">
			<li><a href="http://www.rhino3d.com">Home!</a></li>
			<li><a href="http://gallery.mcneel.com/?language=<%=displayLang%>&g=1">Gallery</a></li>
			<li><a href="http://www.rhino3d.com/download.htm">Download</a></li>
			<li><a href="http://www.rhino3d.com/sales.htm">Sales</a></li>
			<li><a href="http://www.rhino3d.com/support.htm">Support</a></li>
			<li><a href="http://www.rhino3d.com/training.htm">Training</a></li>
			<li><a href="http://www.rhino3d.com/links.htm">Resources</a></li>
		</ul>
		-->
    </div>

    <!-- BREADCRUMBS -->
    <?php if($conf['breadcrumbs'] || $conf['youarehere']): ?>
        <div class="breadcrumbs">
            <?php if($conf['youarehere']): ?>
                <div class="youarehere"><?php tpl_youarehere() ?></div>
            <?php endif ?>
            <?php if($conf['breadcrumbs']): ?>
                <div class="trace"><?php tpl_breadcrumbs() ?></div>
            <?php endif ?>
        </div>
    <?php endif ?>

    <hr class="a11y" />
</div>
</div><!-- /header -->
