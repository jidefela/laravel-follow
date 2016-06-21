<?php namespace Fela\Follow\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{

    protected $table = "followers";

    protected $fillable = [

        'follower_id',
        'follower_type',
        'followed_id',
        'followed_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'follower_id' => 'int',
        'followed_id' => 'int'
    ];

    /**
     *
     * @return mixed
     */
    public function followers()
    {
        return $this->morphTo();
    }


    /**
     * @return mixed
     */
    public function followed()
    {
        return $this->morphTo();
    }

}