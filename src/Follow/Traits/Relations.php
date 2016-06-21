<?php namespace Fela\Follow\Traits;

use Fela\Follow\Models\Follower;

trait Relations
{

    /**
     * Lists all followers of the current Member
     * @return mixed
     */
    public function followers()
    {
        return $this->morphMany(Follower::class, 'followers', 'followed_type', 'followed_id');
    }

    /**
     * Lists all followed Users by the current Member
     * @return mixed
     */
    public function followed()
    {
        return $this->morphMany(Follower::class, 'followers', 'follower_type', 'follower_id');
    }
}