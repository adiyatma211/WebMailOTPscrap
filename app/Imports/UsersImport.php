<?php

namespace App\Imports;

use App\Models\sbuser;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new sbuser([
            'email' => $row[0],  // Adjust the index based on your Excel columns
            'password' => $row[1], // Adjust the index based on your Excel columns
            // Add other fields here as needed
        ]);
    }
}
