<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Pre-Wedding Activity';
$this->params['breadcrumbs'][] = $this->title;
?>
     <div class="body-content">
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/pre-wedding.jpg" style="width:100%;height:20%;"> 
  </div>

  <div class="mySlides">
    <img src="uploads/pre-wedding1.jpg" style="width:100%;height:20%;"> 
  </div>

  <div class="mySlides">
    <img src="uploads/pre-wedding2.jpg" style="width:100%;height:20%;"> 
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
 
<div>
<h1> WEDDINGS</h1>
<hr>

 <h2>PRE-WEDDING ACTIVITIES</h2>
 <hr>
<h3>PRENUP PICTORIAL PACKAGE</h3>

<h5>INCLUSIONS:</h5>

<div class = "bullet">
<ul>
  <li>Pictorial at Pico de Loro</li>
  <li>Staff assistance for designated areas</li>
  <li>Guest fee for four (4) persons</li>
  <li>An additional guest fee of 1,300 for High Season</li>
   <p>and 1,200 for Peak and 800 for Lean season will
   <br>be charged in excess of four (4) persons.</p>
</ul> 
</div>
<br>
<a class="btn btn-lg btn-success" href="mailto:sales@smhotelsandconventions.com">Request for proposal</a>
</div>
