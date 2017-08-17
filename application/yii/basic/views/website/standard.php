<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'ROOMS';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 style="text-align:center">ROOMS</h1>

     <div class="body-content">
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/banner1.jpg" style="width:1000px;height:320px;"> 
   
  </div>

  <div class="mySlides">
    <img src="uploads/banner2.jpg" style="width:1000px;height:320px;"> 
   
  </div>

  <div class="mySlides">
    <img src="uploads/banner3.jpg" style="width:1000px;height:320px;"> 
  
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


<h2>STANDARD ROOM</h2>

<div class="bullet">

<ul>
  <li>35 square meters</li></br>
  <li> One king-sized bed that can fit up to 2 adults.</li></br>
   <li> One queen-size bed that can fit up to two adults.</li>
</ul>


</div>
