<?php
// $config = parse_ini_file('/etc/mysql/config.ini');
// $host = $config['servername'];
// $username = $config['username'];
// $password = $config['password'];
// $dbname = 'veebo';
if (getenv('ENV_VAR') == "local") {    
    // local server configuration
        $host = "localhost";
        $username = "root";
        $password = "ur48x";
        $databasename = "veebo";
} else if (getenv('ENV_VAR') == "development_dev2") {
// dev server configuration
    $host = "127.0.0.1";
    $username = "root";
    $password = "ur48x";
    $databasename = "veebo";
} else if (getenv('ENV_VAR') == "production") {

// Production Confuguration
    $host = "localhost";
    $username = "root";
    $password = "ur48x";
    $databasename = "veebo";
}

switch (getenv('ENV_VAR')) {
    case 'local':
        $smtpData = ['smtp.gmail.com', 'akshayb.spaceo@gmail.com', 'akshay@1505', 465, 'ssl'];
        break;
    case 'development_dev2':
        $smtpData = ['smtp.gmail.com', 'sameerp.spaceo@gmail.com', 'vmqipgusbwqzrvvj', 465, 'ssl'];
        break;
    case 'production':
        $smtpData = ['smtp.gmail.com', 'sameerp.spaceo@gmail.com', 'vmqipgusbwqzrvvj', 465, 'ssl'];
}

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => "mysql:host=$host;dbname=$databasename",
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            //'enableSwiftMailerLogging' => true,
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $smtpData[0],
                'username' => $smtpData[1],
                'password' => $smtpData[2],
                'port' => $smtpData[3], // Port 25 is a very common port too ssl = 465, tls = 587
                'encryption' => $smtpData[4], // It is often used, check your provider or mail server specs
                'streamOptions' => [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ],
            ],
        ],
    ],
];
