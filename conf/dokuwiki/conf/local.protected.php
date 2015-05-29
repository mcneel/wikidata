<?php
/*
 * Dokuwiki's Main Configuration File - Local Settings
 */

$conf['title'] = 'McNeel Wiki';
$conf['start'] = 'homepage';
$conf['template'] = 'mcneel-public';
$conf['disableactions'] = 'backlink,register';
$conf['license'] = '';
$conf['savedir'] = './wikidata';
$conf['breadcrumbs'] = 0;
$conf['dformat'] = '%Y/%m/%d';
$conf['maxtoclevel'] = '0';
$conf['useheading'] = '1';
$conf['useacl'] = 1;
$conf['defaultgroup'] = 'unapproved_user';
$conf['superuser'] = 'brian,steve,bob';
$conf['manager'] = '@mcneel';
$conf['securecookie'] = 0;
$conf['jpg_quality'] = 85;
$conf['sitemap'] = 7;
$conf['rss_type'] = 'rss2';
$conf['basedir'] = '/';
$conf['userewrite'] = '1';
$conf['useslash'] = 1;
$conf['canonical'] = 1;
$conf['gzip_output'] = 1;
$conf['plugin']['gitbacked']['pushAfterCommit'] = 1;
$conf['plugin']['gitbacked']['periodicPull'] = 1;
$conf['plugin']['translation']['translations'] = 'de es fr it ja ko zh zh-tw';
$conf['plugin']['translation']['skiptrans'] = 'developer:.*';
$conf['plugin']['translation']['display'] = 'langcode';
