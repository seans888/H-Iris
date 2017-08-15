<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'spa';
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

<h1> Spa </h1>
<h2> Overview </h2>
<div class="bullet">
<p> Fusing traditional and progressive therapeutic practices in health and well-being, the Rain Spa provides a </br>
tropical sanctuary of relaxation and renewal.
</br>
</br>
A selection of services is offered at the Beach Club and to residents and guests residing in the condos.  
</p>

<a href="uploads/spa.pdf" type="application/pdf; length=161318" title="spa.pdf">Rain Spa Menu</a>
</div>

