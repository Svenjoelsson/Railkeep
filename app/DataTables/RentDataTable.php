<?php

namespace App\DataTables;
use Auth;
use App\Models\Rent;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

function isMobileDev(){
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
       $user_ag = $_SERVER['HTTP_USER_AGENT'];
       if(preg_match('/(Mobile|Android|Tablet|GoBrowser|[0-9]x[0-9]*|uZardWeb\/|Mini|Doris\/|Skyfire\/|iPhone|Fennec\/|Maemo|Iris\/|CLDC\-|Mobi\/)/uis',$user_ag)){
          return true;
       };
    };
    return false;
}

class RentDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'rents.datatables_actions')
        ->addColumn('monthlyCost', 'rents.monthlyCost')->escapeColumns('active')
        ->addColumn('counterCost', 'rents.counterCost')->escapeColumns('active');


        

    
    }



    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Rent $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Rent $model)
    {
        //return $model->newQuery();

        if (Auth::user()->role == 'customer') { 
            $data = Rent::query()
            ->where('customer', Auth::user()->name);
        } else {
            $data = Rent::query();
        }
        return $this->applyScopes($data);
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
                'customer',
            ];
        } else {
            return [
                'unit',
                'customer',
                'rentStart',
                'rentEnd',
                ['name'=>'periodofnotice','title'=>'Period of Notice','data'=>"periodofnotice"],
                ['name'=>'autoextension','title'=>'Auto renewal period','data'=>"autoextension"],
                'monthlyCost',
                'counterCost',
                'status',
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
        return 'rents_datatable_' . time();
    }
}
