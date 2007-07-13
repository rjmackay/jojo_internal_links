<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2007 Harvey Kane <code@ragepank.com>
 * Copyright 2007 Michael Holt <code@gardyneholt.co.nz>
 * Copyright 2007 Melanie Schulz <mel@gardyneholt.co.nz>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Harvey Kane <code@ragepank.com>
 * @author  Michael Cochrane <code@gardyneholt.co.nz>
 * @author  Melanie Schulz <mel@gardyneholt.co.nz>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

class hktree
{
    var $name;                    //Name us ised to uniquely identify this tree within the site. Will set cookie names etc

    var $nodes = array();        //All nodes listed here out of order, with full data
    var $urls = array();        //Array of URLs for links
    var $statuses = array();        //Array of node statuses - '' is normal, or expired, protected
    var $targets = array();        //Array of Targets for links
    var $classname = array();        //Array of additional classes to add to the item
    var $onclicks = array();        //Array of OnClick Events
    var $children = array();    //The children for each node listed here
    var $bulletlist;
    var $parentnode = array();
    var $liststyletype = ''; //Deprecated
    var $liststyle = 'circle'; //The type of list style to use on plain lists
    var $selected = '';             //Selected item in select lists

    var $plus = '<b>+</b>'; //image or string to use for closed elements
    var $minus = '<b>-</b>'; //image or string to use for opened elements
    var $nokids = ''; //image or string to use for elements with no kids
    var $autoclose = true; //When a node is opened, it automatically closes other open nodes to keep the tree compact
    var $treeformat = 'windows'; // "windows" means a standard looking treemenu. "custom" means apply your own styles.
    var $showicons = true;
    var $theme = 'light'; //light or dark - changes the graphics to suit the background

    var $indent0; //String to use for each indent level (desireable if you style out the bullets)
    var $indent1;
    var $indent2;
    var $indent3;
    var $indent4;
    var $indent5;

