<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'JOHAN STEVEN SOLARTE PINCHAO',
                'email' => 'johan.solarte@uao.edu.co',
                'password' => bcrypt('1113532511'),
            ],
            [
                'name' => 'DIANA MARCELA VARGAS GALEANO',
                'email' => 'diana_mar.vargas@uao.edu.co',
                'password' => bcrypt('1107054595'),
            ],
            [
                'name' => 'ANGUIE ESTEFANY BENAVIDES FERNANDEZ',
                'email' => 'anguie_est.benavides@uao.edu.co',
                'password' => bcrypt('1005867968'),
            ],
            [
                'name' => 'MARIANA RENDON VARELA',
                'email' => 'mariana.rendon@uao.edu.co',
                'password' => bcrypt('1006102416'),
            ],
            [
                'name' => 'LUIS MIGUEL TORO CASTRO',
                'email' => 'luis.toro@uao.edu.co',
                'password' => bcrypt('1144180497'),
            ],
            [
                'name' => 'DANIEL FELIPE LOPEZ VARGAS',
                'email' => 'daniel_fel.lopez@uao.edu.co',
                'password' => bcrypt('1144211826'),
            ],
            [
                'name' => 'VIVIAN VANESSA HOYOS LOPEZ',
                'email' => 'vivian_van.hoyos@uao.edu.co',
                'password' => bcrypt('1143843371'),
            ],
            [
                'name' => 'KELLY JOHANNA ENCISO RUBIO',
                'email' => 'kelly_joh.enciso@uao.edu.co',
                'password' => bcrypt('1144066479'),
            ],
            [
                'name' => 'DIANA LUCERO BARONA VALENCIA',
                'email' => 'diana_luc.barona@uao.edu.co',
                'password' => bcrypt('1144109846'),
            ],
            [
                'name' => 'KATHLERIN GISETH JULICUE TOQUICA',
                'email' => 'kathlerin.julicue@uao.edu.co',
                'password' => bcrypt('1062329132'),
            ],
            [
                'name' => 'VALENTINA GARCIA VILLARRAGA',
                'email' => 'valentina.garcia_v@uao.edu.co',
                'password' => bcrypt('1006170177'),
            ],
            // Crear un usuario admin (si es necesario)
            [
                'name' => 'Administrador',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
            ],
        ];
    
        foreach ($users as $user) {
            User::create($user);
        }
    }
}