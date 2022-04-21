<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'use search']);
        Permission::create(['name' => 'view dasboard']);

        Permission::create(['name' => 'view services']);
        Permission::create(['name' => 'view customers']);
        Permission::create(['name' => 'view contacts']);
        Permission::create(['name' => 'view workshops']);
        Permission::create(['name' => 'view units']);
        Permission::create(['name' => 'view agreements']);
        Permission::create(['name' => 'view parts']);
        Permission::create(['name' => 'view activities']);
        Permission::create(['name' => 'view reports']);

        Permission::create(['name' => 'create services']);
        Permission::create(['name' => 'create customers']);
        Permission::create(['name' => 'create contacts']);
        Permission::create(['name' => 'create workshops']);
        Permission::create(['name' => 'create units']);
        Permission::create(['name' => 'create agreements']);
        Permission::create(['name' => 'create parts']);
        Permission::create(['name' => 'create reports']);

        Permission::create(['name' => 'edit services']);
        Permission::create(['name' => 'edit customers']);
        Permission::create(['name' => 'edit contacts']);
        Permission::create(['name' => 'edit workshops']);
        Permission::create(['name' => 'edit units']);
        Permission::create(['name' => 'edit agreements']);
        Permission::create(['name' => 'edit parts']);

        Permission::create(['name' => 'delete services']);
        Permission::create(['name' => 'delete customers']);
        Permission::create(['name' => 'delete contacts']);
        Permission::create(['name' => 'delete workshops']);
        Permission::create(['name' => 'delete units']);
        Permission::create(['name' => 'delete agreements']);
        Permission::create(['name' => 'delete parts']);


        $role = Role::create(['name' => 'workshop'])
        ->givePermissionTo(['view services', 'edit services']
        );
        $role = Role::create(['name' => 'customer'])
        ->givePermissionTo(
            ['view services', 
            'view units', 
            'view contacts',
            'view agreements',
            'create services']
        );

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        // \App\Models\User::factory(10)->create();
        //$user = ['name' => 'Joel Gjerde', 'email' => 'joel@gjerdeinvest.se', 'email_verified_at' => now(), 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => random(10)];
        //\App\Models\User::create($user);
        DB::table('users')->insert([
            'name' => 'Joel Gjerde',
            'email' => 'joel@gjerdeinvest.se',
            'photo' => '/uploads/profile/1/joel.jpeg',
            'password' => Hash::make('hullijoel'),
            'email_verified_at' => now(),
            'is_admin' => '1',
            'role' => 'user',
            'remember_token' => Str::random(10),
            'created_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Arvid Haag',
            'email' => 'arvid@nordicrefinance.se',
            'photo' => '',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_admin' => '1',
            'role' => 'user',
            'remember_token' => Str::random(10),
            'created_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'RailCare',
            'email' => 'anna@gjerdeinvest.se',
            'photo' => '',
            'password' => Hash::make('hullijoel'),
            'email_verified_at' => now(),
            'is_admin' => '0',
            'role' => 'vendor',
            'remember_token' => Str::random(10),
            'created_at' => now()
        ]);

        DB::table('customers')->insert([
            'name' => 'Green Cargo',
            'country' => 'Sweden',
            'created_at' => now()
        ]);
        DB::table('customers')->insert([
            'name' => 'Hector Rail',
            'country' => 'Sweden',
            'created_at' => now()
        ]);
        DB::table('customers')->insert([
            'name' => 'ProTrain',
            'country' => 'Sweden',
            'created_at' => now()
        ]);

        DB::table('units')->insert([
            'unit' => 'RC4-155',
            'make' => 'RC4',
            'model' => '',
            'year_model' => '',
            'traction_force' => '',
            'maintenanceType' => 'Km',
            'customer' => 'ProTrain',
            'created_at' => '2022-01-01'

        ]);

        DB::table('units')->insert([
            'unit' => 'TME-1525',
            'make' => 'TME',
            'model' => '',
            'year_model' => '',
            'traction_force' => '',
            'maintenanceType' => 'Km',
            'customer' => 'Hector Rail',
            'created_at' => '2022-01-01'

        ]);

        DB::table('activities')->insert([
            'activity_type' => 'Unit',
            'activity_id' => '1',
            'activity_message' => 'Unit has been created',
            'created_at' => now()
        ]);
        DB::table('units')->insert([
            'unit' => 'V5-155',
            'make' => 'V5',
            'model' => '',
            'year_model' => '',
            'traction_force' => '',
            'maintenanceType' => 'h',
            'customer' => 'ProTrain',
            'created_at' => '2022-01-01'
        ]);
        DB::table('activities')->insert([
            'activity_type' => 'Unit',
            'activity_id' => '2',
            'activity_message' => 'Unit has been created',
            'created_at' => now()
        ]);
        DB::table('activities')->insert([
            'activity_type' => 'UnitCounter',
            'activity_id' => '2',
            'activity_message' => '10220379',
            'created_at' => now()
        ]);
        DB::table('activities')->insert([
            'activity_type' => 'UnitCounter',
            'activity_id' => '2',
            'activity_message' => '10210979',
            'created_at' => '2022-03-01 12:01'
        ]);
        DB::table('activities')->insert([
            'activity_type' => 'UnitCounter',
            'activity_id' => '1',
            'activity_message' => '8987548',
            'created_at' => now()
        ]);
        DB::table('activities')->insert([
            'activity_type' => 'UnitCounter',
            'activity_id' => '1',
            'activity_message' => '8981470',
            'created_at' => '2022-02-28 08:52'
        ]);
        DB::table('activities')->insert([
            'activity_type' => 'UnitCounter',
            'activity_id' => '1',
            'activity_message' => '8975210',
            'created_at' => '2022-02-21 10:12'
        ]);
        DB::table('activities')->insert([
            'activity_type' => 'UnitCounter',
            'activity_id' => '3',
            'activity_message' => '4298',
            'created_at' => '2022-02-21 10:12'
        ]);

        DB::table('inventory')->insert([
            'unit' => 'RC4-155',
            'partNumber' => '3308207',
            'partName' => 'RC4 strömavtagare',
            'status' => 'New',
            'batch' => '7150',
            'dateMounted' => '2022-03-09',
            'eol' => '2024-02-19',
        ]);

        DB::table('contact')->insert([
            'customer' => 'Hector Rail',
            'name' => 'Anton Undevall',
            'email' => 'anton@gjerdeinvest.se',
            'phone' => '0720213457',
            'created_at' => now()
        ]);

        DB::table('contact')->insert([
            'customer' => 'ProTrain',
            'name' => 'Mia',
            'email' => 'mia@gjerdeinvest.se',
            'phone' => '0720213457',
            'created_at' => now()
        ]);

        DB::table('contact')->insert([
            'customer' => 'Green Cargo',
            'name' => 'Joel Gjerde',
            'email' => 'joel@gc.com',
            'phone' => '07307726111',
            'created_at' => now()
        ]);

        DB::table('serviceType')->insert([
            'service_type' => 'Tillsyn',
            'service_desc' => 'Tillsyn',
            'created_at' => now()
        ]);
        DB::table('serviceType')->insert([
            'service_type' => 'Översyn 1',
            'service_desc' => 'Översyn 1 enligt protokoll',
            'created_at' => now()
        ]);
        DB::table('serviceType')->insert([
            'service_type' => 'Översyn 2',
            'service_desc' => 'Översyn 2 enligt protokoll',
            'created_at' => now()
        ]);
        DB::table('serviceType')->insert([
            'service_type' => 'Översyn 3',
            'service_desc' => 'Översyn 3 enligt protokoll',
            'created_at' => now()
        ]);
        DB::table('serviceType')->insert([
            'service_type' => 'Reparation',
            'service_desc' => 'Reparation enligt lista',
            'created_at' => now()
        ]);

        DB::table('Rent')->insert([
            'unit' => 'RC4-155',
            'customer' => 'ProTrain',
            'rentStart' => '2022-01-01',
            'status' => 'Active',
            'created_at' => now()
        ]);

        DB::table('Rent')->insert([
            'unit' => 'V5-155',
            'customer' => 'ProTrain',
            'rentStart' => '2022-01-01',
            'status' => 'Active',
            'created_at' => now()
        ]);

        DB::table('Rent')->insert([
            'unit' => 'TME-1525',
            'customer' => 'Hector Rail',
            'rentStart' => '2022-02-01',
            'status' => 'Active',
            'created_at' => now()
        ]);

        DB::table('vendors')->insert([
            'Name' => 'RailCare',
            'contact_name' => 'Peter Sundin',
            'contact_email' => 'Joel@gjerdeinvest.se',
            'contact_phone' => '0720213457',
            'address' => 'Långsele',
            'created_at' => now()
        ]);

        DB::table('vendors')->insert([
            'Name' => 'TågKraft',
            'contact_name' => 'Benny',
            'contact_email' => 'Joel@gjerdeinvest.se',
            'contact_phone' => '0720213457',
            'address' => 'Nässjö',
            'created_at' => now()
        ]);

        DB::table('vendors')->insert([
            'Name' => 'Euromaint',
            'contact_name' => 'Tommy',
            'contact_email' => 'Joel@gjerdeinvest.se',
            'contact_phone' => '0720213457',
            'address' => 'Göteborg',
            'created_at' => now()
        ]);

        DB::table('makeList')->insert([
            'make' => 'TME',
            'level' => '1',
            'serviceName' => 'Tillsyn',
            'operationDays' => '21',
            'calendarDays' => '45',
            'counterType' => 'Km',
            'counter' => '5000'
        ]);
        DB::table('makeList')->insert([
            'make' => 'TME',
            'level' => '2',
            'serviceName' => 'Översyn 1',
            'operationDays' => null,
            'calendarDays' => null,
            'counterType' => 'Km',
            'counter' => '25000'
        ]);
        DB::table('makeList')->insert([
            'make' => 'TME',
            'level' => '3',
            'serviceName' => 'Översyn 2',
            'operationDays' => null,
            'calendarDays' => null,
            'counterType' => 'Km',
            'counter' => '50000'
        ]);
        DB::table('makeList')->insert([
            'make' => 'TME',
            'level' => '4',
            'serviceName' => 'Översyn 3',
            'operationDays' => null,
            'calendarDays' => null,
            'counterType' => 'Km',
            'counter' => '100000'
        ]);
        DB::table('makeList')->insert([
            'make' => 'V5',
            'level' => '1',
            'serviceName' => 'Tillsyn',
            'operationDays' => '21',
            'calendarDays' => '60',
            'counterType' => 'h',
            'counter' => null
        ]);
        DB::table('makeList')->insert([
            'make' => 'V5',
            'level' => '2',
            'serviceName' => 'Översyn 1',
            'operationDays' => null,
            'calendarDays' => '365',
            'counterType' => 'h',
            'counter' => '1100'
        ]);
        DB::table('makeList')->insert([
            'make' => 'V5',
            'level' => '3',
            'serviceName' => 'Översyn 3',
            'operationDays' => null,
            'calendarDays' => null,
            'counterType' => 'h',
            'counter' => '4400'
        ]);
        DB::table('makeList')->insert([
            'make' => 'RC4',
            'level' => '1',
            'serviceName' => 'Tillsyn',
            'operationDays' => null,
            'calendarDays' => null,
            'counterType' => 'Km',
            'counter' => '12500'
        ]);
        DB::table('makeList')->insert([
            'make' => 'RC4',
            'level' => '2',
            'serviceName' => 'Översyn 1',
            'operationDays' => null,
            'calendarDays' => null,
            'counterType' => 'Km',
            'counter' => '33000'
        ]);
        DB::table('makeList')->insert([
            'make' => 'RC4',
            'level' => '3',
            'serviceName' => 'Översyn 2',
            'operationDays' => null,
            'calendarDays' => null,
            'counterType' => 'Km',
            'counter' => '100000'
        ]);
        DB::table('makeList')->insert([
            'make' => 'RC4',
            'level' => '4',
            'serviceName' => 'Översyn 3',
            'operationDays' => null,
            'calendarDays' => null,
            'counterType' => 'Km',
            'counter' => '200000'
        ]);
        //\App\Models\Vendors::factory(5)->create();
    }
}
