<?php
namespace PhpApns\Message;

class Alert
{
    /**
     * Message Body
     * @var string|null
     */
    protected $body;
    /**
     * Action Locale Key
     * @var string|null
     */
    protected $actionLocKey;
    /**
     * Locale Key
     * @var string|null
     */
    protected $locKey;
    /**
     * Locale Arguments
     * @var array|null
     */
    protected $locArgs;
    /**
     * Launch Image
     * @var string|null
     */
    protected $launchImage;

    /**
     * Message Title
     * @var string|null
     */
    protected $title;

    /**
     * Title Locale Key
     * @var string|null
     */
    protected $titleLocKey;

    /**
     * Title Locale Arguments
     * @var array|null
     */
    protected $titleLocArgs;

    /**
     * Constructor
     *
     * @param  string $body
     * @param  string $actionLocKey
     * @param  string $locKey
     * @param  array  $locArgs
     * @param  string $launchImage
     * @return Alert
     */
    public function __construct($body = null, $actionLocKey = null, $locKey = null, $locArgs = null, $launchImage = null, $title = null, $titleLocKey = null, $titleLocArgs = null)
    {
        if ($body !== null) {
            $this->setBody($body);
        }
        if ($actionLocKey !== null) {
            $this->setActionLocKey($actionLocKey);
        }
        if ($locKey !== null) {
            $this->setLocKey($locKey);
        }
        if ($locArgs !== null) {
            $this->setLocArgs($locArgs);
        }
        if ($launchImage !== null) {
            $this->setLaunchImage($launchImage);
        }
        if ($title !== null) {
            $this->setTitle($title);
        }
        if ($titleLocKey !== null) {
            $this->setTitleLocKey($titleLocKey);
        }
        if ($titleLocArgs !== null) {
            $this->setTitleLocArgs($titleLocArgs);
        }
    }

    /**
     * Get Body
     *
     * @return string|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set Body
     *
     * @param  string|null $body
     * @return Alert
     */
    public function setBody($body)
    {
        if (!is_null($body) && !is_scalar($body))
            throw new \InvalidArgumentException('Body must be null OR a scalar value');
        $this->body = $body;
        return $this;
    }

    /**
     * Get Action Locale Key
     *
     * @return string|null
     */
    public function getActionLocKey()
    {
        return $this->actionLocKey;
    }

    /**
     * Set Action Locale Key
     *
     * @param  string|null $key
     * @return Alert
     */
    public function setActionLocKey($key)
    {
        if (!is_null($key) && !is_scalar($key))
            throw new \InvalidArgumentException('ActionLocKey must be null OR a scalar value');
        $this->actionLocKey = $key;
        return $this;
    }

    /**
     * Get Locale Key
     *
     * @return string|null
     */
    public function getLocKey()
    {
        return $this->locKey;
    }

    /**
     * Set Locale Key
     *
     * @param  string|null $key
     * @return Alert
     */
    public function setLocKey($key)
    {
        if (!is_null($key) && !is_scalar($key))
            throw new \InvalidArgumentException('LocKey must be null OR a scalar value');
        $this->locKey = $key;
        return $this;
    }

    /**
     * Get Locale Arguments
     *
     * @return array|null
     */
    public function getLocArgs()
    {
        return $this->locArgs;
    }

    /**
     * Set Locale Arguments
     *
     * @param  array $args
     * @return Alert
     */
    public function setLocArgs(array $args)
    {
        foreach ($args as $a) {
            if (!is_scalar($a)) {
                throw new \InvalidArgumentException('Arguments must only contain scalar values');
            }
        }
        $this->locArgs = $args;
        return $this;
    }

    /**
     * Get Launch Image
     *
     * @return string|null
     */
    public function getLaunchImage()
    {
        return $this->launchImage;
    }

    /**
     * Set Launch Image
     *
     * @param  string|null $image
     * @return Alert
     */
    public function setLaunchImage($image)
    {
        if (!is_null($image) && !is_scalar($image))
            throw new \InvalidArgumentException('Launch image must be null OR a scalar value');
        $this->launchImage =  $image;
        return $this;
    }

    /**
     * Get Title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set Title
     *
     * @param  string|null $title
     * @return Alert
     */
    public function setTitle($title)
    {
        if (!is_null($title) && !is_scalar($title))
            throw new \InvalidArgumentException('Title must be null OR a scalar value');
        $this->title = $title;
        return $this;
    }

    /**
     * Get Title Locale Key
     *
     * @return string|null
     */
    public function getTitleLocKey()
    {
        return $this->titleLocKey;
    }

    /**
     * Set Title Locale Key
     *
     * @param  string|null $key
     * @return Alert
     */
    public function setTitleLocKey($key)
    {
        if (!is_null($key) && !is_scalar($key))
            throw new \InvalidArgumentException('TitleLocKey must be null OR a scalar value');
        $this->titleLocKey = $key;
        return $this;
    }

    /**
     * Get Title Locale Arguments
     *
     * @return array|null
     */
    public function getTitleLocArgs()
    {
        return $this->titleLocArgs;
    }

    /**
     * Set Title Locale Arguments
     *
     * @param  array $args
     * @return Alert
     */
    public function setTitleLocArgs(array $args)
    {
        foreach ($args as $a) {
            if (!is_scalar($a)) {
                throw new \InvalidArgumentException('Title Arguments must only contain scalar values');
            }
        }
        $this->titleLocArgs = $args;
        return $this;
    }

    /**
     * To Payload
     * Formats an APS alert.
     *
     * @return array|string
     */
    public function getPayload()
    {
        $vars = get_object_vars($this);
        if (empty($vars)) {
            return null;
        }
        $alert = array();
        foreach ($vars as $key => $value) {
            if (!is_null($value)) {
                $key = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $key));
                $alert[$key] = $value;
            }
        }
        if (count($alert) === 1) {
            return $this->getBody();
        }
        return $alert;
    }
}