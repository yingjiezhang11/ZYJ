<?php

namespace app\common;


use think\paginator\driver\Bootstrap;

class ZuiPager extends Bootstrap
{
    public function render()
    {
        if ($this->hasPages()) {
            if ($this->simple) {
                return sprintf(
                    '<div style="text-align: center"><ul class="pager">%s %s</ul></div>',
                    $this->getPreviousButton(),
                    $this->getNextButton()
                );
            } else {
                $count = $this->total;
                return sprintf(
                    '<div style="text-align: center"><ul class="pager">%s %s %s %s</ul></div>',
                    $this->getPreviousButton(),
                    $this->getLinks(),
                    $this->getNextButton(),
                    "<li class='disabled'><span>共 {$count} 条记录</span></li>"
                );
            }
        }
    }


    public $_url;

    function url($page) {
        if (!$this->_url) {
            $pageVar = config('paginate.var_page');
            $get = input('get.');
            unset($get[$pageVar]);
            $get[$pageVar] = '';

            $this->_url = request()->baseUrl().'?' . http_build_query($get);
        }

        return $this->_url . $page;
    }
}