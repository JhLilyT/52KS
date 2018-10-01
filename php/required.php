<?php 
	session_start();
	session_name("../html/z.html");
	header("Cache-control: private");
	
	$q = mysql_query("SELECT uid, privilege_level FROM users WHERE pw = 'escaped_and_preferrably_hashed_password' AND username = 'escaped_username' LIMIT 0,1");
	
	if($q && mysql_query_num_rows($q)>0){
		$array = mysql_fetch_assoc($q);
		$SESSION['privilege_level'] = $array['privilege_level'];
		
	}
?>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Distance Matrix service</title>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    
	<script src="dist/js/bootstrap.js"></script>
	<script src="dist/js/bootstrap-select.js"></script>
	
	
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap-select.css">
	

    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

      #map-canvas {
        height: 100%;
        width: 50%;
      }
      #content-pane {
        float:right;
        width:48%;
        padding-left: 2%;
      }
      #outputDiv {
        font-size: 11px;
      }
    </style>
    <script>
var map;
var geocoder;
var bounds = new google.maps.LatLngBounds();
var markersArray = [];



//var origins = [];
//var destinations = [];
var step1 = new google.maps.LatLng(22.639792, 120.302228); //高雄火車站
var step2 = new google.maps.LatLng(22.660780, 120.350794); //澄清湖
var step3 = new google.maps.LatLng(22.614177,120.265939); //旗津
var step4 = new google.maps.LatLng(22.618385,120.317382); //瑞豐夜市
var step5 = new google.maps.LatLng(22.756824,120.315160); //橋頭糖廠
var step6 = new google.maps.LatLng(22.656969,120.286490); //高雄美術館
var step7 = new google.maps.LatLng(22.639455,120.323249); //科工館
var step8 = new google.maps.LatLng(22.646686,120.283575); //中都愛河濕地
var step9 = new google.maps.LatLng(22.623701,120.303047); //新崛江
var step10 = new google.maps.LatLng(22.595214,120.304908); //夢時代
var step11 = new google.maps.LatLng(22.613835,120.304676); //三多商圈
var step12 = new google.maps.LatLng(22.624969,120.363489); //大東文化藝術中心
var step13 = new google.maps.LatLng(22.612751,120.263965); //旗後砲臺
var step14 = new google.maps.LatLng(22.578625,120.344652); //淨園休閒農場
var step15 = new google.maps.LatLng(22.626073,120.317931); //文化中心
var step16 = new google.maps.LatLng(22.624861,120.289129); //愛河
var step17 = new google.maps.LatLng(22.758820,120.439298); //佛陀紀念中心
var step18 = new google.maps.LatLng(22.620005,120.281585); //駁二特區
var step19 = new google.maps.LatLng(22.633428,120.302368); //六合夜市
var step20 = new google.maps.LatLng(22.730055,120.407070); //義大遊樂中心
var h=0;

var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';
var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';


var steparray = [step8, step9, step10, step11, step12];
var stepname = ["中都愛河濕地","新崛江","夢時代","三多商圈","大東文化藝術中心"]
var x =[];
var y=[];
var b = [];
var d =[];

var i=0;
var j=1;
var k=2;


function initialize() {
  var opts = {
    center: new google.maps.LatLng(22.639792, 120.302228),
    zoom: 14
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), opts);
  geocoder = new google.maps.Geocoder();
  setMarkers(map, points);
  
}
var points = [
            	['高雄火車站',22.639792, 120.302228,1],
            	['澄清湖',22.660780, 120.350794,2],
            	['旗津',22.614177, 120.265939,3],
            	['瑞豐夜市',22.618385, 120.317382,4],
            	['橋頭糖廠',22.756824,120.315160,5],
            	['高雄美術館',22.656969,120.286490,6],
            	['科工館',22.639455,120.323249,7],
            	['中都愛河濕地',22.646686,120.283575,8],
            	['新崛江',22.623701,120.303047,9],
            	['夢時代',22.595214,120.304908,10],
            	['三多商圈',22.613835,120.304676,11],
            	['大東文化藝術中心',22.624969,120.363489,12],
            	['旗後砲台',22.612751,120.263965,13],
            	['淨園休閒農場',22.578625,120.344652,14],
            	['文化中心', 22.626073,120.317931,15],
            	['愛河',22.624861,120.289129,16],
            	['佛陀紀念中心',22.758820,120.439298,17],
            	['駁二特區',22.620005,120.281585,18],
            	['六合夜市',22.633428,120.302368,19],
            	['義大遊樂中心',22.730055,120.407070,20],
             ];

function setMarkers(map, locations){
  	var image = {
  			url:' http://www.google.com/mapfiles/marker.png',
  			size: new google.maps.Size(20,32),
  			origin: new google.maps.Point(0,0),
  			anchor: new google.maps.Point(0,32)
  	};
  	
  	for (var i=0; i<locations.length; i++){
  		var points = locations[i];
  		var myLatLng = new google.maps.LatLng(points[1], points[2]);
  		var marker = new google.maps.Marker({
  			position: myLatLng,
  			map:map,
  			icon:image,
  			title:points[0],
  			zIndex:points[3],
  			draggable:false,
  	    	animation: google.maps.Animation.DROP
  		});
 	}

  }

