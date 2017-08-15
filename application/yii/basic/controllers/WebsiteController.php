<?php

namespace app\controllers;

class WebsiteController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
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

     public function actionSpa()
    {
        return $this->render('spa');
      
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
     public function actionLeisure()
    {
        return $this->render('leisure');
      
    }
    
    

}
