<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            [
                'room_name' => 'シングルルーム',
                'room_type' => 'single',
                'capacity' => 1,
                'facility' => 'エアコン、ユニットバス、冷蔵庫',
                'description' => 'シングルベッドのお部屋です。1名向けのシンプルなお部屋です。',
                'path' => 'images/single.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_name' => 'ダブルルーム',
                'room_type' => 'double',
                'capacity' => 2,
                'facility' => 'エアコン、ユニットバス、冷蔵庫',
                'description' => 'ダブルベッドのお部屋です。カップルや夫婦で手軽に宿泊できるお部屋です。',
                'path' => 'images/double.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_name' => 'コンドミニアムルーム',
                'room_type' => 'condminium',
                'capacity' => 5,
                'facility' => 'エアコン、キッチン、トイレ・バス別、冷蔵庫',
                'description' => '当施設1番人気のお部屋です。キッチンのついた家族向けのお部屋で、広々とくつろぐ時間をお楽しみください。',
                'path' => 'images/condminium.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_name' => '最上階ルーム',
                'room_type' => 'topfloor',
                'capacity' => 3,
                'facility' => 'エアコン、トイレ・バス別、冷蔵庫、コンシェルジュサービス有',
                'description' => '最上階のお部屋で、全室オーシャンビューのお部屋です。贅沢な時間を味わいたい方に人気のお部屋です。',
                'path' => 'images/topfloor.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
