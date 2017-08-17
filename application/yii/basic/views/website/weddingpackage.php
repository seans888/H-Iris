<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Wedding Package';
$this->params['breadcrumbs'][] = $this->title;
?>
     <div class="body-content">
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/weddingpackage2.jpg" style="width:100%;height:20%;"> 
  </div>

  <div class="mySlides">
    <img src="uploads/weddingpackage1.jpg" style="width:100%;height:20%;"> 
  </div>

  <div class="mySlides">
    <img src="uploads/weddingpackage.jpg" style="width:100%;height:20%;"> 
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
 <h2>WEDDING PACKAGES</h2>
<hr>
 <br>
 <p><img src="uploads/application-pdf.png" style="width:1.3%;height:1.3%;"><a href ="uploads/Pico Wedding by the Sea Menu.pdf">Pico Wedding by the Sea Menu</a></p>
 <p><img src="uploads/application-pdf.png" style="width:1.3%;height:1.3%;"><a href ="uploads/Pico Wedding Packages 2018.pdf">Pico Wedding Packages 2018</a></p>
 <p><img src="uploads/application-pdf.png" style="width:1.3%;height:1.3%;"><a href ="uploads/Pico_Wedding_Menu_FA.pdf">Pico Wedding Menu</a></p>
 <div>
 <br>
 <a class="btn btn-lg btn-success" href="mailto:sales@smhotelsandconventions.com">Request for proposal</a>
</div>
 </div>

 