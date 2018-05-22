<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Model\Message;
use App\Model\Users;
use App\Model\Articles;
use App\Model\ArticlesDetail;


use App\Model\Webmaster;


class WebsiteController extends Controller
{
    //首页
    public function getIndex(Request $request)
    {
        if($_SERVER['SERVER_NAME']=='lhmob.cxmyq.com')
        {
            header("location: http://www.lhmob.cn".$_SERVER['REQUEST_URI']);die;
        }

        $data = Cache::remember('index_data', 60, function() {

            //公司动态
            $news = Articles::where('category_id', '=', '1')->where('state', '=', '1')->orderBy('id', 'desc')->paginate(10);

            $helps = Articles::where('category_id', '=', '2')->where('state', '=', '1')->orderBy('id', 'desc')->paginate(10);
            
            return [
                'title' => '网站首页',
                'group' => self::$group,
                'news' => $news,
                'helps' => $helps,
                
            ];
        });

        return view('website.index', $data);
    }

    //广告主
    public function getAdvert(Request $request)
    {
        if($_SERVER['SERVER_NAME']=='lhmob.cxmyq.com')
        {
            header("location: http://www.lhmob.cn".$_SERVER['REQUEST_URI']);die;
        }

        $data = [
            'title' => '广告主',
            'group'=>self::$group,
        ];
        return view('website.advert', $data);
    }

    //网站主
    public function getWeb(Request $request)
    {
        if($_SERVER['SERVER_NAME']=='lhmob.cxmyq.com')
        {
            header("location: http://www.lhmob.cn".$_SERVER['REQUEST_URI']);die;
        }

        $data = [
            'title'=>'网站主',
            'group'=>self::$group,
        ];
        return view('website.web', $data);
    }



    //公司动态
    public function getNewsDt(Request $request)
    {
        if($_SERVER['SERVER_NAME']=='lhmob.cxmyq.com')
        {
            header("location: http://www.lhmob.cn".$_SERVER['REQUEST_URI']);die;
        }
        

        $news = Articles::where('category_id', '=', '1')->where('state', '=', '1')->orderBy('id', 'desc')->paginate(15);

        $data = [
            'title'=>'公司动态',
            'group'=>self::$group,
            'news'=>$news,
        ];
        return view('website.newsdt', $data);
    }

    //行业资讯
    public function getNewsZx(Request $request)
    {
        if($_SERVER['SERVER_NAME']=='lhmob.cxmyq.com')
        {
            header("location: http://www.lhmob.cn".$_SERVER['REQUEST_URI']);die;
        }
            
        $news = Articles::where('category_id', '=', '2')->where('state', '=', '1')->orderBy('id', 'desc')->paginate(15);

        $data = [
            'title'=>'行业资讯',
            'group'=>self::$group,
            'news'=>$news,
        ];
        return view('website.newszx', $data);
    }

    //帮助中心
    public function getHelp(Request $request)
    {
        if($_SERVER['SERVER_NAME']=='lhmob.cxmyq.com')
        {
            header("location: http://www.lhmob.cn".$_SERVER['REQUEST_URI']);die;
        }

        $news = Articles::where('category_id', '=', '3')->where('state', '=', '1')->orderBy('id', 'desc')->paginate(15);

        $data = [
            'title'=>'行业资讯',
            'group'=>self::$group,
            'news'=>$news,
        ];
        return view('website.help', $data);
    }


    //新闻详情
    public function getNew(Request $request, $id)
    {
        if($_SERVER['SERVER_NAME']=='lhmob.cxmyq.com')
        {
            header("location: http://www.lhmob.cn".$_SERVER['REQUEST_URI']);die;
        }


        $article = Articles::where('id', '=', $id)->where('state', '=', '1')->first();

        if(!empty($article))
        {
            $detail = ArticlesDetail::where('article_id', '=', $article->id)->first();

            $article->content = $detail->content;
        }

        if($article->category_id=='1')
        {
            $title = '公司动态';
        }
        if($article->category_id=='2')
        {
            $title = '行业资讯';
        }
        if($article->category_id=='3')
        {
            $title = '常见问题';
        }
        

        $data = [
            'title'=>$title,
            'group'=>self::$group,
            'article'=>$article,
        ];
        return view('website.new', $data);
    }


    //协议
    public function getProtocol(Request $request)
    {
        if($_SERVER['SERVER_NAME']=='lhmob.cxmyq.com')
        {
            header("location: http://www.lhmob.cn".$_SERVER['REQUEST_URI']);die;
        }

        $data = [
            'title'=>'服务协议',
            'group'=>self::$group,
        ];
        return view('website.protocol', $data);
    }


    //登陆
    public function getLogin(Request $request, $type)
    {
        
        if($_SERVER['SERVER_NAME']!='lhmob.cxmyq.com')
        {
            header("location: http://lhmob.cxmyq.com".$_SERVER['REQUEST_URI']);die;
        }
            

        if($type!='web' && $type!='ad')
        {
            $user_id = $type;

            $user = Users::where('id', '=', $type)->first();

            if(!empty($user->department_id) && $user->department_id=='4')
                $type = 'ad';
            else
                $type = 'web';
        }
        
        $data = [
            'title' => '登陆',
            'type' => $type,
            'group' => self::$group,
        ];

        return view('website.login'.$type, $data);
    }

    //注册
    public function getRegister(Request $request, $type)
    {
        if($_SERVER['SERVER_NAME']!='lhmob.cxmyq.com')
        {
            header("location: http://lhmob.cxmyq.com".$_SERVER['REQUEST_URI']);die;
        }

        if($type!='web' && $type!='ad')
        {
            $user_id = $type;

            $user = Users::where('id', '=', $type)->first();

            if(!empty($user->department_id) && $user->department_id=='4')
                $type = 'ad';
            else
                $type = 'web';
        }
        else
        {
            $user_id = 0;
        }

        $data = [
            'title' => '注册',
            'user_id' => $user_id,
            'group' => self::$group,
        ];
        
        return view('website.register'.$type, $data);
    }


    public function getLoginAdmin(Request $request)
    {
        if($_SERVER['SERVER_NAME']!='lhmob.cxmyq.com')
        {
            header("location: http://lhmob.cxmyq.com".$_SERVER['REQUEST_URI']);die;
        } 

        $data = [
            'title' => '后台登陆',
            'group' => self::$group,
        ];
        
        return view('website.loginadmin', $data);
    }
    
}