<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\WebmasterMoneyLog;

class WebmasterMoneyController extends ApiController
{

    public function getWebmasterMoneys(Request $request)
    {
        self::Admin();

        //网站杜索
        $webmaster_id = trim($request->input('webmaster_id'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $moneylogs = WebmasterMoneyLog::where('id', '<>', '0');

        if(!empty($webmaster_id))
            $moneylogs = $moneylogs->where('webmaster_id', '=', $webmaster_id);

        $count = $moneylogs->count();
        $moneylogs = $moneylogs->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'moneylogs'=>$moneylogs,
        ];

        return response()->json(['data'=>$data], 200);
    }
}
