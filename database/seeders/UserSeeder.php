<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  
        $users = [
            [
            'id' => '1',
            'physicianCode' => 'abc-0000',
            'lastName' => 'cmsc-128',
            'firstName' => 'Admin',
            'middleName' => 'admin',
            'birthday' => date('2002-01-01'),
            'cnumber' => '09668100343',
            'address' => 'Japan',
            'email' => 'ehr.project.cmsc@gmail.com',
            'password' => '$2y$10$z0GheeixdpGfB3yXYB5WGuJIMnlUAwZowxNXMJqwfzd2AuHHBMJVa',
            'department' => 'Admin',
            'status' => 'Active',
            'license' => '000-000-0000',
            'updated_at' => date('2023-10-22 14:36:59'),
            'created_at' => date('2023-10-22 14:36:59'),
            ],
            [
            'id' => '2',
            'physicianCode' => 'abc-0000',
            'lastName' => 'Suba',
            'firstName' => 'OdeDjinn Caezar',
            'middleName' => 'Ybañez',
            'birthday' => date('2002-02-26'),
            'cnumber' => '09668100343',
            'address' => 'Norway',
            'email' => 'oysuba@up.edu.ph',
            'password' => '$2y$10$joiQ9Av8.1SrHhIXWfEx4.vJ11uZJE.sqKtMX/e/gZVEdse.XExs2',
            'department' => 'Admin',
            'status' => 'Active',
            'license' => '000-000-0001',
            'updated_at' => date('2023-10-22 14:39:39'),
            'created_at' => date('2023-10-22 14:39:39'),
            ],
            [
            'id' => '3',
            'physicianCode' => 'abc-1028',
            'lastName' => 'Buizon',
            'firstName' => 'Hannah Gabrielle',
            'middleName' => 'Diego',
            'birthday' => date('2002-10-28'),
            'cnumber' => '09989409766',
            'address' => 'Korea',
            'email' => 'hdbuizon@up.edu.ph',
            'password' => '$2y$10$zGpG8vBLgMLpf53lvyWU5.wAKhlWvRjvGosdvjrcqdqOuv7Q8egii',
            'department' => 'Family Medicine',
            'status' => 'Active',
            'license' => '000-000-0002',
            'updated_at' => date('2023-10-22 14:39:39'),
            'created_at' => date('2023-10-22 14:39:39'),
            ],
            [
            'id' => '4',
            'physicianCode' => 'abc-1303',
            'lastName' => 'Azarraga',
            'firstName' => 'Danielle Cyrele',
            'middleName' => 'Dela Cruz',
            'birthday' => date('2003-03-13'),
            'cnumber' => '09071316873',
            'address' => 'Singapore',
            'email' => 'ddazarraga@up.edu.ph',
            'password' => '$2y$10$2QXKQqm4.PZPvqABilAQnebmgCcivE8SP8hvNJp/52weBKQ25/OBq',
            'department' => 'Physical Therapist',
            'status' => 'Active',
            'license' => '000-000-0003',
            'updated_at' => date('2023-10-22 14:39:39'),
            'created_at' => date('2023-10-22 14:39:39'),
            ],
            [
            'id' => '5',
            'physicianCode' => 'abc-0000',
            'lastName' => 'Subingsubing',
            'firstName' => 'Bryan',
            'middleName' => 'Santos',
            'birthday' => date('2003-02-13'),
            'cnumber' => '09333765774',
            'address' => 'England',
            'email' => 'bssubingsubing@up.edu.ph',
            'password' => '$2y$10$j4XyX0E3dSL0Do8Idu3JZuNH4LFiqWHEB6ivBwP2e32ZGo6SkrAza',
            'department' => 'Admin',
            'status' => 'Active',
            'license' => '000-000-0004',
            'updated_at' => date('2023-10-22 14:39:39'),
            'created_at' => date('2023-10-22 14:39:39'),
            ],
            ];
        DB::table('users')->insert($users);
    }
}
