<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\VisitorType;

class VisitorTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    $users =  [
      [
        'name' => 'Cosplayer',
      ],
      [
        'name' => 'Elite',
      ],
      [
        'name' => 'Visitor',
      ]
    ];

    DB::table('visitor_types')->insert($users);
  }
}
