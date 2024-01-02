<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolClient = Role::create(['name' => 'Client']);
        $rolAdmin = Role::create(['name' => 'Admin']);
        $rolSupervisor = Role::create(['name' => 'Supervisor']);
        $rolDriver = Role::create(['name' => 'Driver']);

        //CHOFER
        Permission::create(['name' => 'driver.showTravelPlan'])->syncRoles([$rolDriver]);
        Permission::create(['name' => 'travel-report.modify'])->syncRoles([$rolDriver]);

        //SUPERVISOR
        Permission::create(['name' => 'itinerary.index'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'itinerary.create'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'itinerary.edit'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'itinerary.show'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'itinerary.store'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'itinerary.destroyService'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'itinerary.destroy'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'itinerary.update'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'itinerary.allocate-resources'])->syncRoles([$rolSupervisor]);


        Permission::create(['name' => 'assistant.edit'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'assistant.update'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'assistant.destroy'])->syncRoles([$rolSupervisor]);

        Permission::create(['name' => 'unit.index'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'unit.edit'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'unit.update'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'unit.destroy'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'unit.create'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'unit.store'])->syncRoles([$rolSupervisor]);
        //FALTAN PERMISOS DE UNIDAD

        Permission::create(['name' => 'driver.edit'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'driver.update'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'driver.destroy'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'driver.giveRest'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'driver.enable'])->syncRoles([$rolSupervisor]);

        Permission::create(['name' => 'service.list-services'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'service.show'])->syncRoles([$rolSupervisor]);

        Permission::create(['name' => 'travel-report.index'])->syncRoles([$rolSupervisor]);
        Permission::create(['name' => 'travel-report.read'])->syncRoles([$rolSupervisor]);
        
        Permission::create(['name' => 'supervisor.create.employee'])->syncRoles([$rolSupervisor]);

        //ADMIN
        Permission::create(['name' => 'contract.index'])->syncRoles([$rolAdmin]);
        Permission::create(['name' => 'contract.show'])->syncRoles([$rolAdmin]);
        Permission::create(['name' => 'contract.waitingApproval'])->syncRoles([$rolAdmin]);
        Permission::create(['name' => 'contract.approve'])->syncRoles([$rolAdmin]);
        Permission::create(['name' => 'contract.enabled'])->syncRoles([$rolAdmin]);

        Permission::create(['name' => 'admin.create.supervisor'])->syncRoles([$rolAdmin]);

        Permission::create(['name' => 'supervisor.index'])->syncRoles([$rolAdmin]);
        Permission::create(['name' => 'client.index'])->syncRoles([$rolAdmin]);

        Permission::create(['name' => 'reports.all'])->syncRoles([$rolAdmin]);

        //FALTAN PERMISOS DE CONTRATO PARA RECHAZAR, reportes


        //CLIENTE
        Permission::create(['name' => 'contract.create'])->syncRoles([$rolClient]);
        Permission::create(['name' => 'contract.store'])->syncRoles([$rolClient]);
        Permission::create(['name' => 'contract.showContractClient'])->syncRoles([$rolClient]);

        Permission::create(['name' => 'services.index'])->syncRoles([$rolClient]);
        Permission::create(['name' => 'services.add-service'])->syncRoles([$rolClient]);

        Permission::create(['name' => 'payment.index'])->syncRoles([$rolClient]);
        Permission::create(['name' => 'payment.create'])->syncRoles([$rolClient]);

        Permission::create(['name' => 'fee.index'])->syncRoles([$rolClient]);
        Permission::create(['name' => 'fee.update'])->syncRoles([$rolClient]);

        Permission::create(['name' => 'user.edit'])->syncRoles([$rolClient]);
        Permission::create(['name' => 'user.update'])->syncRoles([$rolClient]);


        //ADMIN Y SUPERVISOR
        Permission::create(['name' => 'driver.index'])->syncRoles([$rolAdmin, $rolSupervisor]);
        Permission::create(['name' => 'driver.show'])->syncRoles([$rolAdmin, $rolSupervisor]);
        Permission::create(['name' => 'assistant.index'])->syncRoles([$rolAdmin, $rolSupervisor]);

        //ADMIN SUPER Y DRIVER
        Permission::create(['name' => 'passenger.show'])->syncRoles([$rolAdmin, $rolSupervisor, $rolDriver]);
    }
}
