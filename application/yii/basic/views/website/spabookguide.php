<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'SPA';
$this->params['breadcrumbs'][] = $this->title;
?>
     <div class="body-content">
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/spa2.jpg" style="width:100%;height:10%;"> 
   
  </div>

  <div class="mySlides">
    <img src="uploads/spa3.jpg" style="width:100%;height:10%;"> 
   
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

<h1>SPA</h1>
<hr class = "hrColor">
<h2>BOOKING GUIDELINES</h2>

 <div class="bullet">
<p>
<ul>
  <li>Once booking is confirmed it is subject to the Rain Spa Cancellation Policy.</li>
  <li>Rebooking should be advised 4 hours prior to reservation and is subject to availability.</li>
  <li>Cancellation made 24 hours prior to the reservation will not incur any cancellation charge.</li>
  <li>Cancellation made less than 24 hours prior to the reservation shall incur a cancellation charge equivalent to the value of the treatment and shall be charged accordingly.</li>
  <li>No show will incur a cancellation charge equivalent to the value of the treatment and shall be charged according to the mode of payment chosen.</li>
  <li>Any time lost due to late arrival shall be deducted from the total treatment time, the full rate will still apply.</li>
  </br>
   <li><strong>Mode of payment:</strong></li>
</ul>

<ul style="list-style-type:circle">
  <li>Cash if booking and payment are done in the condos.</li>
  <li>Credit card if booking and payment are done in the Rain Spa</li>
</ul>  
</p>
</div>