function mergeSort(arr)
{
    if (arr.length < 2)
        return arr;
 
    var middle = parseInt(arr.length / 2);
    var left   = arr.slice(0, middle);
    var right  = arr.slice(middle, arr.length);
 
    return merge(mergeSort(left), mergeSort(right));
}

 
function merge(left, right)
{
    var result = [];
 
    while (left.length && right.length) {
        if (left[0] <= right[0]) {
            result.push(left.shift());
        } else {
            result.push(right.shift());
        }
    }
 
    while (left.length)
        result.push(left.shift());
 
    while (right.length) 
        result.push(right.shift());
 
    return result;
}

var h=0;



function calculateDistances() {
	
  var service = new google.maps.DistanceMatrixService();
  
  for (i=0; i<j; i++)
  { 
    for (j=0; j<k; j++)
    {
    for (k=0; k < steparray.length; k++)
    {
    if(i>=j || j>=k || i>=k)
    {
    {continue;}
    }
    
    else{
    x.push(step1,steparray[i],steparray[j],steparray[k]);
    y.push(step1,stepname[i],stepname[j],stepname[k]);

    
    }
    }
    }
    }  
    
  alert(y[0]);
  
var h=0;
  
  service.getDistanceMatrix(
    {
      
      origins: [x[4*h],x[4*h+1],x[4*h+2],x[4*h+3]],
      destinations: [x[4*h],x[4*h+1],x[4*h+2],x[4*h+3]],
      travelMode: google.maps.TravelMode.DRIVING,
      unitSystem: google.maps.UnitSystem.METRIC,
      avoidHighways: false,
      avoidTolls: false,
    }, callback);
  
  
  function callback(response, status) {
	  if (status != google.maps.DistanceMatrixStatus.OK) {
	    alert('Error was: ' + status);
	  } else {
	    var origins = y;
	    var destinations = y;
	   
	    var outputDiv = document.getElementById('outputDiv');
	    outputDiv.innerHTML = '';
	  
        //for(i=0; i < origins.length; i++;)
        //for(j=0; j < destinations.length; j++)
        //parseFloat(results[0].distance.text);
        	
        // response results
	    var results = response.rows[0].elements;
        var results2 = response.rows[1].elements;
        var results3 = response.rows[2].elements;
        var results4 = response.rows[3].elements;
        
        //distance
        
	    var step1tostep2km = parseFloat(results[1].distance.text);
	    var step1tostep3km = parseFloat(results[2].distance.text);
	    var step1tostep4km = parseFloat(results[3].distance.text);
	    var step2tostep1km = parseFloat(results2[0].distance.text);
	    var step2tostep3km = parseFloat(results2[2].distance.text);
	    var step2tostep4km = parseFloat(results2[3].distance.text);
	    var step3tostep1km = parseFloat(results3[0].distance.text);
	    var step3tostep2km = parseFloat(results3[1].distance.text);
	    var step3tostep4km = parseFloat(results3[3].distance.text);
	    var step4tostep1km = parseFloat(results4[0].distance.text);
	    var step4tostep2km = parseFloat(results4[1].distance.text);
	    var step4tostep3km = parseFloat(results4[2].distance.text);
	    
	    
	    //duration
	    
	    var step1tostep2sec = parseInt((results[1].duration.value)/60);
	    var step1tostep3sec = parseInt((results[2].duration.value)/60);
	    var step1tostep4sec = parseInt((results[3].duration.value)/60);
	    var step2tostep1sec = parseInt((results2[0].duration.value)/60);
	    var step2tostep3sec = parseInt((results2[2].duration.value)/60);
	    var step2tostep4sec = parseInt((results2[3].duration.value)/60);
	    var step3tostep1sec = parseInt((results3[0].duration.value)/60);
	    var step3tostep2sec = parseInt((results3[1].duration.value)/60);
	    var step3tostep4sec = parseInt((results3[3].duration.value)/60);
	    var step4tostep1sec = parseInt((results4[0].duration.value)/60);
	    var step4tostep2sec = parseInt((results4[1].duration.value)/60);
	    var step4tostep3sec = parseInt((results4[2].duration.value)/60);
	    
	    function formatFloat(num, pos)
	    {
	      var size = Math.pow(10, pos);
	      return Math.round(num * size) / size;
	    }
      
        	//alldistance
        	var alldistance = step1tostep2km + step2tostep3km + step3tostep4km;
        	var alldistance2 = step1tostep2km + step2tostep4km + step4tostep3km;
        	var alldistance3 = step1tostep3km + step3tostep2km + step2tostep4km;
        	var alldistance4 = step1tostep3km + step3tostep4km + step4tostep2km;
        	var alldistance5 = step1tostep4km + step4tostep2km + step2tostep3km;
        	var alldistance6 = step1tostep4km + step4tostep3km + step3tostep2km;
        	
        	//allduration
        	var allduration = step1tostep2sec + step2tostep3sec + step3tostep4sec;
        	var allduration2 = step1tostep2sec + step2tostep4sec + step4tostep3sec;
        	var allduration3 = step1tostep3sec + step3tostep2sec + step2tostep4sec;
        	var allduration4 = step1tostep3sec + step3tostep4sec + step4tostep2sec;
        	var allduration5 = step1tostep4sec + step4tostep2sec + step2tostep3sec;
            var allduration6 = step1tostep4sec + step4tostep3sec + step3tostep2sec;
            
            
 
    
            var a = [allduration,allduration2,allduration3,allduration4,allduration5,allduration6];
            
         
            var dvalue = [{key: origins[0] + " to " + destinations[1], value: step1tostep2km}, 
                          {key: origins[1] + ' to ' + destinations[2], value: step2tostep3km},
                          {key: origins[2] + ' to ' + destinations[3], value: step3tostep4km},
                          {key: "總距離", value: formatFloat(alldistance, 2)}];
            		
            var dvalue2 = [{key: origins[0] + " to " + destinations[1], value: step1tostep2km}, 
                           {key: origins[1] + ' to ' + destinations[3], value: step2tostep3km},
                           {key: origins[3] + ' to ' + destinations[2], value: step3tostep4km},
                           {key: "總距離", value: formatFloat(alldistance, 2)}];
            
            var dvalue2 = [{key: origins[0] + " to " + destinations[1], value: step1tostep2km}, 
                           {key: origins[1] + ' to ' + destinations[2], value: step2tostep3km},
                           {key: origins[2] + ' to ' + destinations[3], value: step3tostep4km},
                           {key: "總距離", value: formatFloat(alldistance, 2)}];
            
            var dvalue2 = [{key: origins[0] + " to " + destinations[1], value: step1tostep2km}, 
                           {key: origins[1] + ' to ' + destinations[2], value: step2tostep3km},
                           {key: origins[2] + ' to ' + destinations[3], value: step3tostep4km},
                           {key: "總距離", value: formatFloat(alldistance, 2)}];
            
            var dvalue2 = [{key: origins[0] + " to " + destinations[1], value: step1tostep2km}, 
                           {key: origins[1] + ' to ' + destinations[2], value: step2tostep3km},
                           {key: origins[2] + ' to ' + destinations[3], value: step3tostep4km},
                           {key: "總距離", value: formatFloat(alldistance, 2)}];
            
            var dvalue2 = [{key: origins[0] + " to " + destinations[1], value: step1tostep2km}, 
                           {key: origins[1] + ' to ' + destinations[2], value: step2tostep3km},
                           {key: origins[2] + ' to ' + destinations[3], value: step3tostep4km},
                           {key: "總距離", value: formatFloat(alldistance, 2)}];
            
            
            
            alert(dvalue[0].value);
            	
	        console.log(mergeSort(a));
            b.push(mergeSort(a)[0]);
            console.log(mergeSort(b));
            

	        
	        
        	}
        
}
  
 
  function toggleBounce() {

	  if (marker.getAnimation() != null) {
	    marker.setAnimation(null);
	  } else {
	    marker.setAnimation(google.maps.Animation.BOUNCE);
	  }
	}
  google.maps.event.addListener(marker, 'click', toggleBounce);

}




