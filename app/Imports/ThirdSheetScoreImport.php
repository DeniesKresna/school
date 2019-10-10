<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ThirdSheetScoreImport implements ToCollection
{
    public function collection(Collection $rows)
    {
    	$data = [];
        foreach ($rows as $row) 
        {
            $data2 = ['no'=>$row[0]];
            array_push($data, $data2);
        }
        return $data;
    }
}