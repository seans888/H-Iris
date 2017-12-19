<?php
    /* @var $this yii\web\View */
    
    $this->title = 'SM Hotels and Convention Corporation';
    ?>
<link rel="stylesheet" type="text/css" href="site.css">
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
<script src="//load.sumome.com/" data-sumo-site-id="47387229f4475a483619462dd6cc1e8e4841e29814ad48435e892d22dffd703c" async="async"></script></head>
<div class="site-index">
<div class="main">
    </br>
</div>
<div class="body-content">
    <div class="slideshow-container">
        <div class="mySlides">
            <img src="uploads/Taalhotel.jpg" style="width:1000px;height:500px;"> 
        </div>
        <div class="mySlides">
            <img src="uploads/Taalroom.jpg" style="width:1000px;height:500px;"> 
        </div>
        <div class="mySlides">
            <img src="uploads/Dining.jpg" style="width:1000px;height:500px;"> 
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
    <div class="body-content">
        <div class="paneSection">
            <div class="about">
                <h1 style="text-align:center;">About Us</h1>
                <h4>
                    <p style="text-indent:50px, text-align: justify; ">SM Hotels and Conventions Corporation (SMHCC) was established to address the vast potential of tourism 
                        in the country. It is now developing and operating hotels and convention centers all throughout the 
                        archipelago with a current portfolio of 1,514 rooms housed in the 261-room Taal Vista Hotel, a heritage
                        hotel located in Tagaytay City; the 396-room upper upscale Radisson Blu Hotel in Cebu; the 154-room Pico 
                        Sands Hotel in Hamilo Coast; the 202-room Park Inn by Radisson in Davao; the 154-room Park Inn by Radisson
                        in Clark in Pampanga; and the 347-guest room deluxe 5-star hotel, Conrad Manila, located in the Mall of 
                        Asia Complex.
                    </p>
                </h4>
                <p><a class="btn btn-default" href="http://localhost/ems/frontend/web/index.php?r=site%2Fabout">About Us &raquo;</a></p>
            </div>
        </div>
        <div class="paneSection">
            <h1 style="text-align:center;">Rooms </h1>
            <div class="row">
                <div class= "col-md-6">
                    <a href=http://localhost/ems/frontend/web/index.php?r=website%2Flagoon><img src="uploads/rm1.jpg" style="width:500px;height:320px;"></a>
                    <h2 style="text-align:center;"> LAGOON VIEW </h2>
                    </br>
                    <h4>
                        <p> Feast your eyes on the breathtaking view of the man-made lagoon from your veranda. </p>
                    </h4>
                </div>
                <div class= "col-md-4">   </div>
                <div class= "col-md-6">
                    <a href=http://localhost/ems/frontend/web/index.php?r=website%2Fmountain><img src="uploads/rm2.jpg" style="width:500px;height:320px;"></a>
                    <h2 style="text-align:center;"> MOUNTAIN VIEW </h2>
                    </br>
                    <h4>
                        <p> Bask in the verdant backdrop of green hills and the stunning Mt. Pico de Loro.</p>
                    </h4>
                </div>
            </div>
        </div>
        <div class="paneSection">
            <div class="row">
                </br>
                </br>
                <h1 style="text-align:center;">Dining</h1>
                <div class= "col-sm-5"> <span class="pull-right">
                    <a href="http://localhost/ems/frontend/web/index.php?r=website%2Frandb"><img src="uploads/dining.jpg" style="width:500px;height:500px;"></a>
                </div>
                <div class= "col-md-5">
                    </br>
                    </br>
                    <h4>
                        <p> Complete the leisure lifestyle at Pico Sands Hotel with the variety of casual dining spots featuring Spanish and Filipino dishes.</p>
                    </h4>
                    </br>
                    <h4>
                        <strong>RENOVATION NOTICE: </strong>
                        <p style="text-align:justify;"> In our continuing effort to better serve our valued guests, we are upgrading the Pico Restaurant al fresco area.
                            Upgrading work start at 11:00 am until 4:00 pm, daily. We assure you that we will take all measures to minimize disturbance and maintain comfort and convenience. Please bear with us.
                        </p>
                    </h4>
                    <p><a class="btn btn-lg btn-success" href="http://localhost/ems/frontend/web/index.php?r=website%2Frandb">More</a></p>
                </div>
            </div>
        </div>
        <div class="paneSection">
            <div class="row">
                </br>
                </br>
                <h1 style="text-align:center;">Spa</h1>
                <div class= "col-sm-5"> <span class="pull-right">
                    <a href="http://localhost/ems/frontend/web/index.php?r=website%2Fspa"><img src="uploads/spa.jpg" style="width:500px;height:500px;"></a>
                </div>
                <div class= "col-md-5">
                    </br>
                    </br>
                    <h4>
                        <p style="text-align:justify;"> Heal your body, calm your mind and soothe your spirit with our treatments in this Batangas beach resort, using organic and indigenous local products.</p>
                    </h4>
                    <p><a class="btn btn-lg btn-success" href="http://localhost/ems/frontend/web/index.php?r=website%2Fspa">More</a></p>
                </div>
            </div>
        </div>
    </div>
</div>