<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-about">

 <br> 
    <div class="body-content">
    <h1 style="text-align:center"> DINING
</h1>
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/leisure1.jpg" style="width:100%;height:20%"> 
  </div>

  <div class="mySlides">
    <img src="uploads/leisure2.jpg" style="width:100%;height:20%"> 
  </div>

  <div class="mySlides">
    <img src="uploads/leisure3.jpg" style="width:100%;height:20%;"> 
  </div>

  <div class="mySlides">
    <img src="uploads/leisure4.jpg" style="width:100%;height:20%;"> 
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


<ul>
  <p>Reef Bar
  <br>
    A seaside bar located at the beach club. The reef bar serves refreshing drinks and delightful meals you can enjoy while lounging by the beach.   </p>
   <p> Lagoa
    <br>
    Lagoa restaurant is the signature food and beverage facility of the country club that offers an extensive a la carte menu. </p>
   <p> B&B
    <br>
Enjoy a six-lane bowling alley and billiard tables at BB located on the ground floor of the country club. B&B also serves appetizers, snacks, non-alcoholic and alcoholic drinks.</p>
<p> Pico Restaurant and Bar
<br>
Scrumptious breakfast to start your day. Savory feasts for lunch and dinner. Mojitos to cap off an exciting day.
<p>Grab n Go
<br>
Your one stop shop for ready to eat food and drinks.
    </p>
</ul>

<h1 > GALLERY
</h1>
<div class="col-md-6"><img src="uploads/picobar.jpg" style="width:300px;height:300px;">
</div>
 <div class= "col-md-1">   </div>
 <br>
<div class="col-md-6"><img src="uploads/pizza.jpg" style="width:300px;height:300px;">
</div>
<br>
<div class="col-md-6"><img src="uploads/BB.jpg" style="width:300px;height:300px;">
</div>
<br>
<div class= "col-md-1">   
</div>
<div class="col-md-6"><img src="uploads/reefbar1.jpg" style="width:300px;height:300px;">
</div>
</div>
