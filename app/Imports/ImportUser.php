<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Quantitie;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Hash ;
use DB ;

class ImportUser implements ToCollection, WithHeadingRow,SkipsOnError, SkipsOnFailure
{ 

      use Importable,SkipsErrors, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(collection $rows)
    {       

            Validator::make($rows->toArray(), [
             '*.name' => 'required',
             '*.email' => 'required',
             '*.password' => 'required',
         ])->validate();

           
            $insertData=array();
        foreach ($rows as $row) {
            $insertData[]=array(
                'name' => $row['name'],
                'email' => $row['email']
                
            );
        }

     

 return DB::table('user_subscriber')->insert($insertData);


        
        
    }

     public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.

    }

    
}
