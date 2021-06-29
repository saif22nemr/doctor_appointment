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
            [
            'key'    => 'employee',
            'name' => 'الموظفين'
            ],
            [
            'key'    => 'branch',
            'name' => 'الفروع'
            ],
            [
                'key'    => 'setting',
                'name' => 'الاعدادات',
                'view'    => 1,
                'create'    => 0,
                'edit'    => 1,
                'delete'    => 0,
            ],
            [
                'key'    => 'admin',
                'name' => 'المدراء'
            ],
            [
                'key'    => 'profile',
                'name' => 'صفحة الشخصية',
                'view'    => 1,
                'create'    => 0,
                'edit'    => 1,
                'delete'    => 0,
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
