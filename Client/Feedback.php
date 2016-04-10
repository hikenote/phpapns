<?php
namespace PhpApns\Client;

use PhpApns\Client\AbstractClient;
use PhpApns\Response\Feedback as FeedbackResponse;

class Feedback extends AbstractClient
{
    /**
     * APNS URIs
     * @var array
     */
    protected $uris = [
        'tls://feedback.sandbox.push.apple.com:2196',
        'tls://feedback.push.apple.com:2196'
    ];

    /**
     * get feedback
     * @return array
     */
    public function feedback(){
        if(!$this->isConnected())
            throw new \RuntimeException('You must first open the connection by calling open()');

        $tokens = [];
        while($token = $this->read(38))
            if(strlen($token) == 38)
                $tokens[] = new FeedbackResponse($token);
        return $tokens;
    }
}