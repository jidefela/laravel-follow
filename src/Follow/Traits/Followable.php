<?php namespace Fela\Follow\Traits;


use Fela\Follow\Exceptions\AlreadyFollowingException;
use Fela\Follow\Exceptions\FollowerNotFoundException;
use Fela\Follow\Models\Follower;


trait Followable
{

    private $follower_type;

    private $follower_id;


    /**
     * Follow a Member
     * @param $following_type
     * @param $following_id
     * @return null|static
     * @throws AlreadyFollowingException
     */
    public function follow($following_type, $following_id)
    {

        //Check if already following the user
        $isFollowing = $this->isFollowing($following_type, $following_id);

        if ($isFollowing !== false) {
            throw new AlreadyFollowingException('This user is already following the ' . $following_type);
        }

        $follow = Follower::create([
            'follower_id' => $this->id,
            'follower_type' => get_class($this),
            'followed_id' => $following_id,
            'followed_type' => config('follow.' . $following_type)
        ]);
        if ($follow) {
            return $follow;
        }
        return null;
    }


    /**
     * Unfollow a Member
     * @param $following_type
     * @param $following_id
     * @return string
     * @throws FollowerNotFoundException
     */
    public function unfollow($following_type, $following_id)
    {
        //Checks if the user is being followed
        $following = $this->isFollowing($following_type, $following_id);

        if (!$following) {
            throw new FollowerNotFoundException('Cannot Unfollow User, Not Following !');
        }

        $follow = $this->getFollow($following_type, $following_id);
        Follower::destroy($follow->id);
        return "User Unfollowed";
    }


    /**
     * Get a Follow
     * @param $following_type
     * @param $following_id
     * @return bool
     */

    public function getFollow($following_type, $following_id)
    {
        $follow = $this->followed
            ->where('followed_id', $following_id)
            ->where('followed_type', config('follow.' . $following_type))
            ->first();
        if (is_null($follow)) {
            return [];
        }
        return $follow;
    }


    /**
     * Checks if the current Member follows a user
     * @param $following_type
     * @param $following_id
     * @return bool
     */

    public function isFollowing($following_type, $following_id)
    {
        $following = $this->followed
            ->where('followed_id', $following_id)
            ->where('followed_type', config('follow.' . $following_type))
            ->first();
        if (is_null($following)) {
            return false;
        }
        return true;
    }


    /**
     * Checks if the current Member is Followed by a user
     * @param $follower_type
     * @param $follower_id
     * @return bool
     */
    public function isFollowedBy($follower_type, $follower_id)
    {
        $following_by = $this->followers
            ->where('follower_id', $follower_id)
            ->where('follower_type', config('follow.' . $follower_type))
            ->first();
        if (is_null($following_by)) {
            return false;
        }
        return true;
    }


    /**
     * Lists all followers of the current user by Member
     * @return mixed
     */
    public function getFollowers()
    {
        $followers = array();
        if ($this->followers->count() > 0) {
            foreach ($this->followers as $follower) {
                $class = $follower->follower_type;
                $object = new $class();
                array_push($followers, $object->find($follower->follower_id));
            }
        }
        return $followers;
    }


    /**
     * Lists all followings of the current user by Member
     * @return mixed
     */
    public function getFollowing()
    {
        $following = array();
        if ($this->followed->count() > 0) {
            foreach ($this->followed as $followed) {
                $class = $followed->followed_type;
                $object = new $class();
                array_push($following, $object->find($followed->followed_id));
            }
        }
        return $following;
    }


    /**
     * Get a followed Member from a following
     * @param $follow
     * @return mixed
     */
    public function getFollowed($follow)
    {
        $class = $follow->followed_type;
        $object = new $class();
        $following = $object->find($follow->followed_id);
        return $following;
    }

    /**
     * Get a follower Member from a following
     * @param $follow
     * @return mixed
     */
    public function getFollower($follow)
    {
        $class = $follow->follower_type;
        $object = new $class();
        $follower = $object->find($follow->follower_id);
        return $follower;
    }

    /**
     *  Set the current follower model attribute
     */
    public function setFollower()
    {
        $this->follower_type = get_class($this);
        $this->follower_id = $this->id;
    }

    /**
     * Number of followers
     * @return mixed
     */
    public function followers_count()
    {
        return $this->followers->count();
    }
    
    /**
     * Number of followed
     * @return mixed
     */
    public function followed_count()
    {
        return $this->followed->count();
    }

   


}