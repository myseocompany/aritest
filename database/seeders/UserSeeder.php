<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {

        User::create([
            'name' => 'JOHAN STEVEN SOLARTE PINCHAO',
            'email' => 'johan.solarte@uao.edu.co',
            'password' => bcrypt('1113532511'),
        ]);
        
        
        User::create([
            'name' => 'DIANA MARCELA VARGAS GALEANO',
            'email' => 'diana_mar.vargas@uao.edu.co',
            'password' => bcrypt('1107054595'),
        ]);
        
        
        User::create([
            'name' => 'ANGUIE ESTEFANY BENAVIDES FERNANDEZ',
            'email' => 'anguie_est.benavides@uao.edu.co',
            'password' => bcrypt('1005867968'),
        ]);
        
        
        User::create([
            'name' => 'MARIANA RENDON VARELA',
            'email' => 'mariana.rendon@uao.edu.co',
            'password' => bcrypt('1006102416'),
        ]);
        
        
        User::create([
            'name' => 'LUIS MIGUEL TORO CASTRO',
            'email' => 'luis.toro@uao.edu.co',
            'password' => bcrypt('1144180497'),
        ]);
        
        
        User::create([
            'name' => 'DANIEL FELIPE LOPEZ VARGAS',
            'email' => 'daniel_fel.lopez@uao.edu.co',
            'password' => bcrypt('1144211826'),
        ]);
        
        
        User::create([
            'name' => 'VIVIAN VANESSA HOYOS LOPEZ',
            'email' => 'vivian_van.hoyos@uao.edu.co',
            'password' => bcrypt('1143843371'),
        ]);
        
        
        User::create([
            'name' => 'KELLY JOHANNA ENCISO RUBIO',
            'email' => 'kelly_joh.enciso@uao.edu.co',
            'password' => bcrypt('1144066479'),
        ]);
        
        
        User::create([
            'name' => 'DIANA LUCERO BARONA VALENCIA',
            'email' => 'diana_luc.barona@uao.edu.co',
            'password' => bcrypt('1144109846'),
        ]);
        
        
        User::create([
            'name' => 'KATHLERIN GISETH JULICUE  TOQUICA',
            'email' => 'kathlerin.julicue@uao.edu.co',
            'password' => bcrypt('1062329132'),
        ]);
        
        
        User::create([
            'name' => 'VALENTINA GARCIA VILLARRAGA',
            'email' => 'valentina.garcia_v@uao.edu.co',
            'password' => bcrypt('1006170177'),
        ]);

        // Crear un usuario admin (si es necesario)
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
