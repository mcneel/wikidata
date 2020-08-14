<?php
/**
 * Plugin Color: Sets new colors for text and background.
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Christopher Smith <chris@jalakai.co.uk>
 */
 
// must be run within DokuWiki
if(!defined('DOKU_INC')) die();
 
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_color extends DokuWiki_Syntax_Plugin {
 
    function getType(){ return 'formatting'; }
    function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }   
    function getSort(){ return 158; }
    function connectTo($mode) { $this->Lexer->addEntryPattern('<color.*?>(?=.*?</color>)',$mode,'plugin_color'); }
    function postConnect() { $this->Lexer->addExitPattern('</color>','plugin_color'); }
 
 
    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler){
        switch ($state) {
          case DOKU_LEXER_ENTER :
                list($color, $background) = preg_split("/\//u", substr($match, 6, -1), 2);
                if ($color = $this->_isValid($color)) $color = "color:$color;";
                if ($background = $this->_isValid($background)) $background = "background-color:$background;";
                return array($state, array($color, $background));
 
          case DOKU_LEXER_UNMATCHED :  return array($state, $match);
          case DOKU_LEXER_EXIT :       return array($state, '');
        }
        return array();
    }
 
    /**
     * Create output
     */
    function render($mode, Doku_Renderer $renderer, $data) {
        if($mode == 'xhtml'){
            list($state, $match) = $data;
            switch ($state) {
              case DOKU_LEXER_ENTER :      
                list($color, $background) = $match;
                $renderer->doc .= "<span style='$color $background'>"; 
                break;
 
              case DOKU_LEXER_UNMATCHED :  $renderer->doc .= $renderer->_xmlEntities($match); break;
              case DOKU_LEXER_EXIT :       $renderer->doc .= "</span>"; break;
            }
            return true;
        }
        if($mode == 'odt'){
            list($state, $match) = $data;
            switch ($state) {
              case DOKU_LEXER_ENTER :      
                list($color, $background) = $match;
                if (class_exists('ODTDocument')) {
                    $renderer->_odtSpanOpenUseCSS (NULL, 'style="'.$color.$background.'"');
                }
                break;
 
              case DOKU_LEXER_UNMATCHED :
                $renderer->cdata($match);
                break;

              case DOKU_LEXER_EXIT :
                if (class_exists('ODTDocument')) {
                    $renderer->_odtSpanClose();
                }
                break;
            }
            return true;
        }
        if($mode == 'metadata'){
            list($state, $match) = $data;
            switch ($state) {
              case DOKU_LEXER_UNMATCHED :
                if ($renderer->capture) $renderer->cdata($match);
                break;
            }
            return true;
        }
        return false;
    }
 
    // validate color value $c
    // this is cut price validation - only to ensure there is nothing harmful
    // recognize rgb, rgba, hsl, hsla but don't try to valiedate their arguments,
    // just ensure that no illegal characters are included therein
    // and that the number of characters is reasonable
    // leave it to the browsers to ignore a faulty colour specification
    function _isValid($c) {
        $c = trim($c);
 
        $pattern = "/^\s*(
            ([a-zA-Z]+)|                         #colorname - not verified
            (\#([0-9a-fA-F]{3,8}))|              #colorvalue including possible alpha
            ((rgba?|hsla?)\([0-9%., ]{5,40}\))   #rgb[a], hsl[a]
            )\s*$/x";
 
        if (preg_match($pattern, $c)) return trim($c);
 
        return "";
    }
}
?>
