<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\AllianceFlux;
use App\Model\AllianceFluxExpendHour;
use App\Model\AllianceFluxExpendDay;

use Hash;

class AllianceFluxExpendController extends ApiController
{

    public function getExpendsDay(Request $request)
    {
        self::Admin();

        //网站杜索
        $alliance_flux_id = trim($request->input('alliance_flux_id'));
        $adstype_id = trim($request->input('adstype_id'));
        $date = trim($request->input('date'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $expends = AllianceFluxExpendDay::where('id', '<>', '0');

        if(!empty($alliance_flux_id))
            $expends = $expends->where('alliance_flux_id', '=', $alliance_flux_id);

        if(!empty($adstype_id))
            $expends = $expends->where('adstype_id', '=', $adstype_id);
        
        if(!empty($date))
            $expends = $expends->where('date', '=', $date);

        $count = $expends->count();
        $expends = $expends->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'expends'=>$expends,
        ];

        return response()->json(['data'=>$data], 200);
    }

    public function getExpendsHour(Request $request)
    {
        self::Admin();

        //网站杜索
        $alliance_flux_id = trim($request->input('alliance_flux_id'));
        $date = trim($request->input('date'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $expends = AllianceFluxExpendHour::where('id', '<>', '0');

        if(!empty($alliance_flux_id))
            $expends = $expends->where('alliance_flux_id', '=', $alliance_flux_id);
        
        if(!empty($date))
        {
            $expends = $expends->where('time', '>=', $date.' 00:00:00');
            $expends = $expends->where('time', '<=', $date.' 23:59:59');
        }
            

        $count = $expends->count();
        $expends = $expends->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'expends'=>$expends,
        ];

        return response()->json(['data'=>$data], 200);
    }

}