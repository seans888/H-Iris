<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
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
<div class="site-about">

 <br> 
    <div class="body-content">
    <h1 style="text-align:center"> EVENTS
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
<p> Weddings at the Pico de Loro Cove
<br>
Imagine saying “I do” amidst breathtaking views of the ocean and mountains. We have everything you want and need to create wedding memories to last a lifetime. Happily ever after starts here.
</p>
<p>Corporate Events
<br>
Whether it's a grand family celebration or a successful business event, we have the spaces that meet your requirements. Our meeting facilities provide the most conducive environment for your function. A designated events manager will also be on hand at all times to assist you with all your banquet needs.
</p>


 
<h1 > GALLERY
</h1>
<div class="col-md-6"><img src="uploads/WeddingB.jpg" style="width:300px;height:300px;">
</div>
<div class= "col-md-1">   </div>
 <br>
<div class="col-md-6"><img src="uploads/WeddingC.jpg" style="width:300px;height:300px;">
</div>
<div class="col-md-6"><img src="uploads/WeddingG.jpg" style="width:300px;height:300px;">
</div>
</div>
