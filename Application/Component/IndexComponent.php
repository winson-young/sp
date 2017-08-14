<?php

namespace Application\Component;

use Core\Basic;

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
        var_dump($this->slowCache->get('winson'));
        $memcached = new \Memcache;
        var_dump($memcached);exit;*/
        /*$result = $this->localDb->select([
            'column' => ['customers_id', 'customers_nickname'],
            'table' => 'customers',
            'where' => 'customers_id = 8041'
        ]);*/
        /*$result = $this->localDb->save([
            'column' => ['customers_firstname'],
            'value' => ['update_firstname'],
            'table' => 'customers',
            'where' => 'customers_id = 8041'
        ]);*/
        /*$result = $this->localDb->save([
            'data' => ['customers_firstname' => 'dataupdate1'],
            'table' => 'customers',
            'where' => 'customers_id = 8041'
        ]);
        $result = $this->localDb->add([
            'column' => ['customers_firstname', 'customers_gender'],
            'value' => [['testName2', 's'],['testName3', 'l']],
            'table' => 'customers'
        ]);*/
        var_dump($result);exit;
    }
			
}