<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Dining';
$this->params['breadcrumbs'][] = $this->title;
?>

      <div class="body-content">
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/Taalhotel.jpg" style="width:100%;height:20%;"> 

  </div>

  <div class="mySlides">
    <img src="uploads/Taalroom.jpg" style="width:100%;height:20%;"> 
  
  </div>

  <div class="mySlides">
    <img src="uploads/Dining.jpg" style="width:100%;height:20%;"> 

  </div>

  
</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>
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
  <h1><?= Html::encode($this->title) ?></h1>
<div class="col-md-8">
<div class="bullet">

<h2> PICO RESTAURANT AND BAR </h2>
<p style="text-align:justify"> Pico Restaurant specializes in Mediterranean cuisine and is located at the lobby of Pico Sands Hotel. 
It is open round the clock and offers a food pick-up service for guests. 

The Pico Bar, located across Pico Restaurant, serves a wide range of beverages, including this Nasugbu resort's signature fruit juices and Mojito blends. 
 </br>

<strong>Location:</strong> Ground Floor, Pico Sands Hotel 
 </br>
<strong>Operating Hours:</strong> 24 hours 
</p>
</br>

<p style="text-align:justify">

<strong>RENOVATION NOTICE: </strong>
 </br>
In our continuing effort to better serve our valued guests, we are upgrading the Pico Restaurantal fresco area.
 </br>
Upgrading work start at 11:00 am until 4:00 pm, daily. We assure you that we will take all measures to
 </br> minimize disturbance and maintain comfort and convenience. Please bear with us.

 </p>

</div>