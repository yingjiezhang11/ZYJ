<?php
namespace app\common\traits;

use think\Request;
load_trait('controller/Jump');
trait SiteTrait{
    use \traits\controller\Jump;

    /*
     * 添加、编辑
     * @field 提交的合法字段
     */
    public function baseEdit($field=true,$validate=true,$url = ''){
        $request = Request::instance();
        $className = $request->controller();

        $model = 'app\member\model\\'.$className;
        $model = new $model;

        $id = $request->param('id/d');

        if ($request->isPost()){
            $post = $request->post();

            if ($validate)
                \my::valid($className,$post);

            if ($id){
                $ret = $model->allowField($field)->save($post,['id'=>$id,'shop_id'=>SHOP_ID]);
            }else{
                $post['shop_id'] = SHOP_ID;
                $ret = $model->allowField($field)->save($post);
            }

            if(!$ret)
                \my::error('操作失败');

            $url = $url ?: $className.'/index';
            $this->success('操作成功',url($url));

        }

        if ($id){
            $one = $model->where(['id'=>$id,'shop_id'=>SHOP_ID])->find();
        }

        return $one ? $one->getData() : [];
    }


    public function baseDelete(){

        $request = Request::instance();
        $id = $request->param('id/d');

        $className = $request->controller();
        $model = 'app\member\model\\'.$className;
        $model = new $model;

        if (empty($id))
            \my::error('缺少参数：id');

        $ret = $model::destroy(['shop_id'=>SHOP_ID,'id'=>$id]);
        if (!$ret)
            \my::error('删除失败');

        $this->success('删除成功',url($className.'/index'));
//        exit(json_encode([
//            'msg'   =>  '删除成功',
//            'url'   =>  url($className.'/index')
//        ]));
    }
}