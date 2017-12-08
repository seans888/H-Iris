<?php
return [
		protected function sendEmail($email, $subject, $message, $options= array()) {
		            $email = 'noelleshierenecervantes@gmail.com';
		           **$emailSend = Yii::$app->mailer->compose(['html' =>'layouts/html'],['content' => $message])**
		                    ->setFrom(["noelleshierenecervantes@gmail.com"])
		                    ->setTo($email)
		                    ->setSubject($subject);
		        return $emailSend->send();
		    }
		];