    //internal variables - don't use these
    var $path = array(); //path of parent IDs to current position
    var $pathcopy = array(); //used for temporary operations
    var $depth;
    var $showdepth; //You may want to hide items below a certain depth - default = show all items

function hktree($name = '') //constructor
{
    $this->name = $name;
    $depth = 0;
}

function addnode($id=0,$parent=0,$name = '',$url = '', $target = '', $onclick = '',$classname = '', $rollover = '', $html = '', $status = '')
{
    $parent = str_replace("'", '',$parent);
    $parent = str_replace('"', '',$parent);
    $id = str_replace("'", '',$id);
    $id = str_replace('"', '',$id);
    $this->nodes[$id] = $name;
    $this->htmls[$id] = $html;
    $this->statuses[$id] = $status;
    $this->urls[$id] = $url;
    $this->targets[$id] = $target;
    $this->classname[$id] = $classname;
    $this->rollovers[$id] = $rollover;
    $this->onclicks[$id] = $onclick;
    $this->children[$parent][] = $id;
    $this->parentnode[$id]['parent'] = $parent;
    if ( ($onclick != '') && ($url == '') ) {$url = '#';} //If onclick event is used, we must have at least # for the URL
}


function displaynode_plain($start=0)
{

    if ( ($start!='0') && ($start!='') ) {
        $this->bulletlist .= "<li>";
        $class = $this->classname[$start] == '' ? '' : ' class="' . $this->classname[$start].'"';
        $url = $this->urls[$start];
        if ($this->onclicks[$start] != '') {$onclick = ' onclick="' . $this->onclicks[$start].'"';} else {$onclick = "";}
        if ($url != '') {$this->bulletlist .= "<a href=\"$url\"" . $onclick.$class . ">";} //start link
        $this->bulletlist .= $this->nodes[$start];
        if ($url != '') {$this->bulletlist .= "</a>";} //finish link
    }
    if (isset($this->children[$start]) && is_array($this->children[$start])) {
        $this->depth = $this->depth + 1;
        $this->bulletlist .= "<ul" .  JOJO::onlyif($this->liststyle,' style="list-style-type: ' . $this->liststyle . ';"') . ">\n";
        for ($i=0;$i<count($this->children[$start]);$i++) {
            $this->displaynode_plain($this->children[$start][$i]);
        }
        $this->bulletlist .= "</ul>\n";
        $this->depth = $this->depth - 1;
    }
    if ( ($start!='0') && ($start!='') ) {
        $this->bulletlist .= "</li>\n";
    }
}

function displaynode_h3list($start=0,$h=3)
{
    if ( ($start!='0') && ($start!='') ) {
        $this->bulletlist .= ($this->depth == 1) ? "<h$h>" : "<li>";
        $class = $this->classname[$start] == '' ? '' : ' class="' . $this->classname[$start].'"';
        $url = $this->urls[$start];
        if ($this->onclicks[$start] != '') {$onclick = ' onclick="' . $this->onclicks[$start].'"';} else {$onclick = "";}
        if ($url != '') {$this->bulletlist .= "<a href=\"$url\"" . $onclick.$class . ">";} //start link
        $this->bulletlist .= $this->htmls[$start] ? $this->htmls[$start] : $this->nodes[$start];
        if ($url != '') {$this->bulletlist .= "</a>";} //finish link
        $this->bulletlist .= ($this->depth == 1) ? "</h$h>" : "";
    }
    if (isset($this->children[$start]) && is_array($this->children[$start])) {
        $this->depth = $this->depth + 1;
        if ($this->depth > 1) $this->bulletlist .= "<ul" .  JOJO::onlyif($this->liststyle,' style="list-style-type: ' . $this->liststyle . ';"') . ">\n";
        for ($i=0;$i<count($this->children[$start]);$i++) {
            $this->displaynode_h3list($this->children[$start][$i],$h);
        }
        if ($this->depth > 1) $this->bulletlist .= "</ul>\n";
        $this->depth = $this->depth - 1;
    }
    if ( ($start!='0') && ($start!='') ) {
        //$this->bulletlist .= "</li>\n";
        $this->bulletlist .= ($this->depth == 1) ? "" : "</li>";
    }
}

function displaynode_dtree($start=0)
{
  $json = new Services_JSON();
  if ( ($start!='0') && ($start!='') ) {
    $this->bulletlist .= "tree" . $this->name . " . add(";
    $this->bulletlist .= "'$start'";
    $this->bulletlist .= ", '" . $this->parentnode[$start]['parent']."'";
    $this->bulletlist .= ", " . $json->encode($this->nodes[$start]);
    $this->bulletlist .= ", '" . $this->urls[$start]."'";
    $this->bulletlist .= ", " . $json->encode($this->rollovers[$start]);
    $this->bulletlist .= ", ''"; //target
    if ($this->statuses[$start] == 'expired') {
        $this->bulletlist .= ", 'images/cms/tree/page-disabled.gif'"; //icon
        $this->bulletlist .= ", 'images/cms/tree/page-disabled.gif'"; //iconopen
    } elseif ($this->statuses[$start] == 'folder') {
        $this->bulletlist .= ", 'images/cms/tree/folder.gif'"; //icon
        $this->bulletlist .= ", 'images/cms/tree/folderopen.gif'"; //iconopen
    } else {
        $this->bulletlist .= ", 'images/cms/tree/page.gif'"; //icon
        $this->bulletlist .= ", 'images/cms/tree/page.gif'"; //iconopen
    }
    $this->bulletlist .= ", ''"; //open
    $this->bulletlist .= ", \"" . $this->onclicks[$start].'"';
    $this->bulletlist .= ");\n";
  }
  if (isset($this->children[$start]) && is_array($this->children[$start])) {
    $this->depth = $this->depth + 1;
    for ($i=0;$i<count($this->children[$start]);$i++) {
      $this->displaynode_dtree($this->children[$start][$i]);
    }
    $this->depth = $this->depth - 1;
  }
}


function displaynode_select($start=0)
{
    $indent = '&nbsp;&nbsp;&nbsp;';

    $class = array();
    if (isset($this->statuses[$start]) && ($this->statuses[$start] == 'expired')) {
      $class[] = 'expired';
    }

    //if ( ($start!='0') && ($start!='') ) { //Commenting this allows an empty item at the top
        $this->bulletlist .= "<option value=\"" . htmlentities($start) . "\"";
        if ($this->selected == $start) {$this->bulletlist .= " selected=\"selected\"";}
        if (count($class)) {
            $this->bulletlist .= 'class="'.implode(' ',$class).'"';
        }
        $this->bulletlist .= ">";
        $url = isset($this->urls[$start]) ? $this->urls[$start] : '';

        for ($i=0;$i<($this->depth-1);$i++) {
            $this->bulletlist .= $indent; //indent as many times as required
        }
        $this->bulletlist .= isset($this->nodes[$start]) ? $this->nodes[$start] : '';
        $this->bulletlist .= "</option>\n";
    //}
    if (isset($this->children[$start]) && is_array($this->children[$start])) {
        $this->depth = $this->depth + 1;

        for ($i=0;$i<count($this->children[$start]);$i++) {
            $this->displaynode_select($this->children[$start][$i]);
        }

        $this->depth = $this->depth - 1;
    }

}



function displaynode_moo($start=0)
{

    if ( ($start!='0') && ($start!='') ) {

        $li_class = array();
        $a_class = array();

        if (dirname($_SERVER['PHP_SELF']) . '/' . $this->urls[$start] == $_SERVER['REQUEST_URI']) {
            $li_class[] = "selected";
            $a_class[] = "selected";
        } //the selected page should be highlighted one way or another

        $this->bulletlist .= "<li class=\"" . implode(' ',$a_class) . "\">";
        $url1 = $this->urls[$start];
        $url = $url1."#heading" . $this->parentnode[$start]['parent'];
        if ($this->onclicks[$start] != '') {$onclick = ' onclick="' . $this->onclicks[$start].'"';} else {$onclick = "";}


        if($this->children[$start]){ // checking whether this is a parent element or not
            if ($url != '') {
                $this->bulletlist .= "<span class=\"display heading" . $start . "\" style=\"cursor: pointer;\">" . $this->plus;
                $this->bulletlist .= "<a class=\"" . implode(' ',$a_class) . "\"$onclick>";
            } //start link
        }else{
            if ($url != '') {$this->bulletlist .= "<a class=\"" . implode(' ',$a_class) . "\" href=\"$url\"$onclick>";} //start link
        }
        $this->bulletlist .= $this->nodes[$start];
        if ($url != '') {$this->bulletlist .= "</a>";}
        if($this->children[$start]){ // checking whether this is a parent element or not
            if ($url != '') {$this->bulletlist .= "</span>";} //finish link
        }
    }
    if (is_array($this->children[$start])) {
        $this->depth = $this->depth + 1;


        if($this->depth == 2){
            $this->bulletlist .= "<ul class=\"stretcher\">\n";
        }else{
            $this->bulletlist .= "<ul>\n";
        }
        for ($i=0;$i<count($this->children[$start]);$i++) {
            $this->displaynode_moo($this->children[$start][$i]);
        }
        $this->bulletlist .= "</ul>\n";
        $this->depth = $this->depth - 1;

    }
    if ( ($start!='0') && ($start!='') ) {
        $this->bulletlist .= "</li>\n";
    }
}


function shownodes() //debug function
{
    foreach ($this->nodes as $id => $name) {
        $ret .= "$id = $name\n<br />";
    }
    return $ret;
}

function printout($showdepth=10)
{
    $this->showdepth = $showdepth;
    $this->bulletlist = '';
    $this->displaynode_treemenu();
    $this->bulletlist .= "<script type=\"text/javascript\" language=\"javascript\">loadtree('" . $this->name . "');</script>";
    return $this->bulletlist;
}


function printout_dtreejs()
{
  require_once(_BASEDIR . '/external/json/JSON.php');
  $this->bulletlist .= "tree" . $this->name . " = new dTree('tree" . $this->name . "');\n";
  $this->bulletlist .= "tree" . $this->name . " . add(0,-1,'" . strtoupper($this->name) . "');\n";
  $this->displaynode_dtree();
  //$this->bulletlist .= "document.write(tree" . $this->name . ");
  $this->bulletlist .= "document.getElementById('dtreecontent').innerHTML = tree" . $this->name . ";\n";
  return $this->bulletlist;
}

function printout_dtree($showdepth=10)
{
    require_once(_BASEDIR . '/external/json/JSON.php');

    $this->showdepth = $showdepth;
    $this->bulletlist = "
    <div class=\"dtree\">
<p><a href=\"javascript: tree" . $this->name . " . openAll();\">open all</a> | <a href=\"javascript: tree" . $this->name . " . closeAll();\">close all</a></p>
<div id=\"dtreecontent\"></div>
<script type=\"text/javascript\">
<!--\n";
$this->printout_dtreejs();
$this->bulletlist .= "\n//-->
</script></div>";
    return $this->bulletlist;
}

function printout_plain($showdepth=10)
{
    $this->showdepth = $showdepth;
    $this->bulletlist = '';
    $this->displaynode_plain();
    return $this->bulletlist;
}

/* Returns an indented select list */
function printout_select($showdepth=10,$selected = '')
{
    $this->selected = $selected;
    $this->showdepth = $showdepth;
    $this->bulletlist = '';
    $this->displaynode_select();
    return $this->bulletlist;
}

function printout_moo($showdepth=10)
{
    $this->showdepth = $showdepth;
    $this->bulletlist = '';
    $this->displaynode_moo();
    return $this->bulletlist;
}


function printout_tree($showdepth=10)
{
    $this->showdepth = $showdepth;
    $this->bulletlist = '';
    $this->displaynode_treemenu();
    return $this->bulletlist;
}

/* Uses H3 elements for top level, then unordered lists for sub-items */
function printout_h3list($showdepth=10)
{
    $this->showdepth = $showdepth;
    $this->bulletlist = '';
    $this->displaynode_h3list();
    return $this->bulletlist;
}

/* Uses H3 elements for top level, then unordered lists for sub-items */
function printout_h2list($showdepth=10)
{
    $this->showdepth = $showdepth;
    $this->bulletlist = '';
    $this->displaynode_h3list(0,2);
    return $this->bulletlist;
}

function moodiv($start = 0, $depth = 0)
{
      if ($depth > 2 || !isset($this->children[$start])) {
        return false;
    }

    $menuItems = array();
    foreach($this->children[$start] as $k => $v) {
          $menuItems[$k] = array();
        $menuItems[$k]['name'] = $this->nodes[$v];
        $menuItems[$k]['url'] = $this->urls[$v];
        $menuItems[$k]['children'] = $this->moodiv($v, $depth + 1);
    }
    return $menuItems;
}

function debug()
{
    print_r($this->nodes);
    echo "<br>";
    print_r($this->children);
    echo "<br>";
}

    function asArray($start = 0, $depth = 0, $maxdepth = 2)
    {
        $res = array();

        /* At our recursion depth or no children */
        if ($depth > $maxdepth || !isset($this->children[$start])) {
            return $res;
        }

        /* Add children */
        foreach($this->children[$start] as $k => $v) {
            $res[$k] = array(
                        'name' => $this->nodes[$v],
                        'url' => $this->urls[$v],
                        'children' => $this->asArray($v, $depth + 1, $maxdepth),
                        );
        }

        /* Return result */
        return $res;
    }

} //end class
