<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'ROOMS';
$this->params['breadcrumbs'][] = $this->title;
?>

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-107946197-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'UA-107946197-1');
        </script>-->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-108264025-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        
        gtag('config', 'UA-108264025-1');
    </script>
</head>
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
<div>
<h1>ROOMS</h1>
<hr class = "hrColor">
<h2>PICO SANDS HOTEL – RATES AND ACCOMMODATION</h2>
<hr class = "hrColor">
 <h3>SLUMBER IN TRANQUILITY </h3>
 <p style="text-align:justify; ">
Furnished with natural materials in a soothing palette of seashell whites and sandy creams, the rooms offer a relaxing retreat from the hustle and bustle of city life with views that overlook the lush mountains or a calming lagoon. The average room size is 37 square meters and room types offered are Standard, Superior, Deluxe, Premier, Corner Deluxe and Penthouse Lofts. For Pico Sands Hotel room rates, click on the “Book a Room” button above.
</br>
</br>

</div>

