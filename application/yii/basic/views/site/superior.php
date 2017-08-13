<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'superior';
$this->params['breadcrumbs'][] = $this->title;
?>

 <div class="main">
 </br>
        <p>SM Hotels and Convention Corporation</p>
   
    </div>

     <div class="body-content">
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/Taalhotel.jpg" style="width:100%;height:20%;"> 
    <div class="text">Taal Hotel</div>
  </div>

  <div class="mySlides">
    <img src="uploads/Taalroom.jpg" style="width:100%;height:20%;"> 
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
<div class="sitehead">

<h1> ROOMS </h1>
</br>

<h2>SUPERIOR ROOM</h2>

<ul>
  <li>37 square meters with a 7 square meter balcony</li>
  <li>One king-sized bed that can fit up to two adults
</li>
</ul>
 <img src="uploads/Lsuperiorjpg" style="width:100%;height:20%;"> 

</div>