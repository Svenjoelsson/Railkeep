<?php

namespace App\DataTables;

use App\Models\Units;
use App\Models\Services;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Support\Facades\Http;
use App\Traits\ServiceplanTrait;



function isMobileDev(){
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
       $user_ag = $_SERVER['HTTP_USER_AGENT'];
       if(preg_match('/(Mobile|Android|Tablet|GoBrowser|[0-9]x[0-9]*|uZardWeb\/|Mini|Doris\/|Skyfire\/|iPhone|Fennec\/|Maemo|Iris\/|CLDC\-|Mobi\/)/uis',$user_ag)){
          return true;
       };
    };
    return false;
}


class UnitsDataTable extends DataTable
{
    use ServicePlanTrait;
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        
        $dataTable = new EloquentDataTable($query);
        return $dataTable->addColumn('action', 'units.datatables_actions')
        ->addColumn('ServiceCounter', 'units.service_counter')->escapeColumns('active')
        ->addColumn('Stoplight', 'units.stoplight')->escapeColumns('active')
        ->addColumn('ServiceDate', 'units.service_date')->escapeColumns('active')
        ->addColumn('status', 'units.status')->escapeColumns('active');

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Units $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Units $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtlip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        if (isMobileDev()) { 
            return [
                'unit',
                'status'
            ];
        } else {
            return [
                'unit',
                'customer',
                'ServiceCounter',
                'ServiceDate',
                'status'
            ];
        }

    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'units_datatable_' . time();
    }
}
