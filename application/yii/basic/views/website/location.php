<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Location';
$this->params['breadcrumbs'][] = $this->title;
?>

 

     <div class="body-content">
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/location.jpg" style="width: 1000px;height: 400px;"> 
  </div>

 
</div>
<br>

<script>

var slideIndex = 0;
showSlides();

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex> slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 2000); // Change image every 2 seconds
}
  

</script>

 <div class="main">
 <h1 style="text-align:center">LOCATION</h1>
    </div>
    <br>

<div>
<h2>PICO SANDS HOTEL – NASUGBU BATANGAS BEACH RESORT</h2>
<hr style="color:; background-color:blue; height:1px; border:none;">
<br>
<h4>Directions from Manila to this Nasugbu, Batangas beach resort:</h4>
<br>
<strong>Route Option 1: Cavitex - Ternate – Nasugbu (approximately 73 kilometers, 1.2 – 2 hours)</strong>

<div class = "bullet">
<br>
<ol>

  <li>From the Mall of Asia Complex, take Coastal Road and go straight to CAVITEX exit</li>
<br>  
  <li>From CAVITEX exit, go straight to Kawit going to Bacao Road and Tejero</li>
  <br>
  <li>Take the road from Petron gas station going to the town of Tanza pass by the town of Naic, until you reach Ternate.</li>
  <br>
  <li>Follow the main road leading to Puerto Azul, and then turn left to access the Kaybiang tunnel.</li>
  <br>
  <li>Enjoy the scenic view of Patungan Cove to your right until you reach the Hamilo Coast main gate.</li>
</ol>
</div>
<br>

<strong>Route Option 2: Manila-Tagaytay-Nasugbu (Travel Time 2.5 – 3 hours)</strong>

<div class = "bullet">
<br>
<ol>
  <li>Take SLEX (Southbound) headed toward Laguna.</li>
 <br>
  <li>Take the SANTA ROSA EXIT and turn right after the toll gate. Follow the Santa Rosa-Tagaytay road all the way to Tagaytay City.</li>
<br>
<ol>
  <li>Alternatively, you may choose to take the ETON EXIT (after SANTA ROSA EXIT).</li>
  <br>
  <li>After exiting the tollgate turn right and drive along Greenfield Parkway.</li>
  <br>
  <li>You will pass the road leading to Asia Brewery (drive straight) and the Eton City developments and will reach the junction with United Boulevard.</li>
  <br>
  <li>Turn left on United Boulevard and drive straight past the</li>
  

<ol>
<br>

  <li>Southern Luzon Hospital and Medical Center</li>
  <br>
  <li>Paseo de Santa Rosa</li>
</ol>
<br>
<li>Make a right at the corner of Paseo de Santa Rosa and the Santa Rosa Market</li>
<br>
<li>Go straight until you reach the Santa Rosa-Tagaytay Road. Make a left on this road, you will pass by a branch of King Bee Restaurant.</li>
<li>Continue along the Santa Rosa-Tagaytay Road until you reach Tagaytay City.</li>
</ol>
<br>
<li>Once you're along Aguinaldo Highway in Tagaytay City, you will pass:</li>

<ol>
<br>
<li>Josephine’s Restaurant</li>
<br>
<li>Taal Vista Hotel</li>
</ol>
<br>
<li>When you reach the Junction of Balayan (Caltex Station at the right), turn right again to go to Nasugbu. You will pass Central Azucarera de Don Pedro on your left side.</li>
<br>
<li>When you reach the Shell Gas Station (left side), turn right to go to the Nasugbu Town Proper.</li>
<br>
<li>Go straight until you reach the road that will take you uphill. You will pass by the “Barangay Wawa” arch and the following developments:</li>
<ul>
<br>
  <li>Canyon Cove</li>
  <br>
  <li>Kawayan Cove</li>
  <br>
  <li>Terazzas de Punta Fuego</li>
  <br>
  <li>Tali Beach Club</li>
  <br>
  <li>Peninsula de Punta Fuego</li>
</ul>
<br>
<li>Go further uphill until you reach Pico de Loro by following the yellow signages of “Hamilo Coast/ Pico de Loro Cove.”</li>
</ol> 

<br>
<strong>Google Map</strong>
<br>


<div id="map" style="width:100%;height:500px"></div>

<script>
function myMap() {
  var myCenter = new google.maps.LatLng(14.1923,120.6020);
  var mapCanvas = document.getElementById("map");
  var mapOptions = {center: myCenter, zoom: 15};
  var map = new google.maps.Map(mapCanvas, mapOptions);
  var marker = new google.maps.Marker({position:myCenter});
  marker.setMap(map);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8ID6qXBH1UmbqGcqGH6JnQSIu9NCi9fc&callback=myMap"></script>
</div>
<br>


</div>
