<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          //creo una variable user que es una nueva instancia de mi Modelo User
        $user= new User();
        $user->name= "Carmen Blanco";
        $user->email="carmen@hotmail.com";
        $user->password=bcrypt("12345678");
        $user->save();

         User::factory(10)->create();


    }
}
