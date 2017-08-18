<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'ROOMS';
$this->params['breadcrumbs'][] = $this->title;
?>
     <div class="body-content">
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/cornerdeluxe.jpg" style="width:1000px;height:320px;"> 
   
  </div>

  <div class="mySlides">
    <img src="uploads/deluxe.jpg" style="width:1000px;height:320px;"> 
   
  </div>

  <div class="mySlides">
    <img src="uploads/lsuperior.jpg" style="width:1000px;height:320px;"> 
  
   </div>

    <div class="mySlides">
    <img src="uploads/penthouse.jpg" style="width:1000px;height:320px;"> 
  
  </div>

    <div class="mySlides">
    <img src="uploads/premier.jpg" style="width:1000px;height:320px;"> 
  
  </div>
</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
  <span class="dot" onclick="currentSlide(4)"></span> 
  <span class="dot" onclick="currentSlide(5)"></span> 
  

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


<h1>ROOMS</h1>
<hr class = "hrColor">
<h2>LAGOON VIEW</h2>
<hr class = "hrColor">
<p>Feast your eyes on the breathtaking view of the man-made lagoon from your veranda.</p>
</div>

