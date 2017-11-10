<?php

namespace app\Index\model;

use think\Model;

class Worklist extends Model
{


    public function delwklist($id)
    {
        if ($this::destroy($id)) {
            return 1;
        } else {
            return 2;
        }
    }

    public function getwklist(){
        return $this::paginate(5);
    }


}
