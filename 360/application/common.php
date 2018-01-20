<?php
use think\Config;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;
use think\Url;
use think\View as ViewTemplate;

date_default_timezone_set('PRC');
define('YEAR_START', mktime(0,0,0,1,1));
 
\think\Db::execute("set sql_mode=''");

class my{
    static function valid($valid, $data) {
        if (strpos($valid, '.')) {
            list($valid, $scene) = explode('.', $valid);
        }else{
            $scene = false;
        }
        $validate = validate($valid);

        if ($scene) $validate->scene($scene);

        if (!$validate->batch()->check($data)) {
            $isAjax = Request::instance()->isAjax();
            if ($isAjax) {
                self::error('valid', '', $validate->getError());
            }else{
                self::error(join('、', $validate->getError()));
            }
        }
    }
    // 将 select data 的值，转换成文字。
    static function selectText($selectName, $value, $join='，') {
        $arr = config('select_data.'.$selectName);

        if (is_array($value)) {
            $ret = [];
            foreach ($value as $v) {
                $ret[$v] = $arr[$v];
            }
            return implode($join, $ret);
        }else{
            return $arr[$value];
        }
    }
    static function option($arr) {
        $ret = '';//'<option value=""></option>';
        foreach ($arr as $k=>$v) {
            $ret .= "<option value=\"{$k}\">$v</option>";
        }
        return $ret;
    }
    static function option_article($arr) {
        $ret = '';//'<option value=""></option>';
        foreach ($arr as $k=>$v) {
            $ret .= "<option value=\"{$k}\">$v</option>";
        }
        return $ret;
    }
    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param mixed     $msg 提示信息
     * @param string    $url 跳转的URL地址
     * @param mixed     $data 返回的数据
     * @return void
     */
    static function error($msg='', $url='', $data='', $httpCode=400)
    {
        $code = 0;
        if (is_numeric($msg)) {
            $code = $msg;
            $msg  = '';
        }

        $isAjax = Request::instance()->isAjax();

        if ($url==='' and !$isAjax) {
            $url = 'javascript:history.back(-1);';
        } elseif ('' !== $url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : Url::build($url);
        }

        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => 3,
        ];

        $type = $isAjax ? Config::get('default_ajax_return') : Config::get('default_return_type');

        if ('html' == strtolower($type)) {
            $result = ViewTemplate::instance(Config::get('template'), Config::get('view_replace_str'))
                ->fetch(Config::get('dispatch_error_tmpl'), $result);
        }
        $response = Response::create($result, $type, $httpCode);
        throw new HttpResponseException($response);
    }

    /** 条件参数编码
     * @param $where
     * @return string
     */
    static public function encodeParam($where){
//        return urlencode(json_encode($where));
        return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode(json_encode($where)));
    }

    /**条件参数解码
     * @param $where
     * @return mixed
     */
    static public function decodeParam($where){
//        return json_decode(urldecode($where),true);
        $data = str_replace(array('-', '_'), array('+', '/'), $where);
        $mod4 = strlen($data) % 4;
        ($mod4) && $data .= substr('====', $mod4);
        return json_decode(base64_decode($data),true);
    }

    static function dtFmt($t) {
        if(!$t) {
            return '';
        }
        $fmt = $t<YEAR_START ? 'Y-n-j H:i' : 'n-j H:i';
        return date($fmt, $t);
    }

    static function orderBy($field) {
        $get = input('get.');
        $order = $get['order'];
        $by = $get['by'];

        if ($by!=$field) {
            $sign = '▷';
            $get['by'] = $field;
            $get['order'] = 'desc';
        }elseif($order=='desc'){
            $sign = '▼';
            $get['by'] = $field;
            $get['order'] = 'asc';
        }else{
            $sign = '▲';
            unset($get['by'], $get['order']);
        }
        return [
            'sign' => $sign,
            'url' => '?'.http_build_query($get, '', '&amp;'),
        ];
    }

    /**
     * @param $data 数据
     * @param $kv  键值名称  例如：['title'=>'标题','name'=>'名称']
     * @param $filename 文件名
     */
    static public function exportExcel($data,$kv,$filename='数据'){
        $html = '<table  border="1"><tr>';
        foreach ($kv as $v) {
            $html .= '<th>'. $v .'</th>';
        }
        $html .= '</tr>';

        $keys = array_keys($kv);

        foreach ($data as $d) {
            $html .= '<tr align="center">';
            foreach ($keys as $k) {
                $html .= '<td >'. $d[$k] .'</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</table>';

        header('Cache-Control: public, must-revalidate, max-age=0'); //IE加上这句
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
        header("Content-Length: " . strlen($html));

        echo $html;
    }
    //后台权限
    static function auth($auth,$is_err=true){
        return \app\admin\model\User::authCheck($auth,$is_err);
    }
    //前台权限
    static function m_auth($auth,$is_err=true){
        return \app\member\model\Member::authCheck($auth,$is_err);
    }

    static function record($obj,$obj_id,$action,$shop_id='',$user_id=''){
        \app\admin\model\Record::writeLog($obj,$obj_id,$action,$shop_id,$user_id);
    }
    //公里数
    static function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){
        $EARTH_RADIUS = 6370.996; // 鍦扮悆鍗婂緞绯绘暟
        $PI = 3.1415926;
        $radLat1 = $latitude1 * $PI / 180.0;
        $radLat2 = $latitude2 * $PI / 180.0;
        $radLng1 = $longitude1 * $PI / 180.0;
        $radLng2 = $longitude2 * $PI /180.0;
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
        $distance = $distance * $EARTH_RADIUS * 1000;
        if($unit==2){
            $distance = $distance / 1000;
        }
        return round($distance, $decimal);
    }
    //微信http_CURL
    static function http_curl($url,$data=null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
    //网站基础信息
    static function seo($id){
        $id=$id ?:'1';
        $seo= \app\admin\model\System::get($id);
        return $seo;
    }
  
 
    
}

class cate{
    static public function peer($cate,$html = '　',$pid=0,$level=0){
        $arr =array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                $v['level'] = $level + 1;
                $v['html'] = str_repeat($html, $level);
                $arr[] = $v;
                $arr = array_merge($arr,self::peer($cate,$html,$v['id'],$level+1));
            }
        }
        return $arr;
    }

    static public function option($data){
        $html = '';
        foreach ($data as $v) {
            $html .= '<option value="' .$v['id']. '">' .$v['html'].$v['title']. '</option>';
        }
        return $html;
    }
    static public function option_article($data){
        $html = '';
        foreach ($data as $v) {
            $html .= '<option value="' .$v['id']. '">' .$v['html'].$v['title']. '</option>';
        }
        return $html;
    }
}