<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\Users;
use App\Model\Message;

class ServiceController extends ApiController
{

    public function getEarnings(Request $request)
    {
        self::Admin();

    }
}
