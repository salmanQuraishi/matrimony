<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TblNotificationSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_notification')->insert([
            [
                'title' => 'Lucky Draw Winners',
                'desc' => 'Consistency Lucky Draw Winner of Aug Month',
                'image' => 'assets/img/notification/66db4afaa01791000569776.jpg',
                'status' => 0,
                'created_at' => Carbon::parse('2024-09-06 18:33:30'),
                'updated_at' => Carbon::parse('2024-10-04 11:56:40'),
            ],
            [
                'title' => 'Lucky Draw Winner | Sep Month',
                'desc' => 'List of Lucky Draw Winners held on 8th Oct, 2024',
                'image' => 'assets/img/notification/66ffd7e4db1dfIMG-20241004-WA0068.jpg',
                'status' => 1,
                'created_at' => Carbon::parse('2024-10-04 11:56:20'),
                'updated_at' => Carbon::parse('2024-10-04 11:56:20'),
            ]
        ]);
    }
}