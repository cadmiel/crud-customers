<?php
namespace Reports;


interface IManager
{

    public function save($data);
    public function destroy($id);

}