<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Administrator;
use App\Models\User;
use App\Models\Driver;
use App\Models\Supervisor;
use App\Models\Client;

class UserSeeder extends Seeder
{
    /**
     * Este seeder crea usuarios específicos.
     */
    public function run(): void
    {
        $this->createUser('admin', 'admin');
        $this->createUser('client', 'client');
        $this->createUser('supervisor', 'supervisor');
        $this->createUser('driver', 'driver');
     
    }

    private function createUser(String $nombre, String $tipo){

        $user = new User([
            ('name')=>$nombre,
            ('lastName')=>$nombre,
            ('phoneNumber')=>'0297-'.rand(100, 999).'-'.rand(1000, 9999),
            ('address')=>'Ciudad Universitaria'.rand(100,999).', CDR',
            ('dni')=>rand(28000000, 30000000),
            ('birthdate')=>now(),
            ('email')=>$nombre.'@google.com',
            ('email_verified_at')=>now(),
            ('password')=>bcrypt('1234')            
        ]);      

        // Con una buena jerarquía de clases para los tipos de usuarios, esto se podría
        // simplificar por medio del uso de polimorfismo.
        switch ($tipo) {
            case 'admin':
                $admin = new Administrator();                

                // Forma correcta de salvar en nuestra tabla polimórfica
                $admin->save();                
                $admin->user()->save($user);
                
                break;

            case 'driver':
                $driver = new Driver([
                    'driver_cuil'=>rand(20,30)*1000000000+($user->dni)*10+rand(1,9),
                    'driver_start_date'=>now(),
                    'driver_state'=>Driver::DISPONIBLE
                ]); 
                
                // Forma correcta de salvar en nuestra tabla polimórfica
                $driver->save();                
                $driver->user()->save($user);               

                break;
            
            case 'supervisor':
                $supervisor = new Supervisor([                           
                    'supervisor_state'=>Supervisor::OPERATIVO,
                    'supervisor_cuil'=>rand(20,30)*1000000000+($user->dni)*10+rand(1,9)
                ]);                 
    
                // Forma correcta de salvar en nuestra tabla polimórfica
                $supervisor->save();                
                $supervisor->user()->save($user);                

                break;

            case 'client':
                $client = new Client([                                              
                    'client_cuil'=>rand(20,30)*1000000000+($user->dni)*10+rand(1,9)
                ]);                 

                // Forma correcta de salvar en nuestra tabla polimórfica
                $client->save();                
                $client->user()->save($user);                

                break;
            
            default:   

                break;
        }
        // Busco todos los usuarios
        $users = User::all();
        // Por cada usuario le asigno un rol
        foreach ($users as $user) {
            $user->assignRole($this->getRole($user->userable_type));
        }        

    }
    // funcion que devuelve un rol correspiendete a la clase especificada en el campo userable_type del modelo User
    private function getRole(String $userable_type){        
        switch ($userable_type) {
            case 'App\Models\Administrator':
                return 'Admin';
                break;
            case 'App\Models\Driver':
                return 'Driver';
                break;
            case 'App\Models\Supervisor':
                return 'Supervisor';
                break;
            case 'App\Models\Client':
                return 'Client';
                break;
            default:
                return 'Client';
                break;
        }
    }
}
