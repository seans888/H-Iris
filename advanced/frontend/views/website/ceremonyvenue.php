<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Ceremony Venue';
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
    <img src="uploads/ceremonyvenue1.jpg" style="width:100%;height:20%;"> 
  </div>

  <div class="mySlides">
    <img src="uploads/ceremonyvenue2.jpg" style="width:100%;height:20%;"> 
  </div>

  <div class="mySlides">
    <img src="uploads/ceremonyvenue3.jpg" style="width:100%;height:20%;"> 
  </div> 
  <div class="mySlides">
    <img src="uploads/ceremonyvenue.jpg" style="width:100%;height:20%;"> 
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
 
<div>
<h1> WEDDINGS</h1>
<hr class = "hrColor">
<h2>CEREMONY VENUES</h2>
<hr class = "hrColor">
<h3>CHAPEL</h3>

<h4>ST. THERESE CHAPEL</h4>

<h5>INCLUSIONS:</h5>

<div class = "bullet">
<ul>
  <li>Use of St. Therese of the Child Jesus Chapel and permit for 100 persons</li>
  <li>Basic sound system with three microphones</li>
  <li>Floral arrangement for pews and altar</li>
  <li>Two nuptial candles with floral arrangement</li>
  <li>Loose petals for the aisle</li>
  <li>Red carpet</li>
</ul> 
</div>

<h3>BEACH OR GARDEN</h3>

<h4>GARDEN CEREMONY</h4>

<h5>INCLUSIONS:</h5>
<div class = "bullet">
<ul>
  <li>Use of beach or garden and permit for 100 persons</li>
  <li>Basic sound system with three microphones</li>
  <li>Web chairs or banquet chairs for 100 persons</li>
  <li>Floral arrangement for aisle and altar</li>
  <li>Two nuptial candles with floral arrangemente</li>
  <li>Loose petals for the aisle</li>
  <li>Burlap carpet</li>
</ul>
</div>
<br>
<a class="btn btn-lg btn-success" href="mailto:sales@smhotelsandconventions.com">Request for proposal</a>
</div>
