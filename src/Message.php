<?php
namespace PhpApns;

class Message
{
    /**
     * Identifier
     * @var string
     */
    protected $id;
    /**
     * APN Token
     * @var string
     */
    protected $token;
    /**
     * Expiration
     * @var int|null
     */
    protected $expire;
    /**
     * Alert Message
     * @var Message\Alert|null
     */
    protected $alert;
    /**
     * mutable-content ios10 added
     * @var int|null
     */
    protected $mutableContent;
    /**
     * Badge
     * @var int|null
     */
    protected $badge;
    /**
     * Sound
     * @var string|null
     */
    protected $sound;
    /**
     * Content Available
     * @var int|null
     */
    protected $contentAvailable;
    /**
     * Category
     * @var string|null
     */
    protected $category;
    /**
     * Custom Attributes
     * @var array|null
     */
    protected $custom;

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
     * Get Token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set Token
     *
     * @param  string  $token
     * @return Message
     */
    public function setToken($token)
    {
        if (!is_string($token)) {
            throw new \InvalidArgumentException(sprintf(
                'Device token must be a string, "%s" given.',
                gettype($token)
            ));
        }
        if (preg_match('/[^0-9a-f]/', $token)) {
            throw new \InvalidArgumentException(sprintf(
                'Device token must be mask "%s". Token given: "%s"',
                '/[^0-9a-f]/',
                $token
            ));
        }
        if (strlen($token) != 64) {
            throw new \InvalidArgumentException(sprintf(
                'Device token must be a 64 charsets, Token length given: %d.',
                mb_strlen($token)
            ));
        }
        $this->token = $token;
        return $this;
    }

    /**
     * Get Expiration
     *
     * @return int
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * Set Expiration
     *
     * @param  int|DateTime $expire
     * @return Message
     */
    public function setExpire($expire)
    {
        if ($expire instanceof \DateTime) {
            $expire = $expire->getTimestamp();
        } elseif (!is_numeric($expire) || $expire != (int) $expire) {
            throw new \InvalidArgumentException('Expiration must be a DateTime object or a unix timestamp');
        }
        $this->expire = $expire;
        return $this;
    }

    /**
     * Get Alert
     *
     * @return Message\Alert|null
     */
    public function getAlert()
    {
        return $this->alert;
    }

    /**
     * Set Alert
     *
     * @param  string|Message\Alert|null $alert
     * @return Message
     */
    public function setAlert($alert)
    {
        if (!$alert instanceof Message\Alert && !is_null($alert))
            $alert = new Message\Alert($alert);
        $this->alert = $alert;
        return $this;
    }

    /**
     * Get mutable-content
     * @return int|null $mutableContent
     */
    public function getMutableContent()
    {
        return $this->mutableContent;
    }

    /**
     * Set mutable-content
     * param int|null $mutableContent
     * @return Message
     */
    public function setMutableContent($mutableContent)
    {
        if ($mutableContent !== null && !$mutableContent == (int) $mutableContent)
            throw new \InvalidArgumentException('mutable-content must be null or an integer');
        $this->mutableContent = $mutableContent;
        return $this;
    }

    /**
     * Get Badge
     *
     * @return int|null
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * Set Badge
     *
     * @param  int|null $badge
     * @return Message
     */
    public function setBadge($badge)
    {
        if ($badge !== null && !$badge == (int) $badge)
            throw new \InvalidArgumentException('Badge must be null or an integer');
        $this->badge = $badge;
        return $this;
    }

    /**
     * Get Sound
     *
     * @return string|null
     */
    public function getSound()
    {
        return $this->sound;
    }

    /**
     * Set Sound
     *
     * @param  string|null $sound
     * @return Message
     */
    public function setSound($sound)
    {
        if ($sound !== null && !is_string($sound))
            throw new \InvalidArgumentException('Sound must be null or a string');
        $this->sound = $sound;
        return $this;
    }

    /**
     * Get Content Available
     *
     * @return int|null
     */
    public function getContentAvailable()
    {
        return $this->contentAvailable;
    }

    /**
     * Set Content Available
     *
     * @param  int|null $sound
     * @return Message
     */
    public function setContentAvailable($value)
    {
        if ($value !== null && !is_int($value))
            throw new \InvalidArgumentException('Content Available must be null or an integer');
        $this->contentAvailable = $value;
        return $this;
    }

    /**
     * Get Category
     *
     * @return string|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set Category
     *
     * @param  string|null $category
     * @return Message
     */
    public function setCategory($category)
    {
        if ($category !== null && !is_string($category))
            throw new \InvalidArgumentException('Category must be null or a string');
        $this->category = $category;
        return $this;
    }

    /**
     * Get Custom Data
     *
     * @return array|null
     */
    public function getCustom()
    {
        return $this->custom;
    }

    /**
     * Set Custom Data
     *
     * @param  array                      $custom
     * @return Message
     */
    public function setCustom(array $custom)
    {
        if (array_key_exists('aps', $custom))
            throw new \RuntimeException('custom data must not contain aps key as it is reserved by apple');
        $this->custom = $custom;
        return $this;
    }

    /**
     * Get Payload
     * Generate APN array.
     *
     * @return array
     */
    public function getPayload()
    {
        $message = array();
        $aps = array();
        if ($this->alert && ($alert = $this->alert->getPayload())) {
            $aps['alert'] = $alert;
        }
        if (!is_null($this->mutableContent)) {
            $aps['mutable-content'] = $this->mutableContent;
        }
        if (!is_null($this->badge)) {
            $aps['badge'] = $this->badge;
        }
        if (!is_null($this->sound)) {
            $aps['sound'] = $this->sound;
        }
        if (!is_null($this->contentAvailable)) {
            $aps['content-available'] = $this->contentAvailable;
        }
        if (!is_null($this->category)) {
            $aps['category'] = $this->category;
        }
        if (!empty($this->custom)) {
            $message = array_merge($this->custom, $message);
        }
        if (!empty($aps)) {
            $message['aps'] = $aps;
        }
        return $message;
    }

    /**
     * Get Payload JSON
     *
     * @return string
     */
    public function getPayloadJson()
    {
        $payload = json_encode($this->getPayload(), JSON_UNESCAPED_UNICODE);
        $length = strlen($payload);
        return pack('CNNnH*', 1, $this->id, $this->expire, 32, $this->token)
        . pack('n', $length)
        . $payload;
    }
}