<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // Riga Users (ID 10 - 15)
        User::create(['id' => 10, 'name' => 'Valdis Pelšs', 'username' => 'valdis123', 'email' => 'valdis@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Rīga', 'date_joined' => now()]);
        User::create(['id' => 11, 'name' => 'Maija Silova', 'username' => 'maija_s', 'email' => 'maija@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Rīga', 'date_joined' => now()]);
        User::create(['id' => 12, 'name' => 'Edgars Prūsis', 'username' => 'edgars_p', 'email' => 'edgars@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Rīga', 'date_joined' => now()]);
        User::create(['id' => 13, 'name' => 'Samanta Tīna', 'username' => 'samanta_t', 'email' => 'samanta@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Rīga', 'date_joined' => now()]);
        User::create(['id' => 14, 'name' => 'Intars Busulis', 'username' => 'intars_b', 'email' => 'intars@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Mārupe', 'date_joined' => now()]);
        User::create(['id' => 15, 'name' => 'Aija Andrejeva', 'username' => 'aija_a', 'email' => 'aija@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Ogre', 'date_joined' => now()]);

        // Jurmala Users (ID 16 - 21)
        User::create(['id' => 16, 'name' => 'Māris Verpakovskis', 'username' => 'maris_v', 'email' => 'maris@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Jūrmala', 'date_joined' => now()]);
        User::create(['id' => 17, 'name' => 'Jeļena Ostapenko', 'username' => 'alona_o', 'email' => 'alona@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Jūrmala', 'date_joined' => now()]);
        User::create(['id' => 18, 'name' => 'Kaspars Kambala', 'username' => 'kaspars_k', 'email' => 'kaspars@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Jūrmala', 'date_joined' => now()]);
        User::create(['id' => 19, 'name' => 'Zane Dombrovska', 'username' => 'zane_d', 'email' => 'zane@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Jūrmala', 'date_joined' => now()]);
        User::create(['id' => 20, 'name' => 'Oskars Melbārdis', 'username' => 'oskars_m', 'email' => 'oskars@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Jūrmala', 'date_joined' => now()]);
        User::create(['id' => 21, 'name' => 'Baiba Bendika', 'username' => 'baiba_b', 'email' => 'baiba@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Talsi', 'date_joined' => now()]);

        // Valmiera Users (ID 22 - 27)
        User::create(['id' => 22, 'name' => 'Renārs Kaupers', 'username' => 'renars_k', 'email' => 'renars@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Valmiera', 'date_joined' => now()]);
        User::create(['id' => 23, 'name' => 'Jānis Šipkēvics', 'username' => 'shipsea', 'email' => 'shipsea@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Valmiera', 'date_joined' => now()]);
        User::create(['id' => 24, 'name' => 'Linda Leen', 'username' => 'linda_l', 'email' => 'linda@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Valmiera', 'date_joined' => now()]);
        User::create(['id' => 25, 'name' => 'Lauris Reiniks', 'username' => 'lauris_r', 'email' => 'lauris@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Valmiera', 'date_joined' => now()]);
        User::create(['id' => 26, 'name' => 'Ralfs Eilands', 'username' => 'ralfs_e', 'email' => 'ralfs@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Cēsis', 'date_joined' => now()]);
        User::create(['id' => 27, 'name' => 'Aminata Savadogo', 'username' => 'aminata_s', 'email' => 'aminata@example.com', 'password' => $password, 'role' => 'user', 'address' => 'Smiltene', 'date_joined' => now()]);

        // --- Custom Master Admins & Staff  ---
        User::create(['id' => 28, 'name' => 'Admin User', 'username' => 'admin', 'email' => 'admin@pawforest.com', 'password' => $password, 'role' => 'admin', 'address' => 'Riga, Latvija', 'date_joined' => now()]);
        DB::table('employees')->insert(['user_id' => 28, 'location_id' => 1, 'phone_number' => '+371 20000010', 'job_title' => 'System Administrator']);

        User::create(['id' => 29, 'name' => 'Employee User', 'username' => 'employee', 'email' => 'employee@pawforest.com', 'password' => $password, 'role' => 'employee', 'address' => 'Riga, Latvija', 'date_joined' => now()]);
        DB::table('employees')->insert(['user_id' => 29, 'location_id' => 1, 'phone_number' => '+371 20000011', 'job_title' => 'Animal Care Specialist']);
    }
}