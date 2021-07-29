<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::statement("SET foreign_key_checks=0");
        Permission::truncate();
        UserPermission::truncate();
        DB::statement("SET foreign_key_checks=1");
        foreach($data as $index => $value){
            Permission::create($value);
        }
    }
}
