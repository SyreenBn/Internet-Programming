
<?php
session_start();
if (!isset($_SESSION['user_account']) || !isset($_SESSION['password'])){
   header("location:login.php");
 }
?>

<!DOCTYPE html>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Daily Calendar</title>
  <link rel="stylesheet" type="text/css" href="style.css">

    <script type="text/javascript">

    function send_with_ajax(pic,id,h,w){
    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
          try {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
          } catch(exception) {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
          }
        } else {
          xhr = new XMLHttpRequest();
        }
    } else {
        alert("Your browser does not support XMLHTTP Request...!");
    }

        xhr.open("GET", pic, true);	// Make sure file is in same server
        xhr.overrideMimeType('text/plain; charset=x-user-defined');
    xhr.send(null);

        xhr.onreadystatechange = function() {
        if (xhr.readyState == 4){
            if ((xhr.status == 200) || (xhr.status == 0)){
                var image = document.getElementById(id);
                image.src = "data:image/gif;base64," + encode64(xhr.responseText);
                image.width = w;
                image.height = h;
            }else{
                alert("Something misconfiguration : " +
                  "\nError Code : " + xhr.status +
                  "\nError Message : " + xhr.responseText);
            }
        }
    };
    }

    function encode64(inputStr){
       var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
       var outputStr = "";
       var i = 0;

       while (i<inputStr.length){
          var byte1 = inputStr.charCodeAt(i++) & 0xff;
          var byte2 = inputStr.charCodeAt(i++) & 0xff;
          var byte3 = inputStr.charCodeAt(i++) & 0xff;

          var enc1 = byte1 >> 2;
          var enc2 = ((byte1 & 3) << 4) | (byte2 >> 4);

          var enc3, enc4;
          if (isNaN(byte2)){
      enc3 = enc4 = 64;
          } else{
            enc3 = ((byte2 & 15) << 2) | (byte3 >> 6);
            if (isNaN(byte3)){
               enc4 = 64;
            } else {
                enc4 = byte3 & 63;
            }
          }
          outputStr +=  b64.charAt(enc1) + b64.charAt(enc2) + b64.charAt(enc3) + b64.charAt(enc4);
       }
       return outputStr;
    }

	  var map;
	  var service;
    var infowindow;
    var keller;
    var map_;
    var searchrequest ;

  function destroy(){

    window.alert("destroying");
  //  if (isset($_SESSION['user_account']) && ($_SESSION['user_account']>0) ){
  //      unset($_SESSION['user_account']);
  //      session_destroy();

    // }
    <?php
    echo 1;
  // //  session_destroy();
  //     header("location:logout.php");
  //     exit();
      ?>
  }


function myMap() {
  //console.log("myMap")

	var myCenter = new google.maps.LatLng(44.9740,-93.2277);
  keller = new google.maps.LatLng(44.9740,-93.2277);
	var mapCanvas = document.getElementById("googleMap");
	var mapOptions = {center: myCenter, zoom: 16};

	map_ = new google.maps.Map(mapCanvas, mapOptions);

  infowindow = new google.maps.InfoWindow();
  service = new google.maps.places.PlacesService(map_);
  //console.log("test");

  var locations = document.getElementsByClassName('loc');
  for(var i = 0; i < locations.length; i++) {
    console.log("ocations[i].innerHTML: ", locations[i].innerHTML);
          mark(locations[i].innerHTML,1000);
  }
  searchrequest = {
    location: keller,
    radius: document.getElementById("raduis").value,
    type: ['restaurant']
  };
  service.nearbySearch(searchrequest, callback);


}

function mark(loc,r){
		var request = {
            location: keller,
            radius: r,
            query:loc
        };
		service.textSearch(request, callback);
	  }
function callback(results, status) {
      console.log("callback");
    	if (status === google.maps.places.PlacesServiceStatus.OK) {
        console.log("found");
    		for (var i = 0; i < results.length ; i++) {
    			createMarker(results[i]);
    		}
    	} else {
        console.log("not found");
      }
    }


function createMarker(place) {
  var marker = new google.maps.Marker({
          map: map_,
          position: place.geometry.location,
          title: place.name
        });

        var infowindow = new google.maps.InfoWindow({
            content: ""
        });

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map,marker);
        });
      }
    </script>
  </head>
  <body>


  <div id="calendar">
    <?php
      echo ' <h1>My Calendar</h1> ';
       echo '<p>';
       echo "WELCOME  ".$_SESSION['user_account'] ;
       echo '<br>';
       ?>

       <form name="logout" method="post" action="logout.php">
         <label>
           <input name="logout" type="submit" id="logout" value="log out">
         </label>
       </form>
    <?php   echo '</p>';
       echo '<nav id="navmenu">';
       echo '<ul>';
       echo '<li><a href="MyCalendar.php">Calendar</a></li>';
       echo '<li><a href="MyForm.php">Input</a></li>';
       echo '<li><a href="admin.php">Admin</a></li>';
       echo '</ul>';
       echo '</nav>';
	  if (!filesize('calendar.txt') == 0){
        echo '<table>';
	      $filename = "calendar.txt";
        $myfile = fopen('calendar.txt',"r");
        $events = file_get_contents ('calendar.txt');
//	echo $events;
        $event = json_decode($events, true);
        fclose($myfile);
        $days = array("Mon","Tue","Wed","Thur","Fri"); // add s to day
        for ($i = 0; $i<= 4;$i++){ // add $
        $day = $days[$i];
        if (isset($event[$day])){
//	echo $event[$day];
        echo '<tr> <td>';
        echo $day;
        echo '</td>';
      foreach($event[$day] as $dayevent){
        $str1 = "'".$dayevent['BuildingPic'].".gif'";
        $str2 = "''";
        $h1 = "100";
        $w1 = "200";
        $h2 = "0";
        $w2 = "0";
          echo '<td onmouseover="send_with_ajax('.$str1.','.$str1.','.$h1.','.$w1.')"  onmouseout="send_with_ajax('.$str2.','.$str1.','.$h2.','.$w2.')" > <p>';
          echo $dayevent['eventname']; // add eventname
          echo '</p> <p>';
          echo $dayevent['starttime'];
          echo '-';
          echo $dayevent['endtime'];
          echo '</p>';
          echo '<span class = "loc">';
          echo $dayevent['location'];
          echo '</span> ';
          echo '<br>';
          echo '<img id= '.$str1.' width="0" height="0"/>';
          echo '</td>';
         }
        echo '</tr>';
      }
    }echo '</table>';
    } else {
          echo '<div> calender does not any events </div>';
          }
         ?>
  </div>
  <form id="loc_form" onSubmit="event.preventDefault(); return mark('')">
    <input id = "raduis" name = "raduis" value = "0" type = "text" size = "25" maxlength = "30" required/>
    <input type = "submit" value = "Search" onclick="myMap()">

  </form>
  <div id="googleMap" style="width:950PX;height:400px;"></div>

  <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDpvEv_3o9rphti4VLQiiQ0e1ENITnEvCk&callback=myMap"></script>

</body>
</html>
