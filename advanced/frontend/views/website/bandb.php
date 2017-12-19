<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Dining';
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
<div class="mySlides">
    <img src="uploads/bb1.jpg" style="width:1100px;height:320px;"> 
   
  </div>

  <div class="mySlides">
    <img src="uploads/bb2.jpg" style="width:1100px;height:320px;"> 
   
  </div>

  <div class="mySlides">
    <img src="uploads/bb3.jpg" style="width:1100px;height:320px;"> 

  
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

 <h1>DINING</h1>
 <hr class = "hrColor">
<h2> B&B</h2>
<p style="text-align:justify"> B&B is a casual bowling and billiards hall that serves all-day snacks, appetizers, and non-alcoholic and alcoholic drinks.   
</br>
</br>
<strong>Location:</strong> Ground Floor, Pico de Loro Country Club
</br>
</br>
<strong>Operating Hours: </strong> 9:00 AM – 10:00 PM (Friday to Saturday), 9:00 AM – 8:00 PM (Sunday to Thursday) </p>


