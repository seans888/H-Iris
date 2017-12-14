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
</head>
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
    <br>
    <br>
    <br>
    <div class="body-content">
       <!--Reports-->

<!--for Last Month and This Month Sessions-->
<iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQQrccS7v8Jq63cSL5W_FnDnAPyNfIVw22ck_rCB4CPQM68cMcWiXssshdWwpd_RsHG6sjTV5ny0Qyt/pubchart?oid=203812847&amp;format=interactive"></iframe>

<!--for Users-->
<iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQQrccS7v8Jq63cSL5W_FnDnAPyNfIVw22ck_rCB4CPQM68cMcWiXssshdWwpd_RsHG6sjTV5ny0Qyt/pubchart?oid=490008769&amp;format=interactive"></iframe>

<!--Location-->
<iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQQrccS7v8Jq63cSL5W_FnDnAPyNfIVw22ck_rCB4CPQM68cMcWiXssshdWwpd_RsHG6sjTV5ny0Qyt/pubchart?oid=1745203371&amp;format=interactive"></iframe>

<!--for Top Browsers-->
<iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQQrccS7v8Jq63cSL5W_FnDnAPyNfIVw22ck_rCB4CPQM68cMcWiXssshdWwpd_RsHG6sjTV5ny0Qyt/pubchart?oid=457399618&amp;format=interactive"></iframe>

<!--for Page Views Last Month-->
<iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQQrccS7v8Jq63cSL5W_FnDnAPyNfIVw22ck_rCB4CPQM68cMcWiXssshdWwpd_RsHG6sjTV5ny0Qyt/pubchart?oid=875275833&amp;format=interactive"></iframe>

<!--for Page Views This Month-->
<iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQQrccS7v8Jq63cSL5W_FnDnAPyNfIVw22ck_rCB4CPQM68cMcWiXssshdWwpd_RsHG6sjTV5ny0Qyt/pubchart?oid=157271260&amp;format=interactive"></iframe>

    </div>
</div>