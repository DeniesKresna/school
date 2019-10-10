<?php
namespace App\Imports;

//use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
//use Maatwebsite\Excel\Concerns\WithStartRow;

class FirstSheetScoreImport implements ToCollection
{
    public function collection(Collection $rows)
    {
    	$data = [];
        foreach ($rows as $row) 
        {
            array_push($data, $row[0]);
        }
        return $data;
    }
/*
    public function startRow() {
	     return 3;
	}*/
}