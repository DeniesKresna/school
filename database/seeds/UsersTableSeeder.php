<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([[
              'name' => 'Denies Kresna B',
              'nik' => '201501003',
              'password' => app('hash')->make('12345'),
              'email' => 'batkorumbawa@gmail.com',
              'role' => 'superadmin',
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],
            [
              'name' => 'Ricky Putra',
              'nik' => '201801011',
              'password' => app('hash')->make('12345'),
              'email' => 'ricky@gmail.com',
              'role' => 'admin',
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],
      ]);
      DB::table('rooms')->insert([[
              'room_name' => 'D2.03',
              'room_alias' => 'R. Meeting',
              'pic_id'=>1,
              'room_created_by'=>1,
              'room_updated_by'=>1,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],
            [
              'room_name' => 'D2.04',
              'room_alias' => 'R. Guru',
              'pic_id'=>1,
              'room_created_by'=>1,
              'room_updated_by'=>1,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],
            [
              'room_name' => 'E3.09',
              'room_alias' => 'Kelas XII IPA 1',
              'pic_id'=>1,
              'room_created_by'=>1,
              'room_updated_by'=>1,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ]
      ]);
      DB::table('conditiontypes')->insert([[
              'conditiontype_name' => 'BAIK',
              'conditiontype_created_by'=>1,
              'conditiontype_updated_by'=>1,
            ],
            [
              
              'conditiontype_name' => 'CUKUP',
              'conditiontype_created_by'=>1,
              'conditiontype_updated_by'=>1,
            ],
            [
              
              'conditiontype_name' => 'RUSAK',
              'conditiontype_created_by'=>1,
              'conditiontype_updated_by'=>1,
            ]
      ]);/*
        DB::table('groups')->insert([[
              'group_name' => 'Furnitur',
              'group_created_by' => 1,
              'group_updated_by' => 1,
              'group_created_by' => 1,
              'group_updated_by' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],
            [
              'group_name' => 'Komputer',
              'group_created_by' => 1,
              'group_updated_by' => 1,
              'group_created_by' => 1,
              'group_updated_by' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],
            [
              'group_name' => 'Trasnportasi',
              'group_created_by' => 1,
              'group_updated_by' => 1,
              'group_created_by' => 1,
              'group_updated_by' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ]
      ]);
        DB::table('assettypes')->insert([[
              'assettype_name' => 'Kursi Siswa',
              'assettype_unit' => 'buah',
              'group_id' => 1,
              'assettype_created_by' => 1,
              'assettype_updated_by' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],
      ]);*/
    }
}
