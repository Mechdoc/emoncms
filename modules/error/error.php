<?php
  /*
   All Emoncms code is released under the GNU General Public License v3.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */
  class error {

    //-------------------------------------------------------------------
    // 1) Direct according to path argument 1
    //-------------------------------------------------------------------
    function menu() {
        switch ($GLOBALS['args'][1]){
            case "e404":
                return $this->e404();
                break;
            case "denied":
                return $this->denied();
                break;
            default:

        }
    }

    //-------------------------------------------------------------------
    // This function actually creates the page...
    //-------------------------------------------------------------------    
    function e404()
    {
      $variables['title'] = "";
      
	  $out = "

<div><pre>
                                                     ___ _____    ___ 
                                                    /   |  _  |  /   |
  ___ _ __ ___   ___  _ __     ___ _ __ ___  ___   / /| | |/' | / /| |
 / _ \ '_ ` _ \ / _ \| '_ \   / __| '_ ` _ \/ __| / /_| |  /| |/ /_| |
|  __/ | | | | | (_) | | | | | (__| | | | | \__ \ \___  \ |_/ /\___  |
 \___|_| |_| |_|\___/|_| |_|  \___|_| |_| |_|___/     |_/\___/     |_/
";
if ($GLOBALS['args'][2]=='s') $out .= "<h3>No settings.php file</h3>";
$out.="</pre></div>";
	  


      // content will be rendered in the content area in the theme
      $variables['content'] = $out;
      return $variables;
    }

 //-------------------------------------------------------------------
    // This function actually creates the page...
    //-------------------------------------------------------------------    
    function denied()
    {
      $variables['title'] = "";
      
	  $out = "

<div><pre>
                                         
                                               
  ___ _ __ ___   ___  _ __     ___ _ __ ___  ___  
 / _ \ '_ ` _ \ / _ \| '_ \   / __| '_ ` _ \/ __| 
|  __/ | | | | | (_) | | | | | (__| | | | | \__ \ 
 \___|_| |_| |_|\___/|_| |_|  \___|_| |_| |_|___/  
";
$out .= "<h3>Hello! Please sign in or register</h3>";
$out.="</pre></div>";
	  


      // content will be rendered in the content area in the theme
      $variables['content'] = $out;
      return $variables;
    }

}

?>
