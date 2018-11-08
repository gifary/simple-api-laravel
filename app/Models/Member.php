<?php
/**
 * Created by PhpStorm.
 * User: gifary
 * Date: 11/6/18
 * Time: 12:38 PM
 */

namespace App\Models;


use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends BaseModel
{
    use UuidTrait;
    use SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function setIsMemberAnotherVCDRentalAttribute($value)
    {
        if(strtolower($value)=='no'){
            $this->attributes['is_member_another_vcd_rental'] = false;
        }else{
            $this->attributes['is_member_another_vcd_rental'] = true;
        }
    }

    public function setPackageIdAttribute($value)
    {
        if(is_numeric($value)){
            $this->attributes['package_id'] = $value;
        }else{
            $package = Package::where('name',$value)->first();
            $this->attributes['package_id'] = $package->id;
        }
    }

    public function addContact($contact)
    {
        if(is_string($contact))
        {
            $contact = Contact::where('phone_number',$contact)->first();
        }

        return $this->contacts()->attach($contact);
    }
}
