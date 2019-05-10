<?php

namespace GogoChat\Traits;
use GogoChat\ChatRoom;
Trait HasChatRoom {
    /**
     * Return the name of the chat room, nullable
     * @return string
     */
    abstract function getChatRoomName();
    function getChatRoomAttribute() {
        // Load the chat room from server
        $rood_id = $this->getKey();

        $a = new \GogoChat\ChatRoom(['room_id' => $this->getKey(), 'room_name' => $this->getChatRoomName()]);
        $a->members = $this->getChatRoomMembers();

        // API will create room is not exist,
        // update if already exist, then return 
        // the room details
        $a = $a->create();
        return $a;
    }

    /**
     * Need to implement this function to return
     * the members of the chat room. If need a empty
     * chat room and later only add member, return
     * empty array.
     * 
     * Example:
     * 
     * function getChatRoomMembers() {
     *  return [
     *      new \GogoChat\Member([
     *          "uid" => 100, 
     *          "name" => "User 100",
     *          "avatar" => "http://image-url.com/avatar"
     *      ]),
     *      new \GogoChat\Member([
     *          "uid" => 102, 
     *          "name" => "Driver 102",
     *          "avatar" => "http://image-url.com/another-avatar"
     *      ]),
     *  ]
     * }
     * 
     *
     * @return void
     */
    abstract function getChatRoomMembers();
}