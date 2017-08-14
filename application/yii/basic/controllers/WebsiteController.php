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
     public function actionPdf()
    {
        return $this->renderPartial('Pico Wedding by the Sea Menu.pdf');
      
    }

}
