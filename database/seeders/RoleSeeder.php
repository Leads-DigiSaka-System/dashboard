<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$count = Db::table('roles')->count();

        if(!$count){
            $roles = [
                'admin'=>"Admin",
                'cutting_department'=>"Cutting Department",
                'production_department'=>"Production Department"
            ];
            foreach ($roles as $key => $role) {
                DB::table('roles')->insert([
                    'title' => $role,
                    'slug' => $key,
                    'is_deleteable' => 0,
                    'created_at' => date("Y-m-d H:i:s"),
                    'created_by'=> 0
                ]);
            }
    	}
    
    }
}
