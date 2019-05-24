<?php

namespace GogoChat;


class ChatRoom extends BaseObject {
    
    /**
     * Display name of the room
     * @var string
     */
    var $room_name = null;

    /**
     * Unique key to identify the room
     * @var string
     */
    var $room_id = null;

    /**
     * Array of \GogoChat\Member
     * @var array
     */
    var $members = [];

    var $firebase_room_key = null;
    function __construct($data = []) {
        parent::__construct($data);

        if ($this->members) {
            if (is_array($this->members)) {
                $members = [];
                foreach ($this->members as $memberData) {
                    $members[] = new Member($memberData);
                }
                $this->members = $members;
            }
            else {
                $this->members = [];
            }
        }
    }

    static function find($roomId) {

    }

    function validateParameters() {
        if ($this->members) {
            foreach ($this->members as $member) {
                if (!$member->uid) {
                    throw new \Exception("Member need to have 'uid' to join a room.");
                }
            }
        }
    }

    function create() {
        $this->validateParameters();
        $client = new Http\Client;
        try {
            $response = $client->postJSON('/rooms/create_room',$this);
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                $body = $response->getBody();
                $data = json_decode($body, true);
                $chatRoom = new ChatRoom($data);
                return $chatRoom;
            }
        }
        catch (Exception\ChatRoomException $e) {
            throw new \Exception("Unable to create new room.");
        }
        return "Room not created";
    }
}