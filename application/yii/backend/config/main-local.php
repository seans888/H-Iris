<?php
return [
        'components' => [
            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=localhost;dbname=mi151_00_master_db',
                'username' => 'root',
                'password' => 'as',
                'charset' => 'utf8',
                ],
            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@app/mail',
                'useFileTransport' => false,
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                     'host'=>'smtp.gmail.com',
                    'username'=>'shierenecervantes23@gmail.com',
                    'password'=>'Password',
                    'port' => '465',
                    //'encryption' => 'tls',
                /*'streamOptions' =>['tls' =>
                        ['allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        ],
                        ]*/
                ],
            ],
        ],
    ];