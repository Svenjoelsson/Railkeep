<?php

namespace App\DataTables;

use App\Models\Services;
use Auth;
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

class ServicesDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'services.datatables_actions')
                ->addColumn('service_type', 'services.service_type')->escapeColumns('active')
                ->addColumn('workshop', 'services.workshop')->escapeColumns('active');
                //->addColumn('unit', 'services.unit')->escapeColumns('active');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Services $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Services $model)
    {
        if (Auth::user()->role == 'workshop') {

        $vendorId = \App\Models\Vendors::where('name', Auth::user()->name)->first();
        $services = \App\Models\serviceVendor::where('vendorId', $vendorId->id)->get();
            
        $data = \App\Models\serviceVendor::query()
            ->select('Services.id as id', 'Services.unit as unit', 'services.service_type', 'services.service_date', 'services.service_status', 'services.critical')
            ->where('serviceVendor.vendorId', $vendorId->id)
            ->join('Services', 'Services.id', '=', 'serviceVendor.serviceId')
            ->orderby('Services.id', 'desc');

        } else if (Auth::user()->role == 'customer') {
            $data = Services::query()
        
            ->where('customer', Auth::user()->name)
            ->orderby('id', 'desc');
        }  else if (Auth::user()->role == 'inspector') {
            $data = Services::query()
        
            ->where('customer', Auth::user()->name)
            ->where('service_type', 'Report')
            ->orderby('id', 'desc');
        } else {
            $data = Services::query()
            ->orderby('id', 'desc');
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
        if (Auth::user()->role == 'vendor') { 
            return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => '',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
            ]);
        } else {
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
                'service_status',
            ];
        } else if (Auth::user()->role == 'workshop') {
            return [
                'id',
                'unit',
                ['name'=>'service_type','title'=>'Type','data'=>"service_type"],
                ['name'=>'service_date','title'=>'Date','data'=>"service_date"],
                ['name'=>'service_status','title'=>'Status','data'=>"service_status"],
            ];
        } else if (Auth::user()->role == 'inspector') {
            return [
                'id',
                'unit',
                ['name'=>'service_type','title'=>'Type','data'=>"service_type"],
                ['name'=>'service_desc','title'=>'Description','data'=>"service_desc"],
                'service_desc',
                ['name'=>'service_status','title'=>'Status','data'=>"service_status"]
            ];
        } else {
            return [
                'id',
                'unit',
                ['name'=>'service_type','title'=>'Type','data'=>"service_type"],
                ['name'=>'service_date','title'=>'Date','data'=>"service_date"],
                ['name'=>'service_status','title'=>'Status','data'=>"service_status"],
                'workshop',
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
        return 'services_datatable_' . time();
    }
}
