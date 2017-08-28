<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Team Building Activities';
$this->params['breadcrumbs'][] = $this->title;
?>

     <div class="body-content">
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/teambuild.jpg" style="width:100%;height:20%;"> 
  </div>

  <div class="mySlides">
    <img src="uploads/teambuild1.jpg" style="width:100%;height:20%;"> 
  </div>

  <div class="mySlides">
    <img src="uploads/teambuild2.jpg" style="width:100%;height:20%;"> 
  </div> 

  <div class="mySlides">
    <img src="uploads/teambuild3.jpg" style="width:100%;height:20%;"> 
  </div> 
</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
  <span class="dot" onclick="currentSlide(4)"></span>
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
<h1>CORPORATE MEETINGS</h1>
<hr class = "hrColor">
<h2>TEAM BUILDING ACTIVITIES</h2>
<hr class = "hrColor">
<div class = "bullet">
<p>The 1.5 km Beach at Pico de Loro Cove is perfect for your organizational development needs. Experience our interactive learning activities and increase team skills and communications towards your colleagues.</p>
</div>
 <img src="uploads/application-pdf.png" style="width:1.3%;height:1.3%;"><a href ="uploads/Pico Team building.pdf">Pico Team Building</a>
 <div>
 <br>
 <a class="btn btn-lg btn-success" href="mailto:sales@smhotelsandconventions.com">Request for proposal</a>
 </div>
</div>
