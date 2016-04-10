<?php
namespace PhpApns\Client;

use PhpApns\Response\Message as MessageResponse;
use PhpApns\Message as ApnsMessage;

class Message extends AbstractClient
{
    /**
     * APNS URIs
     * @var array
     */
    protected $uris = [
        'tls://gateway.sandbox.push.apple.com:2195',
        'tls://gateway.push.apple.com:2195',
    ];

    /**
     * Send Message
     *
     * @param  ApnsMessage          $message
     * @return MessageResponse
     */
    public function send(ApnsMessage $message){
        if(!$this->isConnected())
            throw new \RuntimeException('You must first open the connection by calling open()');
        $result = @$this->write($message->getPayloadJson());
        if(!$result)
            throw new \RuntimeException('Server is unavailable; please retry later');
        return new MessageResponse($this->read());
    }

    /**
     * Get Response
     *
     * @return MessageResponse
     */
    public function getResponse(){
        if (!$this->isConnected()) {
            throw new \RuntimeException('You must first open the connection by calling open()');
        }
        return new MessageResponse($this->read());
    }
}