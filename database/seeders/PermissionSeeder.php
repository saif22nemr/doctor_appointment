<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
           [
               'key'    => 'patient',
               'name' => 'المرضي'
           ],
           [
            'key'    => 'appointment',
            'name' => 'المواعيد'
        ],
        ];
        foreach($data as $index => $value){
            Permission::create($value);
        }
    }
}
