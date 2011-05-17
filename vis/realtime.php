
<html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<!----------------------------------------------------------------------------------------------------
  
   All Emoncms code is released under the GNU General Public License v3.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org

-------------------------------------------------------------------------------------->

 <?php
  error_reporting(E_ALL);
  ini_set('display_errors','On');

  $tableid = $_GET["tableid"];                 //Get the table ID so that we know what graph to draw
  $price = $_GET["price"];  
  if (!$price) $price = 0.14;

  $path = dirname("http://".$_SERVER['HTTP_HOST'].str_replace('vis', '', $_SERVER['SCRIPT_NAME']))."/";

 ?>

 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../flot/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../flot/jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="../flot/jquery.flot.selection.js"></script>
 </head>
 <body>

   <!---------------------------------------------------------------------------------------------------
   // Time window buttons
   ---------------------------------------------------------------------------------------------------->
   <button class="viewWindow" time="24">1 day</button>
   <button class="viewWindow" time="12">12 hour</button>
   <button class="viewWindow" time="1.0">1 hour</button>
   <button class="viewWindow" time="0.50">30 mins</button>
   <button class="viewWindow" time="0.25">15 mins</button>
   <button class="viewWindow" time="0.01">1 mins</button>

   <div id="placeholder" style="font-family: arial;"></div>			<!-- Graph placeholder -->

   <div class="inc" style="font-size: 10px;"></div>		<!-- Refresh counter placeholder -->
   <div id="stat" style="font-size: 20px; font-family: arial;  font-weight: normal; color: #333;">---</div>

   <script id="source" language="javascript" type="text/javascript">
   //--------------------------------------------------------------------------------------
   var table = "<?php echo $tableid; ?>";				//Fetch table name
   var price = "<?php echo $price; ?>";	
   var path = "<?php echo $path; ?>";	
   //----------------------------------------------------------------------------------------
   // These start time and end time set the initial graph view window 
   //----------------------------------------------------------------------------------------
   var timeWindow = (3600000*0.1);				//Initial time window
   var start = ((new Date()).getTime())-timeWindow;		//Get start time
   var end = (new Date()).getTime();				//Get end time

   var paverage;
   var npoints;

   $(function () {

     var placeholder = $("#placeholder");

     //----------------------------------------------------------------------------------------
     // Get window width and height from page size
     //----------------------------------------------------------------------------------------
     var width = $('body').width();
     var height = $('body').height()-100;
     if (height<=0) height = 400;

     placeholder.width(width);
     placeholder.height(height);
     //----------------------------------------------------------------------------------------

     var graph_data = [];                              //data array declaration

     setInterval ( doSome, 2500 );



      function doSome()
      {				//Initial time window
        start = ((new Date()).getTime())-timeWindow;		//Get start time
        end = (new Date()).getTime();				//Get end time

       var res = Math.round( ((end-start)/10000000) );			//Calculate resolution
       if (res<1) res = 1;

        getData( start, end, res);
      }



     //--------------------------------------------------------------------------------------
     // Plot flot graph
     //--------------------------------------------------------------------------------------
     
     function plotGraph(start, end)
     {
          $.plot(placeholder,[                    
          {
            data: graph_data ,				//data
            lines: { show: true, fill: true }		//style
          }], {
yaxis: { 
                  min: ((0)),
		  max: ((3000))
        },
        xaxis: { mode: "time", 
                  min: ((start+8000)),
		  max: ((end-8000)),
        },
        selection: { mode: "xy" }
     } ); 
     }

     //--------------------------------------------------------------------------------------
     // Fetch Data
     //--------------------------------------------------------------------------------------
     function getData( start, end, resolution)
     {
       $.ajax({                                       //Using JQuery and AJAX
         url: path+'api/getData.php',                         //data.php loads data to be graphed
         data: "&table="+table+"&start="+start+"&end="+end+"&resolution="+resolution,    //
         dataType: 'json',                            //and passes it through as a JSON    
         success: function(data) 
         {

           paverage = 0;
           npoints = 0;

           for (var z in data)                     //for all variables
           {
             paverage += parseFloat(data[z][1]);
             npoints++;
           }  
             var timeB  = Number(data[0][0])/1000.0;
             var timeA  = Number(data[data.length-1][0])/1000.0;

             var timeWindow = (timeB-timeA);
             var timeWidth = timeWindow / npoints;

           paverage = paverage / npoints;
           $("#stat").html("Average: "+(paverage).toFixed(2));


           graph_data = [];   
           graph_data = data;

           plotGraph(start, end);
         } 
       });
     }



     //----------------------------------------------------------------------------------------------
     // Operate buttons
     //----------------------------------------------------------------------------------------------
     $('.viewWindow').click(function () 
     {
       var time = $(this).attr("time");					//Get timewindow from button
       timeWindow = (3600000*time);			//Get start time

     });
     //-----------------------------------------------------------------------------------------------
  });
  //--------------------------------------------------------------------------------------
  </script>

  </body>
</html>  
