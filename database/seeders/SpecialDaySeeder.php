<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialDaySeeder extends Seeder
{
    public function run()
    {
        $days = [

            // January
            [
                'title' => "New Year's Day",
                'occasion_date' => '2026-01-01',
                'category' => 'festival',
                'is_major' => true,
            ],
            [
                'title' => 'National Youth Day',
                'occasion_date' => '2026-01-12',
                'category' => 'national',
            ],
            [
                'title' => 'Makar Sankranti and Pongal',
                'occasion_date' => '2026-01-14',
                'category' => 'festival',
                'is_major' => true,
            ],
            [
                'title' => 'Indian Army Day',
                'occasion_date' => '2026-01-15',
                'category' => 'national',
            ],
            [
                'title' => 'National Girl Child Day',
                'occasion_date' => '2026-01-24',
                'category' => 'awareness',
            ],
            [
                'title' => 'Republic Day',
                'occasion_date' => '2026-01-26',
                'category' => 'national',
                'is_major' => true,
            ],
            [
                'title' => "Martyrs' Day",
                'occasion_date' => '2026-01-30',
                'category' => 'national',
            ],

            // February
            [
                'title' => 'World Cancer Day',
                'occasion_date' => '2026-02-04',
                'category' => 'health',
            ],
            [
                'title' => "Valentine's Day",
                'occasion_date' => '2026-02-14',
                'category' => 'international',
                'is_major' => true,
            ],
            [
                'title' => 'Maha Shivratri',
                'occasion_date' => '2026-02-15',
                'category' => 'festival',
                'is_major' => true,
            ],
            [
                'title' => 'Chhatrapati Shivaji Maharaj Jayanti',
                'occasion_date' => '2026-02-19',
                'category' => 'national',
            ],
            [
                'title' => 'National Science Day',
                'occasion_date' => '2026-02-28',
                'category' => 'education',
            ],

            // March
            [
                'title' => 'World Wildlife Day',
                'occasion_date' => '2026-03-03',
                'category' => 'environment',
            ],
            [
                'title' => 'Holika Dahan',
                'occasion_date' => '2026-03-03',
                'category' => 'festival',
            ],
            [
                'title' => 'Holi',
                'occasion_date' => '2026-03-04',
                'category' => 'festival',
                'is_major' => true,
            ],
            [
                'title' => "International Women's Day",
                'occasion_date' => '2026-03-08',
                'category' => 'international',
                'is_major' => true,
            ],
            [
                'title' => 'Gudi Padwa and Ugadi',
                'occasion_date' => '2026-03-19',
                'category' => 'festival',
            ],
            [
                'title' => 'Eid ul Fitr',
                'occasion_date' => '2026-03-21',
                'category' => 'festival',
                'is_major' => true,
            ],
            [
                'title' => 'World Water Day',
                'occasion_date' => '2026-03-22',
                'category' => 'environment',
            ],
            [
                'title' => 'World Tuberculosis Day',
                'occasion_date' => '2026-03-24',
                'category' => 'health',
            ],
            [
                'title' => 'Ram Navami',
                'occasion_date' => '2026-03-26',
                'category' => 'festival',
            ],
            [
                'title' => 'Mahavir Jayanti',
                'occasion_date' => '2026-03-31',
                'category' => 'festival',
            ],

            // April
            [
                'title' => 'World Autism Awareness Day',
                'occasion_date' => '2026-04-02',
                'category' => 'awareness',
            ],
            [
                'title' => 'Good Friday',
                'occasion_date' => '2026-04-03',
                'category' => 'festival',
            ],
            [
                'title' => 'Easter Sunday',
                'occasion_date' => '2026-04-05',
                'category' => 'festival',
            ],
            [
                'title' => 'World Health Day',
                'occasion_date' => '2026-04-07',
                'category' => 'health',
                'is_major' => true,
            ],
            [
                'title' => 'Dr B R Ambedkar Jayanti',
                'occasion_date' => '2026-04-14',
                'category' => 'national',
                'is_major' => true,
            ],
            [
                'title' => 'Baisakhi',
                'occasion_date' => '2026-04-14',
                'category' => 'festival',
            ],
            [
                'title' => 'World Earth Day',
                'occasion_date' => '2026-04-22',
                'category' => 'environment',
                'is_major' => true,
            ],

            // May
            [
                'title' => 'International Labour Day',
                'occasion_date' => '2026-05-01',
                'category' => 'international',
                'is_major' => true,
            ],
            [
                'title' => 'Buddha Purnima',
                'occasion_date' => '2026-05-01',
                'category' => 'festival',
            ],
            [
                'title' => 'World Press Freedom Day',
                'occasion_date' => '2026-05-03',
                'category' => 'international',
            ],
            [
                'title' => "Mother's Day",
                'occasion_date' => '2026-05-10',
                'category' => 'international',
                'is_major' => true,
            ],
            [
                'title' => 'International Nurses Day',
                'occasion_date' => '2026-05-12',
                'category' => 'health',
            ],
            [
                'title' => 'Eid ul Adha',
                'occasion_date' => '2026-05-27',
                'category' => 'festival',
                'is_major' => true,
            ],
            [
                'title' => 'World No Tobacco Day',
                'occasion_date' => '2026-05-31',
                'category' => 'health',
            ],

            // June
            [
                'title' => 'World Environment Day',
                'occasion_date' => '2026-06-05',
                'category' => 'environment',
                'is_major' => true,
            ],
            [
                'title' => 'World Blood Donor Day',
                'occasion_date' => '2026-06-14',
                'category' => 'health',
            ],
            [
                'title' => "Father's Day",
                'occasion_date' => '2026-06-21',
                'category' => 'international',
                'is_major' => true,
            ],
            [
                'title' => 'International Yoga Day',
                'occasion_date' => '2026-06-21',
                'category' => 'health',
                'is_major' => true,
            ],
            [
                'title' => 'Muharram',
                'occasion_date' => '2026-06-26',
                'category' => 'festival',
            ],

            // July
            [
                'title' => "National Doctors' Day",
                'occasion_date' => '2026-07-01',
                'category' => 'health',
                'is_major' => true,
            ],
            [
                'title' => 'Chartered Accountants Day',
                'occasion_date' => '2026-07-01',
                'category' => 'professional',
            ],
            [
                'title' => 'World Population Day',
                'occasion_date' => '2026-07-11',
                'category' => 'awareness',
            ],
            [
                'title' => 'Rath Yatra',
                'occasion_date' => '2026-07-16',
                'category' => 'festival',
            ],

            // August
            [
                'title' => 'Friendship Day',
                'occasion_date' => '2026-08-02',
                'category' => 'international',
            ],
            [
                'title' => 'Independence Day',
                'occasion_date' => '2026-08-15',
                'category' => 'national',
                'is_major' => true,
            ],
            [
                'title' => 'World Photography Day',
                'occasion_date' => '2026-08-19',
                'category' => 'international',
            ],
            [
                'title' => 'Milad un Nabi',
                'occasion_date' => '2026-08-26',
                'category' => 'festival',
            ],
            [
                'title' => 'Raksha Bandhan',
                'occasion_date' => '2026-08-28',
                'category' => 'festival',
                'is_major' => true,
            ],

            // September
            [
                'title' => 'Janmashtami',
                'occasion_date' => '2026-09-04',
                'category' => 'festival',
                'is_major' => true,
            ],
            [
                'title' => "Teachers' Day",
                'occasion_date' => '2026-09-05',
                'category' => 'education',
                'is_major' => true,
            ],
            [
                'title' => 'International Literacy Day',
                'occasion_date' => '2026-09-08',
                'category' => 'education',
            ],
            [
                'title' => 'Hindi Diwas',
                'occasion_date' => '2026-09-14',
                'category' => 'national',
            ],
            [
                'title' => 'Ganesh Chaturthi',
                'occasion_date' => '2026-09-14',
                'category' => 'festival',
                'is_major' => true,
            ],
            [
                'title' => "Engineers' Day",
                'occasion_date' => '2026-09-15',
                'category' => 'professional',
            ],
            [
                'title' => 'World Ozone Day',
                'occasion_date' => '2026-09-16',
                'category' => 'environment',
            ],
            [
                'title' => 'International Day of Peace',
                'occasion_date' => '2026-09-21',
                'category' => 'international',
            ],
            [
                'title' => 'World Tourism Day',
                'occasion_date' => '2026-09-27',
                'category' => 'international',
            ],

            // October
            [
                'title' => 'International Day of Older Persons',
                'occasion_date' => '2026-10-01',
                'category' => 'awareness',
            ],
            [
                'title' => 'Gandhi Jayanti',
                'occasion_date' => '2026-10-02',
                'category' => 'national',
                'is_major' => true,
            ],
            [
                'title' => 'World Animal Day',
                'occasion_date' => '2026-10-04',
                'category' => 'awareness',
            ],
            [
                'title' => "World Teachers' Day",
                'occasion_date' => '2026-10-05',
                'category' => 'education',
            ],
            [
                'title' => 'World Mental Health Day',
                'occasion_date' => '2026-10-10',
                'category' => 'health',
                'is_major' => true,
            ],
            [
                'title' => 'International Day of the Girl Child',
                'occasion_date' => '2026-10-11',
                'category' => 'awareness',
            ],
            [
                'title' => 'World Food Day',
                'occasion_date' => '2026-10-16',
                'category' => 'awareness',
            ],
            [
                'title' => 'Dussehra',
                'occasion_date' => '2026-10-20',
                'category' => 'festival',
                'is_major' => true,
            ],
            [
                'title' => 'United Nations Day',
                'occasion_date' => '2026-10-24',
                'category' => 'international',
            ],
            [
                'title' => 'National Unity Day',
                'occasion_date' => '2026-10-31',
                'category' => 'national',
            ],
            [
                'title' => 'Halloween',
                'occasion_date' => '2026-10-31',
                'category' => 'international',
            ],

            // November
            [
                'title' => 'Diwali',
                'occasion_date' => '2026-11-08',
                'category' => 'festival',
                'is_major' => true,
            ],
            [
                'title' => "Children's Day",
                'occasion_date' => '2026-11-14',
                'category' => 'national',
                'is_major' => true,
            ],
            [
                'title' => 'World Diabetes Day',
                'occasion_date' => '2026-11-14',
                'category' => 'health',
            ],
            [
                'title' => "International Men's Day",
                'occasion_date' => '2026-11-19',
                'category' => 'international',
            ],
            [
                'title' => 'Guru Nanak Jayanti',
                'occasion_date' => '2026-11-24',
                'category' => 'festival',
                'is_major' => true,
            ],
            [
                'title' => 'Constitution Day of India',
                'occasion_date' => '2026-11-26',
                'category' => 'national',
            ],

            // December
            [
                'title' => 'World AIDS Day',
                'occasion_date' => '2026-12-01',
                'category' => 'health',
            ],
            [
                'title' => 'International Day of Persons with Disabilities',
                'occasion_date' => '2026-12-03',
                'category' => 'awareness',
            ],
            [
                'title' => 'Indian Navy Day',
                'occasion_date' => '2026-12-04',
                'category' => 'national',
            ],
            [
                'title' => 'World Soil Day',
                'occasion_date' => '2026-12-05',
                'category' => 'environment',
            ],
            [
                'title' => 'Armed Forces Flag Day',
                'occasion_date' => '2026-12-07',
                'category' => 'national',
            ],
            [
                'title' => 'Human Rights Day',
                'occasion_date' => '2026-12-10',
                'category' => 'international',
            ],
            [
                'title' => 'National Energy Conservation Day',
                'occasion_date' => '2026-12-14',
                'category' => 'environment',
            ],
            [
                'title' => 'Christmas Day',
                'occasion_date' => '2026-12-25',
                'category' => 'festival',
                'is_major' => true,
            ],
            [
                'title' => "New Year's Eve",
                'occasion_date' => '2026-12-31',
                'category' => 'festival',
                'is_major' => true,
            ],
        ];

        $now = now();

        $records = array_map(function ($day) use ($now) {
            return array_merge([
                'icon' => null,
                'is_major' => false,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ], $day);
        }, $days);

        DB::table('special_days')->upsert(
            $records,
            ['title', 'occasion_date'],
            [
                'category',
                'icon',
                'is_major',
                'is_active',
                'updated_at',
            ]
        );
    }
}

