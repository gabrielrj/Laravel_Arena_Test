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
        $permissions = [
            ['value' => 'ALLPERMISSIONS', 'description' => 'All permissions.'],
            ['value' => 'VIEWPERMISSION', 'description' => 'Can only view all data registered.'],
            ['value' => 'CREATEPERMISSION', 'description' => 'Can only view registered data and/or create new data.'],
            ['value' => 'EDITPERMISSION', 'description' => 'Can only view and/or edit registered data.'],
            ['value' => 'DELETEPERMISSION', 'description' => 'Can only view and/or delete registered data.'],
        ];

        foreach ($permissions as $permission){
            Permission::query()->where('value', '=', $permission['value'])->firstOrCreate([
                'value' => $permission['value'],
                'description' => $permission['description']
            ]);
        }
    }
}
