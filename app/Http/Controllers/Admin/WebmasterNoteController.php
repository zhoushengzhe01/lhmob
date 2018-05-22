<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\Webmaster;
use App\Model\WebmasterNote;

class WebmasterNoteController extends ApiController
{

    public function getWebmasterNotes(Request $request, $webmaster_id)
    {
        self::Admin();

        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        if(empty($webmaster_id))
            return response()->json(['message'=>'缺少参数'], 400);

        $notes = WebmasterNote::where('webmaster_id', '=', $webmaster_id);

        $count = $notes->count();
        $notes = $notes->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'notes'=>$notes,
        ];

        return response()->json(['data'=>$data], 200);
    }

    public function postWebmasterNote(Request $request, $webmaster_id)
    {
        self::Admin();

        if(empty($webmaster_id))
            return response()->json(['message'=>'缺少参数'], 400);
        
        $present = $request->input();
        
        if(empty($present['note']))
        {
            return response()->json(['message'=>'输入备注内容'], 300);
        }
        
        $note = new WebmasterNote;
        $note->webmaster_id = $webmaster_id;
        $note->userid = self::$user->id;
        $note->username = self::$user->username;
        $note->note = $present['note'];

        if($note->save())
        {
            return response()->json(['message'=>'备注成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'备注失败'], 300);
        }

    }
}
