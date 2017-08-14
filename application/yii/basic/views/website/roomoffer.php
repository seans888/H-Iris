<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'RoomOffer';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-about">

	<img src="uploads/sm.jpg" style="width:100px;height:100px;"> <br> 
    <div class="body-content">
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/Taalhotel.jpg" style="width:100%;height:20%"> 
    <div class="text">Taal Hotel</div>
  </div>

  <div class="mySlides">
    <img src="uploads/Taalroom.jpg" style="width:100%;height:20%"> 
    <div class="text">Rooms</div>
  </div>

  <div class="mySlides">
    <img src="uploads/Dining.jpg" style="width:100%;height:20%;"> 
    <div class="text"> Dining </div>
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

    <h1><?= Html::encode($this->title) ?></h1>
<h1> OFFERS AND ACTIVITIES </h1>
</br>

<h2>ROOM OFFERS</h2>

<h2>Family Package</h2>
 <img src="uploads/roomoffer.jpg" style="width:100%;height:20%;"> 
    <p>
<strong>Family Package </strong>
    	<br>
        Any day is always a great day for a family escapade at Pico Sands Hotel. Book now and pay a starting rate of PHP 9,900 a night on our Premier Mountain View Room or PHP 10,900 a night on our Premier Lagoon View Room using this special promo!
</br>
Promo is applicable for stays until September 15, 2017    	
    	
    </p>

    <p><a class="btn btn-lg btn-success" href="http://localhost/yii/web/index.php?r=site%2Fabout">Read More</a></p>

   </div>