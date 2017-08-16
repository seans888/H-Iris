<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Reception Venue';
$this->params['breadcrumbs'][] = $this->title;
?>

 <div class="main">
 <h1 style="text-align:center">RECEPTION VENUES</h1>
       
    </div>

     <div class="body-content">
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/reception.jpg" style="width:100%;height:20%;"> 
  </div>

  <div class="mySlides">
    <img src="uploads/reception1.jpg" style="width:100%;height:20%;"> 
  </div>

  <div class="mySlides">
    <img src="uploads/reception2.jpg" style="width:100%;height:20%;"> 
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

<div class = "bullet">
  <h3>BAIA BALLROOM</h3>

<p>An indoor venue for functions and gatherings at the Country Club. It can be divided into smaller rooms for more intimidate functions and is attached to an open foyer that can serve as a receiving area.</p>

<h3>BEACH</h3>

Celebrate your nuptials against the backdrop of shimmering blue waters on this long stretch of fine sand. Set-ups on the beach can fit up to 300 people.

<h3>BRISA BAR</h3>

Striking sea views, colorful sunsets and a canopy of stars are all to be had at this al fresco dining and entertainment venue that is ideal for hosting intimate open-air gatherings. It can fit 120 people for cocktails or 70 for a sit-down dinner.

<h3>GARDEN</h3>

A lush green expanse of lawn shaded by trees with a view of the shore, it can fit up to 300 people got a sit-down dinner. 

</div>
<br>
<a class="btn btn-lg btn-success" href="mailto:sales@smhotelsandconventions.com">Request for proposal</a>

</div>
