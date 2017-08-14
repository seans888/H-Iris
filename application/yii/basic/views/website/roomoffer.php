<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'RoomOffer';
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="body-content">
        <div class="slideshow-container">

  <div class="mySlides">
    <img src="uploads/Taalhotel.jpg" style="width:100%;height:20%"> 
   
  </div>

  <div class="mySlides">
    <img src="uploads/Taalroom.jpg" style="width:100%;height:20%"> 

  </div>

  <div class="mySlides">
    <img src="uploads/Dining.jpg" style="width:100%;height:20%;"> 
  
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

<h1> OFFERS AND ACTIVITIES </h1>
<h2>ROOM OFFERS</h2>

</br>
</br>

<h2>Family Package</h2>
 <img src="uploads/roomoffer.jpg" style="width:40%;height:40%;"> 
 <div class="bullet">
    <p>
<h3>Family Package </h3>
    	</br>
     <strong> Any day is always a great day for a family escapade at Pico Sands Hotel.</strong> </br>  </br>Book now and pay a starting rate of PHP 9,900 a night on our <strong> Premier Mountain View Room</strong>  </br> </br>or </br></br> PHP 10,900 a night on our <strong> Premier Lagoon View Room</strong>  using this special promo!
</br>
Promo is applicable for stays until <strong>September 15, 2017 </strong>   	
    	
    </p>

    <p><a class="btn btn-lg btn-success" href="http://localhost/yii/web/index.php?r=site%2Fabout">Read More</a></p>

   </div>