<?php
/**
 * Created by PhpStorm.
 * User: qinqinfeng
 * Date: 2018/4/23
 * Time: 下午7:31
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class VoiceController{
    public function index(){
//        $file_list = glob("/Users/qinqinfeng/语文内测班语料范例中鼎/*.wav");
//        $n = 1;
//        foreach($file_list as $file){
//            if($n >= 306){
//                echo "今天次数到了上线了<br/>";
//            }
//            $filename = basename($file,".wav");
//            $rs = $this->voiceIat($file);
//            DB::table("voice")->insert([
//                'fanyi' => $filename,
//                'kedaxunfei' => $rs->data,
//            ]);
//            echo "保存成功--".$filename . "<br/>";
//            $n++;
//        }
        //=============================================
        $res = DB::select("select * from kc_voice");
        $x = $y = 0;
        foreach($res as $r){
            $kedaxunfei_hanzi = $kemeng_hanzi = [];
            preg_match_all("/[\x{4e00}-\x{9fa5}]/u" ,$r->fanyi,$matchs_fanyi);
            preg_match_all("/[\x{4e00}-\x{9fa5}]/u" ,$r->kedaxunfei,$matchs_kedaxunfei);
            preg_match_all("/[\x{4e00}-\x{9fa5}]/u" ,$r->kemeng,$matchs_kemeng);
            $n = 0;
            $m = 0;
            foreach($matchs_kedaxunfei[0] as $k=>$fval){
                if(in_array($fval, $matchs_fanyi[0])){
                    $n = $n+1;
                    $kedaxunfei_hanzi[] = $fval;
                }
            }
            foreach($matchs_kemeng[0] as $kk=>$ffval){
                if(in_array($ffval, $matchs_fanyi[0])){
                    $m = $m+1;
                    $kemeng_hanzi[] = $ffval;
                }
            }
            $kedaxunfei_rate = sprintf("%.2f",$n / count($matchs_fanyi[0]) * 100);
            if($kedaxunfei_rate == '100.00'){
                $x++;
            }

            $kedaxunfei_match_rs = "匹配".$n."个,".implode(',',$kedaxunfei_hanzi);
            $kemeng_rate = sprintf("%.2f",$m / count($matchs_fanyi[0]) * 100);
            if($kemeng_rate == '100.00'){
                $y++;
            }
            $kemeng_match_rs = "匹配".$m."个,".implode(',',$kemeng_hanzi);
            DB::update('update kc_voice set kedaxunfei_rate="'.$kedaxunfei_rate.'",kemeng_rate="'.$kemeng_rate.'",kedaxunfei_match_rs="'.$kedaxunfei_match_rs.'",kemeng_match_rs="'.$kemeng_match_rs.'" where id = ?', [$r->id]);
        }
        var_dump('科大讯飞匹配正确率:'.sprintf("%.2f",$x / 578), 'alilab匹配正确率:'.sprintf("%.2f",$y / 578));


//        //获取alilab中的翻译结果
//        $file1 = "/Users/qinqinfeng/result_语文内测班语料范例中鼎.csv";
//        $fp = fopen($file1, "r");
//        while(false !== $data=fgetcsv($fp)){
//            $filename_sufix = iconv("GBK", "UTF-8", $data[0]);
//            $data[1] = iconv("GBK", "UTF-8", $data[1]);
//            $filename = basename($filename_sufix, '.wav');
//            $sql = "select * from kc_voice where fanyi='".$filename."'";
//            $find_file_byfilename = DB::select($sql);
//            if(!empty($find_file_byfilename)){
//                $id = $find_file_byfilename[0]->id;
//                DB::update('update kc_voice set kemeng="'.$data[1].'" where id = ?', [$id]);
//            }
//        }
    }

    public function httpRequest($url, $data, $xparam){
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($curl,CURLOPT_HEADER,0);
        $appid = "5add7bba";
        $appkey = "33bf56758a8c6ee3908300a50fb27279";
        $curtime = time();
        $checkSum = md5($appkey.$curtime.$xparam.$data);

        $headers = array(
            'X-Appid:'. $appid,
            'X-CurTime:'. $curtime,
            'X-Param:' . $xparam,
            'X-CheckSum:' . $checkSum,
            'Content-Type:' . 'application/x-www-form-urlencoded;charset=utf-8'
        );

        curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
//        if(!empty($data)){
            curl_setopt($curl,CURLOPT_POST,1);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
//        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        dd($result);
        curl_close($curl);
        return $result;
    }

    public function getVoice($file){
        $path = base64_encode($file);
        $url = 'http://api.xfyun.cn/v1/aiui/v1/voice_semantic';
        $json_arr = array(
            "auf" => "16k",
            "aue" => "raw",
            "scene" => "main",
            "userid" => "user_0001",
            "spx_fsize" => "60"
        );
        $json = json_encode($json_arr);
        $xparam = base64_encode($json);
        $data = "data=" . $path;
        $res = $this->httpRequest($url, $data, $xparam);
        if(!empty($res) && $res['code'] == '00000'){
            echo json_encode(array('errcode'=>0,'msg'=>'识别成功','result'=>$res));
        }else{
            echo json_encode(array('errcode'=>111,'msg'=>'识别失败','result'=>$res));
        }

    }


    public function voiceIat($file_path){
        $param = [
            'engine_type' => 'sms16k',
            'aue' => 'raw'
        ];
        $appid = "5add7bba";
        $appkey = "33bf56758a8c6ee3908300a50fb27279";
        $curtime = time();
        $x_param = base64_encode(json_encode($param));
        $header_data = [
            'X-Appid:'.$appid,
            'X-CurTime:'.$curtime,
            'X-Param:'.$x_param,
            'X-CheckSum:'.md5($appkey.$curtime.$x_param),
            'Content-Type:application/x-www-form-urlencoded; charset=utf-8'
        ];
        //Body
        $file_path = $file_path;
        $file_content = file_get_contents($file_path);
        $body_data = 'audio='.urlencode(base64_encode($file_content));
        //Request
        $url = "http://api.xfyun.cn/v1/service/v1/iat";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body_data);
        $res = curl_exec($ch);
        curl_close($ch);
        $result = \GuzzleHttp\json_decode($res);
        if(!empty($result) && $result->code == '00000'){
            return $result;
        }else{
            return $result;
        }

    }

}