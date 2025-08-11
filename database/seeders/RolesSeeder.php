<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $perms = [
            'events.view','events.create','events.update','events.delete','events.publish',
            'venues.manage',
            'tickets.manage',
            'registrations.create','registrations.manage',
            'payments.manage',
            'checkin.manage',
        ];
        foreach ($perms as $p) { Permission::firstOrCreate(['name'=>$p, 'guard_name'=>'web']); }

        $admin = Role::firstOrCreate(['name'=>'admin']);
        $organizer = Role::firstOrCreate(['name'=>'organizer']);
        $viewer = Role::firstOrCreate(['name'=>'viewer']);

        $admin->syncPermissions(Permission::all());
        $organizer->syncPermissions([
            'events.view','events.create','events.update','events.publish',
            'venues.manage','tickets.manage','registrations.create','registrations.manage',
            'payments.manage','checkin.manage',
        ]);
        $viewer->syncPermissions(['events.view']);
    }
}
