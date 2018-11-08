<?php
/**
 * Created by PhpStorm.
 * User: gifary
 * Date: 11/6/18
 * Time: 12:42 PM
 */

namespace App\Models;


class Contact extends BaseModel
{
    public function member()
    {
        return $this->belongsToMany(Member::class);
    }
}
