<?php

namespace app\controllers;

class WebsiteController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

public function actionRoomoverview()
    {
        return $this->render('roomoverview');
      
    }

    public function actionLagoon()
    {
        return $this->render('lagoon');
      
    }
    
    public function actionSuperior()
    {
        return $this->render('superior');
      
    }


    public function actionDeluxe()
    {
        return $this->render('deluxe');
      
    }

 public function actionPremier()
    {
        return $this->render('premier');
      
    }

 public function actionCornerdeluxe()
    {
        return $this->render('cornerdeluxe');
      
    }

public function actionPenthouse()
    {
        return $this->render('penthouse');
      
    }


    public function actionStandard()
    {
        return $this->render('standard');
      
    }

     public function actionMountain()
    {
        return $this->render('mountain');
      
    }


   public function actionMsuperior()
    {
        return $this->render('msuperior');
      
    }

    public function actionMpremier()
    {
        return $this->render('mpremier');
      
    }



      public function actionRandb()
    {
        return $this->render('randb');
      
    }


    public function actionReefbar()
    {
        return $this->render('reefbar');
      
    }

    public function actionBandb()
    {
        return $this->render('bandb');
      
    }

       public function actionLagoa()
    {
        return $this->render('lagoa');
      
    }

     public function actionSpa()
    {
        return $this->render('spa');
      
    }


       public function actionSpabookguide()
    {
        return $this->render('spabookguide');
      
    }

     public function actionRoomoffer()
    {
        return $this->render('roomoffer');
      
    }

    public function actionPrewedding()
    {
        return $this->render('prewedding');
      
    }
     public function actionWeddingpackage()
    {
        return $this->render('weddingpackage');
      
    }
     public function actionCeremonyvenue()
    {
        return $this->render('ceremonyvenue');
      
    }
    public function actionReception()
    {
        return $this->render('reception');
    }
    public function actionTeambuild()
    {
        return $this->render('teambuild');
    }
     public function actionLeisure()
    {
        return $this->render('leisure');
      
    }
    public function actionRoom()
    {
        return $this->render('room');
    }
    public function actionDining()
    {
        return $this->render('dining');
    }
    public function actionEvent()
    {
        return $this->render('event');
    }
    public function actionLocation()
    {
        return $this->render('location');
    }
    public function actionClubactivity()
    {
        return $this->render('clubactivity');
    }
    public function actionPromotions()
    {
        return $this->render('promotions');
    }

}
