<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userProfiles = [
            'sysadmin',
            'viewer',
            'datamanager'
        ];

        foreach ($userProfiles as $profile){
            $newProfile = UserProfile::query()->where('name', '=', $profile)->first();

            if(!$newProfile){
                $newProfile = UserProfile::query()->create(['name' => $profile]);

                if($profile === 'sysadmin')
                    $newProfile->permissions()->sync(Permission::query()->where('value', '=', 'ALLPERMISSIONS')->pluck('id'));
                else if($profile === 'viewer')
                    $newProfile->permissions()->sync(Permission::query()->where('value', '=', 'VIEWPERMISSION')->pluck('id'));
                else if($profile === 'datamanager')
                    $newProfile->permissions()->sync(Permission::query()->whereIn('value', ['CREATEPERMISSION', 'EDITPERMISSION'])->pluck('id'));
            }
        }
    }
}
