<?php

namespace yashop\ses;

use yii\mail\BaseMessage;
use yashop\ses\libs\SimpleEmailServiceMessage;

/**
 * Message implements a message class based on Amazon Simple Email Service
 *
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
class Message extends BaseMessage
{
    /**
     * @var \yashop\ses\libs\SimpleEmailServiceMessage Simple Email Service message instance.
     */
    private $_sesMessage;

    /**
     * @var string Text content
     */
    private $messageText;

    /**
     * @var string Html content
     */
    private $messageHtml = null;

    /**
     * @var string Message charset
     */
    private $charset;

    /**
     * @var string Message sender
     */
    private $from;

    /**
     * @var string replyTo
     */
    private $replyTo;

    /**
     * @var string To
     */
    private $to;

    /**
     * @var string CC
     */
    private $cc;

    /**
     * @var string BCC
     */
    private $bcc;

    /**
     * @var string Subject
     */
    private $subject;

    /**
     * @return \yashop\ses\libs\SimpleEmailServiceMessage Simple Email Service message instance.
     */
    public function getSesMessage()
    {
        if (!is_object($this->_sesMessage)) {
            $this->_sesMessage = new SimpleEmailServiceMessage();
        }

        return $this->_sesMessage;
    }

    /**
     * @inheritdoc
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @inheritdoc
     */
    public function setCharset($charset)
    {
        $this->getSesMessage()->setMessageCharset($charset);
        $this->getSesMessage()->setSubjectCharset($charset);

        $this->charset = $charset;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @inheritdoc
     */
    public function setFrom($from)
    {
        $this->getSesMessage()->setFrom($from);

        $this->from = $from;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @inheritdoc
     */
    public function setReplyTo($replyTo)
    {
        $this->getSesMessage()->addReplyTo($replyTo);
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @inheritdoc
     */
    public function setTo($to)
    {
        $this->getSesMessage()->addTo($to);
        $this->to = $to;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @inheritdoc
     */
    public function setCc($cc)
    {
        $this->getSesMessage()->addCC($cc);
        $this->cc = $cc;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @inheritdoc
     */
    public function setBcc($bcc)
    {
        $this->getSesMessage()->addBCC($bcc);
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @inheritdoc
     */
    public function setSubject($subject)
    {
        $this->getSesMessage()->setSubject($subject);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTextBody($text)
    {
        $this->messageText = $text;
        $this->setBody($this->messageText, $this->messageHtml);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setHtmlBody($html)
    {
        $this->messageHtml = $html;
        $this->setBody($this->messageText, $this->messageHtml);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setBody($text, $html = null)
    {
        $this->getSesMessage()->setMessageFromString($text, $html);
    }

    /**
     * @inheritdoc
     */
    public function attach($fileName, array $options = [])
    {
        $name = $fileName;
        $mimeType = 'application/octet-stream';

        if (!empty($options['fileName'])) {
            $name = $options['fileName'];
        }
        if (!empty($options['contentType'])) {
            $mimeType = $options['contentType'];
        }
        $this->getSesMessage()->addAttachmentFromFile($name, $fileName, $mimeType);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function attachContent($content, array $options = [])
    {
        $name = 'file 1';
        $mimeType = 'application/octet-stream';

        if (!empty($options['fileName'])) {
            $name = $options['fileName'];
        }
        if (!empty($options['contentType'])) {
            $mimeType = $options['contentType'];
        }
        $this->getSesMessage()->addAttachmentFromData($name, $content, $mimeType);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function embed($fileName, array $options = [])
    {
        return $this->attach($fileName, $options);
    }

    /**
     * @inheritdoc
     */
    public function embedContent($content, array $options = [])
    {
        return $this->attachContent($content, $options);
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        return $this->getSesMessage()->getRawMessage();
    }
}
