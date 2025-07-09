<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Caste;
use App\Models\Religion;

class CasteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Hindu' => [
                'Brahmin', 'Kshatriya', 'Vaishya', 'Shudra',
                'Kayastha', 'Yadav', 'Kurmi', 'Jat', 'Maratha', 'Rajput'
            ],
            'Muslim' => [
                'Sunni', 'Shia', 'Syed', 'Pathan', 'Memon', 'Ansari'
            ],
            'Christian' => [
                'Roman Catholic', 'Protestant', 'Orthodox', 'Pentecostal', 'Evangelical', 'Anglican'
            ],
            'Sikh' => [
                'Jat Sikh', 'Ramgarhia', 'Khatri', 'Mazabi', 'Lubana'
            ],
            'Buddhist' => [
                'Theravada', 'Mahayana', 'Navayana'
            ],
            'Jain' => [
                'Digambar', 'Shwetambar', 'Terapanthi', 'Sthanakvasi'
            ]
        ];

        foreach ($data as $religionName => $castes) {
            $religion = Religion::where('name', $religionName)->first();
            if ($religion) {
                foreach ($castes as $casteName) {
                    Caste::create([
                        'religionid' => $religion->rid,
                        'name' => $casteName,
                        'status' => 'show'
                    ]);
                }
            }
        }
    }

}
