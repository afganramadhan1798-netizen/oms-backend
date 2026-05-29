<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Overtime;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OvertimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $productManager = User::where('role', 'product_manager')->first();
        // $user = User::where('email', 'afgan@gmail.com')->first();

        // $overtime = Overtime::create([
        //     'employee_id' => $user->id,
        //     'product_manager_id' => $productManager->id,
        //     'date'=> date('Y-m-d'),
        //     'start_time' => '09:00',
        //     'end_time' => '15:00',
        //     'duration' => '4',
        //     'status'=> 'pending',
        // ]);

        // DB::table('overtime_tasks')->insert([
        //     [
        //         'overtime_id' => $overtime->id,
        //         'task_title' => 'Design UI',
        //         'task_description' => 'Membuat design UI untuk website OMS',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'overtime_id' => $overtime->id,
        //         'task_title' => 'Design Database',
        //         'task_description' => 'Membuat struktur database untuk website OMS',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);

        // $overtime = Overtime::create([
        //     'employee_id' => $user->id,
        //     'product_manager_id' => $productManager->id,
        //     'date'=> date('Y-m-d'),
        //     'start_time' => '19:00',
        //     'end_time' => '23:00',
        //     'duration' => '4',
        //     'status'=> 'pending',
        // ]);

        // DB::table('overtime_tasks')->insert([
        //     [
        //         'overtime_id' => $overtime->id,
        //         'task_title' => 'Breakdown Task',
        //         'task_description' => 'Menyusun task untuk website OMS',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'overtime_id' => $overtime->id,
        //         'task_title' => 'Membuat API',
        //         'task_description' => 'Membuat API untuk website OMS',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);


    }
}
