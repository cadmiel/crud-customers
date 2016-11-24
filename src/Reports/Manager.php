<?php
namespace Reports;

class Manager
{

    public function save(IManager $obj, $array, $customer_id, $mth)
    {
        if ($mth == 'address')
            $this->address($obj, $array, $customer_id);
        elseif ($mth == 'emails')
            $this->emails($obj, $array, $customer_id);
        elseif ($mth == 'fone')
            $this->fone($obj, $array, $customer_id);
    }

    public function address(IManager $obj, $array, $customer_id)
    {
        if(count($array) >0)
        foreach ($array as $item) {
            if (strlen($item) > 1)
                $obj->save(array('address' => $item, 'customer_id' => $customer_id));
        }
    }

    public function emails(IManager $obj, $array, $customer_id)
    {
        if(count($array) >0)
        foreach ($array as $item) {
            if (strlen($item) > 1 AND !empty(filter_var($item,FILTER_VALIDATE_EMAIL)) )
                $obj->save(array('email' => $item, 'customer_id' => $customer_id));
        }
    }

    public function fone(IManager $obj, $array, $customer_id)
    {
        if(count($array) >0)
        foreach ($array as $item) {
            if (strlen($item) > 1)
                $obj->save(array('fone' => $this->numberOnly( $item ), 'customer_id' => $customer_id));
        }
    }

    public function destroy(IManager $obj, $id)
    {
        if (is_array($obj->data)) {
            foreach ($obj->data as $item):
                $obj->destroy($item->customer_id);
            endforeach;

        } elseif (!is_null($id)) {
            $obj->destroy($id);
        }
    }

    public function numberOnly($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }
}