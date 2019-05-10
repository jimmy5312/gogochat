<?php

namespace GogoChat;

class Member extends BaseObject {
    /**
     * The unique ID to identity the user
     * @var string
     */
    var $uid;

    /**
     * The display name of this user in the chatroom
     * @var string
     */
    var $name;

    /**
     * Url of avatar image
     * @var string
     */
    var $avatar;

    /**
     * Url to launch chat interface and chat as this user.
     * Example format:
     * https://chat.gogoempire.asia/chat/?data=<random-string>
     * @var string
     */
    var $chat_url;

    function __construct($data = []) {
        if ($data) {
            if (is_array($data)) {
                parent::__construct($data);
                return;
            }
            if (is_object($data)) {
                $this->initWithObject($data);
            }
        }
    }

    function initWithObject($data) {
        $a = class_uses($data);
        if (isset($a['GogoChat\Traits\IsChatMember'])) {
            $options = $data->chatMemberOptions();
            if (!isset($options['uid'])) {
                throw new \Exception("chatMemberOptions() must return array containing 'uid'");
            }
            foreach ($options as $key => $value) {
                $model = $data;
                if (is_string($value)) {
                    // Read simple property
                    $this->$key = $model->$value;
                }
                else if ($this->isClosure($value)) {
                    // Obtain value by executing Closure
                    $this->$key = $value();
                }
            }
        }
    }

    function isClosure($t) {
        $result = is_object($t) && ($t instanceof \Closure);
        return $result;
    }
}