<?php
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');  
    
class syntax_plugin_anchor extends DokuWiki_Syntax_Plugin {
    function getType() {return 'substition';}
    function getPType() {return 'block';}
    function getSort() {return 167;}
    function getInfo() {return array('author' => 'Eli Fenton', 'name' => 'Anchor Plugin', 'url' => 'http://dokuwiki.org/plugin:anchor');}
    function connectTo($mode){
        $this->Lexer->addSpecialPattern('\{\{anchor:[^}]*\}\}', $mode, 'plugin_anchor');
    }

    function handle($match, $state, $pos, &$handler) {
        return explode(':', substr($match, strlen('{{anchor:'), -2));
    }
 
    function render($mode, &$renderer, $data) {
        $renderer->doc .= '<a name="' .htmlspecialchars($data[0]) . '">' .htmlspecialchars($data[1]) . '</a>';
    }
}