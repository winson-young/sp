<?php

namespace Application\Component;

use Core\Basic as Basic;

/**
 * test自动加载类
 */
class IndexComponent extends Basic
{
    public function index()
    {
        /*var_dump($this->fastCache->set('winson', 'win', 0));
        var_dump($this->fastCache->get('winson'));
        var_dump($this->fastCache->delete('winson'));
        var_dump($this->fastCache->get('winson'));*/
        //var_dump($this->slowCache->set('winson', 'win', 2));
        //var_dump($this->slowCache->set('winson', 'win', 3));
        //var_dump($this->slowCache->get('winson'));
        /*var_dump($this->slowCache->delete('winson'));
        var_dump($this->slowCache->get('winson'));*/
        $memcached = new \Memcache;
        var_dump($memcached);exit;
    }
			
}