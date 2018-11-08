<?php
/**
 * Created by PhpStorm.
 * User: gifary
 * Date: 11/6/18
 * Time: 12:51 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Package;

class PackageApiController extends Controller
{
    public function index()
    {
        $package = Package::all();

        return $this->sendResponse($package,'success',200);
    }
}
