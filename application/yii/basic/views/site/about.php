<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-about">

	<img src="uploads/sm.jpg" style="width:300px;height:300px;"> <br> 
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

  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>

  <a class="next" onclick="plusSlides(1)">&#10095;</a>
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


    <p>

    	<br>
        SM Hotels and Conventions Corporation (SMHCC) was established to address the vast potential of tourism in the country. 
    	</br>
    	It is now developing and operating hotels and convention centers all throughout the archipelago with a current portfolio
    	</br>
    	of 1,514 rooms housed in the 261-room Taal Vista Hotel, a heritage hotel located in Tagaytay City; the 396-room upper
    	<br>
    	upscale Radisson Blu Hotel in Cebu; the 154-room Pico Sands Hotel in Hamilo Coast; the 202-room Park Inn by Radisson
    	</br>
    	in Davao; the 154-room Park Inn by Radisson in Clark in Pampanga; and the 347-guest room deluxe 5-star hotel,  
    	<br>
    	Conrad Manila, located in the Mall of Asia Complex.
    	</br>
 
    </p>

    <p>
    	<br>
    	All these allow guests to experience luxury and the world-renowned Filipino hospitality, made more memorable by the
    	</br>
    	natural beauty of their surrounding landscapes.
    </p>

    <p>
    	<br>
    	SMHCC operates convention centers and trade halls through SMX Convention Center (SMX), which has become a popular 
    	</br>
   		venue for both local and international events. Setting the bar in upscale convention facilities, SMX provides an ideal venue
   		<br>
   		for large-scale institutional events, townhall meetings, weddings, exhibits, and concerts in many cities across the country.
   		</br>
    </p>

    <p>
    	<br>
    	Consequently, SMX has branch out to Taguig, Davao and Bacolod. SMHCC also operates trade halls in SM Megamall and 
    	</br>
    	SM City Cebu. Put together, SMX has a total of 35,623 square meters of gross leasable area (GLA) making it the largest 
    	<br>
    	privately run exhibition and conventions business in the Philippines.
    </p>
  

		<br> 
        SM Hotels and Conventions Corporation (SMHCC) was established to address the vast potential of tourism in the country.  
		</br> 
		It is now developing and operating hotels and convention centers all throughout the archipelago with a current portfolio 
		</br> 
		of 1,514 rooms housed in the 261-room Taal Vista Hotel, a heritage hotel located in Tagaytay City; the 396-room upper 
		<br> 
		upscale Radisson Blu Hotel in Cebu; the 154-room Pico Sands Hotel in Hamilo Coast; the 202-room Park Inn by Radisson 
		</br> 
		in Davao; the 154-room Park Inn by Radisson in Clark in Pampanga; and the 347-guest room deluxe 5-star hotel,   
		<br> 
		Conrad Manila, located in the Mall of Asia Complex. 
		</br> 
    </p>
    <p> 
		<br> 
		All these allow guests to experience luxury and the world-renowned Filipino hospitality, made more memorable by the 
		</br> 
		natural beauty of their surrounding landscapes. 
	</p> 
	<p> 
		<br> 
		SMHCC operates convention centers and trade halls through SMX Convention Center (SMX), which has become a popular  
		</br> 
		venue for both local and international events. Setting the bar in upscale convention facilities, SMX provides an ideal venue 
		<br> 
		for large-scale institutional events, townhall meetings, weddings, exhibits, and concerts in many cities across the country. 
		</br> 
	</p> 
	<p> 
		<br> 
		Consequently, SMX has branch out to Taguig, Davao and Bacolod. SMHCC also operates trade halls in SM Megamall and  
		</br> 
		SM City Cebu. Put together, SMX has a total of 35,623 square meters of gross leasable area (GLA) making it the largest  
		<br> 
		privately run exhibition and conventions business in the Philippines. 
	</p> 

</div>
