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
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\ses;

use yashop\ses\libs\SimpleEmailService;
use Yii;
use yii\mail\BaseMailer;

class Mailer extends BaseMailer
{
    /**
     * @var string message default class name.
     */
    public $messageClass = 'yashop\ses\Message';

    /**
     * @var string Amazon ses api access key
     */
    public $access_key;

    /**
     * @var string Amazon ses api secret key
     */
    public $secret_key;

    /**
     * @var string A default from address to send email
     */
    public $default_from;

    /**
     * @var \yashop\ses\libs\SimpleEmailService SimpleEmailService instance.
     */
    private $_ses;

    /**
     * @return \yashop\ses\libs\SimpleEmailService SimpleEmailService instance.
     */
    public function getSES()
    {
        if (!is_object($this->_ses)) {
            $this->_ses = new SimpleEmailService($this->access_key, $this->secret_key);
        }

        return $this->_ses;
    }

    /**
     * @inheritdoc
     */
    protected function sendMessage($message)
    {
        $address = $message->getTo();
        if (is_array($address)) {
            $address = implode(', ', array_keys($address));
        }
        Yii::info('Sending email "' . $message->getSubject() . '" to "' . $address . '"', __METHOD__);

        if ( is_null($message->getFrom()) && isset($this->default_from)) {
            if(!is_array($this->default_from)){
                $this->default_from = array($this->default_from => $this->default_from);
            }
            $message->setFrom($this->default_from);
        }
        $res = $this->getSES()->sendEmail($message->getSesMessage());

        $message->setDate(time());

        return count($res) > 0;
    }

}
