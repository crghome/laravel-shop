<?php
namespace Crghome\Shop\Http\Controllers\Api\Datatable;

use Crghome\Shop\Http\Controllers\Admin\Controller;

abstract class AbstractDatatableController extends Controller
{
    /**
     * get config by DataTable
     * @return Array
     */
    abstract public static function getFields();

    /**
     * get array data by DataTable
     * @return Array
     */
    abstract public function getArrData();

    /**
     * get array by DataTable
     * @return json
     */
    public function getData(){
        $result = ['data' => [], "recordsTotal" => 0, "recordsFiltered" => 0];
        if (request()->ajax() && auth()->check()) {
            $result = $this->getArrData();
        }
        return response()->json($result);
    }
}