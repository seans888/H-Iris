<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'ROOMS';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 style="text-align:center">ROOMS</h1>
     <div class="body-content">
        <div class="slideshow-container">

 
  
  </div>
    <div class="mySlides">
    <img src="uploads/mpremier.jpg" style="width:1100px;height:320px;"> 
  
  </div>
    <div class="mySlides">
    <img src="uploads/msuperior.jpg" style="width:1100px;height:320px;"> 
  
  </div>
</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
 

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



<h2>Mountain View</h2>

<p>Bask in the verdant backdrop of green hills and the stunning Mt. Pico de Loro.</p>
</div>

