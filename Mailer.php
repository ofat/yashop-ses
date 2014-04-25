<?php
/**
 *
 * Mailer implements a mailer based on Amazon SES.
 *
 * To use Mailer, you should configure it in the application configuration like the following,
 *
 * ~~~
 * 'components' => [
 *     ...
 *     'mail' => [
 *         'class' => 'yashop\ses\Mailer',
 *         'access_key' => 'Your access key',
 *         'secret_key' => 'Your secret key'
 *     ],
 *     ...
 * ],
 * ~~~
 *
 * To send an email, you may use the following code:
 *
 * ~~~
 * Yii::$app->mail->compose('contact/html', ['contactForm' => $form])
 *     ->setFrom('from@domain.com')
 *     ->setTo($form->email)
 *     ->setSubject($form->subject)
 *     ->send();
 * ~~~
 *
 * @property array|\Swift_Mailer $swiftMailer Swift mailer instance or array configuration. This property is
 * read-only.
 * @property array|\Swift_Transport $transport This property is read-only.
 *
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\ses;

use yii\mail\BaseMailer;

class Mailer extends BaseMailer
{
    /**
     * @var string message default class name.
     */
    public $messageClass = 'yashop\ses\Message';

    /*
     * @var string Amazon ses api access key
     */
    public $access_key;

    /*
     * @var string Amazon ses api secret key
     */
    public $secret_key;

}