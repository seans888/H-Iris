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
    <h1 style="text-align:center"> LEISURE
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
  <p>Unwind and let yourself feel the distinct enjoyment here at Pico de Loro. Go nature trip and discover new 
  world under the sea. Bring your family to a Cove tour where you can see the 5 amazing coves of Hamilo 
  Coast. Indulge in some fun under the sun in our kayaking, fishing, beach volleyball and football, and paddle 
  board. Add some action-packed water activities with our snorkeling, scuba diving, Jet Ski and Banana
  boat.</p>
<br>
    Experience our wide selection of indoor sports activities where you can find and play the most popular 
    games for everyone. It features 6 Badminton courts made of Tara flex, Basketball court, Tennis, Squash and 
    Table Tennis located at the ground floor area of the Country Club.
</ul>

<h1 > GALLERY
</h1>
<div class="col-md-6"><img src="uploads/clubactivity1.jpg" style="width:300px;height:300px;">
</div>
 <div class= "col-md-1">   </div>
 <br>
<div class="col-md-6"><img src="uploads/Frisbee.jpg" style="width:300px;height:300px;">
</div>
<br>
<div class="col-md-6"><img src="uploads/Jetski.jpg" style="width:300px;height:300px;">
</div>
<br>
<div class= "col-md-1">   
</div>
<div class="col-md-6"><img src="uploads/reefbar1.jpg" style="width:300px;height:300px;">
</div>

</div>
