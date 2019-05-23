# gogochat-php
PHP Laravel SDK to use GoGo Empire Chat

Installation
===========
1. ```composer require gogochat/laravel-sdk:dev-master```
2. At .env, add ```CHAT_APP_SECRET=your-app-secret-string```
3. At config/app.php, add 
  ```'chat_app_secret' => env('CHAT_APP_SECRET', null)```



Usage
=====
Assuming you have a Job model that requires chat between employer and employee for the job

Job.php
```
use Illuminate\Database\Eloquent\Model;
use GogoChat\Traits\HasChatRoom;
use GogoChat\Member;

class Job extends Model {
    use HasChatRoom;

    // Override this abstract method to return name of the chat room
    function getChatRoomName() {
        return "Job #{$this->id}";
    }
    
    // Override this to return the members of the chat room
    function getChatRoomMembers() {
    
        // You can manually create the Member object
        $boss = $this->employer;
        $employer = new Member([
          'uid' => $boss->id,
          'name' => $boss->name,
          'avatar' => $boss->profile_pic,
        ]);
        
        
        // Or use the trait GogoChat\Traits\IsChatMember to auto
        // extract the information.
        // $this->employee is a Model has the trait GogoChat\Traits\IsChatMember
        $employee = new Member($this->employee);
        
        // Can override the property if needed
        $employee->name = "The Cleaner";
        
        return [$employer, $employee];
    }
}
```

Employee.php

```

use GogoChat\Traits\IsChatMember;

class Employee extends Model {
    use IsChatMember;
    /**
     * This function to tell how to convert \App\Employee 
     * into \GogoChat\Member
     *
     * @return array
     */
    function chatMemberOptions() {
        return [
            // Translated into $member->uid = $this->uid
            'uid'   => 'auto_id',
            
            // Translated into $member->name = 'Typist'
            'name'  => function() {
                return 'Typist';
            },
            
            // Dynamically get the avatar image
            'avatar'=> function() {
                if ($this->img_thumbnail) {
                    return BASE_THUMBNAIL_PATH . $this->img_thumbnail;
                }
                else if ($this->img) {
                    return BASE_IMG_PATH . $this->img;
                }
                return null;
            }
        ];
    }
}
```

When you need to get the ChatRoom properties,

```
  $job = Job::find(1);
  $chatRoom = $job->chat_room; 
```
