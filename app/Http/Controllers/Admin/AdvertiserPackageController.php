<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\MatterPackage;

class AdvertiserPackageController extends ApiController
{

    public function getPackages(Request $request)
    {
        self::Admin();

        //网站搜索
        $name = trim($request->input('name'));
        $adstype_id = trim($request->input('adstype_id'));
        $advertiser_id = trim($request->input('advertiser_id'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $packages = MatterPackage::where('id', '<>', '0');

        if(!empty($name))
            $packages = $packages->where('name', 'like', '%'.$name.'%');

        if(!empty($adstype_id))
            $packages = $packages->where('adstype_id', '=', $adstype_id);

        if(!empty($advertiser_id))
            $packages = $packages->where('advertiser_id', '=', $advertiser_id);

        $count = $packages->count();
        $packages = $packages->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();


        foreach($packages as $key=>$val)
        {
            $packages[$key]->picture1 = json_decode($val->picture1, true);
            $packages[$key]->picture2 = json_decode($val->picture2, true);
            $packages[$key]->picture3 = json_decode($val->picture3, true);
        }

        $data = [
            'count'=>$count,
            'packages'=>$packages,
        ];
        
        return response()->json(['data'=>$data], 200);
    }

    public function getPackage(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);
        
        $package = MatterPackage::where('id', '=', $id)->first();

        if(empty($package))
            return response()->json(['message'=>'未找到数据'], 300);

        $package->picture1 = json_decode($package->picture1, true);
        $package->picture2 = json_decode($package->picture2, true);
        $package->picture3 = json_decode($package->picture3, true);

        return response()->json(['data'=>['package'=>$package]], 200);
    }

    public function putPackage(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);
        
        $package = MatterPackage::where('id', '=', $id)->first();

        if(empty($package))
            return response()->json(['message'=>'未找到数据'], 300);
        
        $present = $request->input();

        if(!empty($present['name'])){ $package->name = $present['name']; }
        if(!empty($present['adstype_id'])){ $package->adstype_id = $present['adstype_id']; }
        if(!empty($present['advertiser_id'])){ $package->advertiser_id = $present['advertiser_id']; }
        if($present['adstype_id']=='11')
        {
            $result = $this->validationImg($present['picture1'] ,640 ,200);
            if($result['status']==false){ return response()->json(['message'=>$result['msg']], 300); }else{
                $package->picture1 = json_encode($present['picture1'], true);}
            
            $result = $this->validationImg($present['picture2'] ,640 ,150);
            if($result['status']==false){ return response()->json(['message'=>$result['msg']], 300); }else{
                $package->picture2 = json_encode($present['picture2'], true); }
            
            $result = $this->validationImg($present['picture3'] ,640 ,100);
            if($result['status']==false){ return response()->json(['message'=>$result['msg']], 300); }else{ 
                $package->picture3 = json_encode($present['picture3'], true); }
        }

        if($package->save())
        {
            return response()->json(['message'=>'修改成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'修改失败'], 300);
        }
    }

    public function postPackage(Request $request)
    {
        self::Admin();

        $present = $request->input();

        if(empty($present['name']))
            return response()->json(['message'=>'请填写素材名称'], 300);

        if(empty($present['adstype_id']))
            return response()->json(['message'=>'请选择广告类型'], 300);
        
        if(empty($present['advertiser_id']))
            return response()->json(['message'=>'请输入广告主ID'], 300);

        if(count($present['picture1'])<1 || count($present['picture1'])>4)
            return response()->json(['message'=>'请选择第一个素材，至少一张，最多四张'], 300);

        if(count($present['picture2'])<1 || count($present['picture2'])>4)
            return response()->json(['message'=>'请选择第二个素材，至少一张，最多四张'], 300);

        if(count($present['picture3'])<1 || count($present['picture3'])>4)
            return response()->json(['message'=>'请选择第三个素材，至少一张，最多四张'], 300);

        //横幅广告
        if($present['adstype_id']=='11')
        {
            //横幅图片1 640*200
            $result = $this->validationImg($present['picture1'] ,640 ,200);
            if($result['status']==false)
                return response()->json(['message'=>$result['msg']], 300);

            $result = $this->validationImg($present['picture2'] ,640 ,150);
            if($result['status']==false)
                return response()->json(['message'=>$result['msg']], 300);

            $result = $this->validationImg($present['picture3'] ,640 ,100);
            if($result['status']==false)
                return response()->json(['message'=>$result['msg']], 300);
        }

        $package = new MatterPackage();
        $package->name = $present['name'];
        $package->advertiser_id = $present['advertiser_id'];
        $package->adstype_id = $present['adstype_id'];
        $package->state = $present['state'];
        $package->picture1 = json_encode($present['picture1'], true);
        $package->picture2 = json_encode($present['picture2'], true);
        $package->picture3 = json_encode($present['picture3'], true);

        if($package->save())
        {
            return response()->json(['message'=>'添加成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'添加失败'], 300);
        }
    }


    // 验证图片
    public function validationImg($imgInfo, $width, $height)
    {
        if(count($imgInfo) < 1 || count($imgInfo) > 4)
        {
            return ['status'=>false, 'msg'=>'上传数量至少一张，最多4张'];
        }

        $picture = [];

        foreach($imgInfo as $key=>$val)
        {
            if($val['width'] != $width || $val['height']!=$height)
            {
                return ['status'=>false, 'msg'=>'选择的图片尺寸不对'];
            }
            else
            {
                $picture[] = [
                    'path' => $val['path'],
                    'width' => $val['width'],
                    'height' => $val['height'],
                    'size' => $val['size'],
                ];
            }
        }

        return ['status'=>true, 'json'=>json_encode($picture, true)];
    }
}
