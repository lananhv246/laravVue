<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CsvImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            // 'name'     => $row[0],
            // 'email'    => $row[1],
            // 'password' => \Hash::make($row[2]),
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => \Hash::make($row['password']),
        ]);
    }
    
    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Email',
            'Created at',
            'Updated at'
        ];
    }
}
