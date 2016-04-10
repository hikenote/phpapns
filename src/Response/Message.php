<?php
namespace PhpApns\Response;

class Message
{
    /**
     * Response Codes
     * @var int
     */
    const RESULT_OK = 0;
    const RESULT_PROCESSING_ERROR = 1;
    const RESULT_MISSING_TOKEN = 2;
    const RESULT_MISSING_TOPIC = 3;
    const RESULT_MISSING_PAYLOAD = 4;
    const RESULT_INVALID_TOKEN_SIZE = 5;
    const RESULT_INVALID_TOPIC_SIZE = 6;
    const RESULT_INVALID_PAYLOAD_SIZE = 7;
    const RESULT_INVALID_TOKEN = 8;
    const RESULT_SHUTDOWN = 10;
    const RESULT_PROTOCOL_ERROR = 128;
    const RESULT_UNKNOWN_ERROR = 255;

    /**
     * Identifier
     * @var string
     */
    protected $id;
    /**
     * Result Code
     * @var int
     */
    protected $code;
    /**
     * Constructor
     *
     * @param  string  $rawResponse
     * @return Message
     */

    public function __construct($rawResponse = null)
    {
        if ($rawResponse !== null) {
            $this->parseRawResponse($rawResponse);
        }
    }

    /**
     * Get Code
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set Code
     *
     * @param  int     $code
     * @return Message
     */
    public function setCode($code)
    {
        if (($code < 0 || $code > 8) && $code != 10 && $code != 128 && $code != 255)
            throw new \InvalidArgumentException('Code must be between 0-8 OR 255');
        $this->code = $code;
        return $this;
    }

    /**
     * Get Identifier
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Identifier
     *
     * @param  string  $id
     * @return Message
     */
    public function setId($id)
    {
        if (!is_scalar($id))
            throw new \InvalidArgumentException('Identifier must be a scalar value');
        $this->id = $id;
        return $this;
    }

    /**
     * Parse Raw Response
     *
     * @param  string  $rawResponse
     * @return Message
     */
    public function parseRawResponse($rawResponse)
    {
        if (!is_scalar($rawResponse))
            throw new \InvalidArgumentException('Response must be a scalar value');
        if (strlen($rawResponse) === 0) {
            $this->code = self::RESULT_OK;
            return $this;
        }
        $response = unpack('Ccmd/Cerrno/Nid', $rawResponse);
        $this->setId($response['id']);
        $this->setCode($response['errno']);
        return $this;
    }
}