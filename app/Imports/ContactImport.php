<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ContactImport implements ToModel, WithStartRow
{

    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Contact([
                'first_name' => $row[0],
                'last_name'  => $row[1], 
                'phone_no'   => (int)preg_replace('/(?<=\d)\s+(?=\d)/', '', "$row[2]")
        ]);
    }
}
