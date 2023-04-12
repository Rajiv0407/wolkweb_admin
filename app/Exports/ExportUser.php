<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExportUser implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {	
    	 $type = DB::table('user_subscriber')->select('id','name','email')->get();
        return $type ;
       
    }
   

      public function headings(): array
    {
        return [
            'id',
            'UserName',
            'Email'
        ];
    }
}
