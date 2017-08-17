<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-about">

<br> 
    <div class="body-content">
    <h1 style="text-align:center"> ROOMS
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

<h2 style="text-align:center;"> GALLERY
</h2>
<div class ="row">

<div class="col-md-6"><a href="http://localhost/yii/web/index.php?r=website%2Fsuperior"><img src="uploads/Lsuperior.jpg" style="width:300px;height:300px;">

<p>
Superior Room (Lagoon View)</a></div>
</p>
</div>

<div class="col-md-6"></div>

<div class="col-md-6"><a href="http://localhost/yii/web/index.php?r=website%2Fdeluxe" ><img src="uploads/deluxe.jpg" style="width:300px;height:300px;">

<p>
Deluxe Room (Lagoon View)</a></div>
</p>

<a href="http://localhost/yii/web/index.php?r=website%2Fpremier"><img src="uploads/premier.jpg" style="width:300px;height:300px;">

<p>
Premier Room (Lagoon View)</a></div>
</p>


</div>
</div>