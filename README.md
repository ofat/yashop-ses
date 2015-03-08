Amazon ses extension for Yii2
=============================
Extension for sending emails via amazon ses. Part of YaShop

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist ofat/yii2-yashop-ses "*"
```

or add

```
"ofat/yii2-yashop-ses": "*"
```

to the require section of your `composer.json` file.


Usage
-----

To use this extension, you should configure it in the application configuration like the following:

```php
'components' => [
    ...
    'mail' => [
        'class' => 'yashop\ses\Mailer',
        'access_key' => 'Your access key',
        'secret_key' => 'Your secret key',
        'host' => 'email.us-east-1.amazonaws.com' // not required
    ],
    ...
],
```

To send an email, you may use the following code:

```php
Yii::$app->mail->compose('contact/html', ['contactForm' => $form])
    ->setFrom('from@domain.com')
    ->setTo($form->email)
    ->setSubject($form->subject)
    ->send();