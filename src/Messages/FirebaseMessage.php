<?php

namespace DouglasResende\FCM\Messages;

/**
 * Class FirebaseMessage
 * @package DouglasResende\FCM\Messages
 */
class FirebaseMessage
{
    /**
     * @var null
     */
    private $to = null;
    /**
     * @var null
     */
    private $notification = null;
    /**
     * @var null
     */
    private $data = null;
    
    /**
     *
     * @var string  
     */
    private $apiKey = '';

    /**
     * @param $topic
     * @return $this|null
     */
    public function toTopic($topic)
    {
        if (is_array($topic)) {
            return null;
        } else {
            $this->to = '/topics/' . $topic;
        }

        return $this;
    }

    /**
     * @param $title
     * @param $body
     * @return $this
     */
    public function setContent($title, $body)
    {
        $this->notification = compact('title', 'body');

        return $this;
    }

    /**
     * @param null $payload
     * @return $this
     */
    public function setMeta($payload = null)
    {
        $this->data = $payload;

        return $this;
    }
    
    /**
     * Device token to send the message to, or pass an array of tokens to send to multiple device tokens.
     * @param mixed $device_token
     * @return $this
     */
    public function setTo($device_token = null)
    {
        $this->to = $device_token;

        return $this;
    }
    
    /**
     * Send this message via the specified API key.
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey($apiKey = '')
    {
        $this->apiKey = $apiKey;

        return $this;
    }
    
    /**
     * Get the API key for this message (if any)
     * @return string
     */
    public function getApiKey() {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        if (!is_array($this->to)) {
            $filtered = array_filter([
                'to' => $this->to,
                'notification' => $this->notification,
                'data' => $this->data,
            ]);
        } else {
            $filtered = array_filter([
                'registration_ids' => $this->to,
                'notification' => $this->notification,
                'data' => $this->data,
            ]);
        }

        return json_encode($filtered);
    }
}