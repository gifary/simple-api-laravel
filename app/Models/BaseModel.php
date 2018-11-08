<?php
/**
 * Created by PhpStorm.
 * User: gifary
 * Date: 11/6/18
 * Time: 12:38 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $guarded =['_token','id'];
}