google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
     

    <div id="content-pane">
      <div id="inputs">
      <br>
      <b>起點</b>
      <br>
      <select id="start" class="selectpicker" onchange="toggleBounce()">
      <option value="step1">高雄火車站</option>
      <option value="step2">澄清湖</option>
      <option value="step3">旗津</option>
      <option value="step4">瑞豐夜市</option>
      <option value="step5">橋頭糖廠</option>
      <option value="step6">高雄美術館</option>
      <option value="step7">科工館</option>
      <option value="step8">中都愛河濕地</option>
      <option value="step9">新崛江</option>
      <option value="step10">夢時代</option>
      <option value="step11">三多商圈</option>
      <option value="step12">大東文化藝術中心</option>
      <option value="step13">旗後砲臺</option>
      <option value="step14">淨園休閒農場</option>
      <option value="step15">文化中心</option>
      <option value="step16">愛河</option>
      <option value="step17">佛陀紀念中心</option>
      <option value="step18">駁二特區</option>
      <option value="step19">六合夜市</option>
      <option value="step20">義大遊樂中心</option>
    </select>
    <br>
   
    <br>
        <p><button type="button" id="calculate" onclick="calculateDistances();">Calculate</button></p>
      </div>
     <div id="outputDiv"></div>
    </div>
    <div id="map-canvas"></div>
    <script>
       //document.getElementById("calculate").onclick =  function (){
    	   //var f = document.getElementById("start").selectedIndex;
           //alert(document.getElementById("start").options[f].text);
    	   //calculateDistances(document.getElementById("start").options[f].text);
    	//};
    </script>
  </body>
</html>