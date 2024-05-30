<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role as RoleModel;

class RoleSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['Admin','User','Visitor', 'Editor'] as $key => $value) {
            RoleModel::create(['name' => $value]);
        }
    }
}
