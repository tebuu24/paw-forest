<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // --- RIGA SHELTER EMPLOYEES (IDs: 1, 2, 3) ---
        // Darbinieks 1
        User::create(['id' => 1, 'name' => 'Jānis Bērziņš', 'username' => 'janis_emp', 'email' => 'janis@pawforest.com', 'password' => $password, 'role' => 'employee', 'address' => 'Rīga, Latvija', 'date_joined' => now()]);
        DB::table('employees')->insert(['user_id' => 1, 'location_id' => 1, 'phone_number' => '+371 20000001', 'job_title' => 'Shelter Manager']);

        // Darbinieks 2
        User::create(['id' => 2, 'name' => 'Laura Krauja', 'username' => 'laura_emp', 'email' => 'laura@pawforest.com', 'password' => $password, 'role' => 'employee', 'address' => 'Rīga, Latvija', 'date_joined' => now()]);
        DB::table('employees')->insert(['user_id' => 2, 'location_id' => 1, 'phone_number' => '+371 20000002', 'job_title' => 'Veterinarian']);

        // Darbinieks 3
        User::create(['id' => 3, 'name' => 'Artūrs Kalniņš', 'username' => 'arturs_emp', 'email' => 'arturs@pawforest.com', 'password' => $password, 'role' => 'employee', 'address' => 'Rīga, Latvija', 'date_joined' => now()]);
        DB::table('employees')->insert(['user_id' => 3, 'location_id' => 1, 'phone_number' => '+371 20000003', 'job_title' => 'Animal Care Specialist']);


        // --- JURMALA SHELTER EMPLOYEES (IDs: 4, 5, 6) ---
        // Darbinieks 4
        User::create(['id' => 4, 'name' => 'Anete Ozola', 'username' => 'anete_emp', 'email' => 'anete@pawforest.com', 'password' => $password, 'role' => 'employee', 'address' => 'Jūrmala, Latvija', 'date_joined' => now()]);
        DB::table('employees')->insert(['user_id' => 4, 'location_id' => 2, 'phone_number' => '+371 20000004', 'job_title' => 'Shelter Manager']);

        // Darbinieks 5
        User::create(['id' => 5, 'name' => 'Kārlis Zariņš', 'username' => 'karlis_emp', 'email' => 'karlis@pawforest.com', 'password' => $password, 'role' => 'employee', 'address' => 'Jūrmala, Latvija', 'date_joined' => now()]);
        DB::table('employees')->insert(['user_id' => 5, 'location_id' => 2, 'phone_number' => '+371 20000005', 'job_title' => 'Veterinarian']);

        // Darbinieks 6
        User::create(['id' => 6, 'name' => 'Kristīne Lāce', 'username' => 'kristine_emp', 'email' => 'kristine@pawforest.com', 'password' => $password, 'role' => 'employee', 'address' => 'Jūrmala, Latvija', 'date_joined' => now()]);
        DB::table('employees')->insert(['user_id' => 6, 'location_id' => 2, 'phone_number' => '+371 20000006', 'job_title' => 'Volunteer Coordinator']);


        // --- VALMIERA SHELTER EMPLOYEES (IDs: 7, 8, 9) ---
        // Darbinieks 7
        User::create(['id' => 7, 'name' => 'Mārtiņš Priede', 'username' => 'martins_emp', 'email' => 'martins@pawforest.com', 'password' => $password, 'role' => 'employee', 'address' => 'Valmiera, Latvija', 'date_joined' => now()]);
        DB::table('employees')->insert(['user_id' => 7, 'location_id' => 3, 'phone_number' => '+371 20000007', 'job_title' => 'Shelter Manager']);

        // Darbinieks 8
        User::create(['id' => 8, 'name' => 'Ilze Vītola', 'username' => 'ilze_emp', 'email' => 'ilze@pawforest.com', 'password' => $password, 'role' => 'employee', 'address' => 'Valmiera, Latvija', 'date_joined' => now()]);
        DB::table('employees')->insert(['user_id' => 8, 'location_id' => 3, 'phone_number' => '+371 20000008', 'job_title' => 'Veterinarian Assistant']);

        // Darbinieks 9
        User::create(['id' => 9, 'name' => 'Gints Kļaviņš', 'username' => 'gints_emp', 'email' => 'gints@pawforest.com', 'password' => $password, 'role' => 'employee', 'address' => 'Valmiera, Latvija', 'date_joined' => now()]);
        DB::table('employees')->insert(['user_id' => 9, 'location_id' => 3, 'phone_number' => '+371 20000009', 'job_title' => 'Animal Care Specialist']);
    
        }
}