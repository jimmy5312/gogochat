<?php

namespace GogoChat\Traits;
use GogoChat\ChatRoom;

/**
 * Add this Trait to any Model so that a new 
 * GogoChat\Member instance can be created from the
 * model
 */
Trait IsChatMember {
    /**
     * Need to return an array to tell how to map
     * properties of this Model into properties of
     * GogoChat\Member
     * 
     * Can be simple property name, or Closure. 
     * If using Closure, $this will be passed in as $model
     * [
     *      'uid'    => 'id',
     *      'name'   => function($model) {return $model->full_name()},
     *      'avatar' => 'id',
     * ]
     *
     * @return void
     */
    abstract function chatMemberOptions();
}