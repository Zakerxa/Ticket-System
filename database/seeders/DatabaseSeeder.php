<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Role::truncate();
        Ticket::truncate();

        $staff = Role::create([
            'name'=>'Staff'
        ]);
        $supervisor =  Role::create([
            'name'=>'Supervisor'
        ]);
        $leader = Role::create([
            'name'=>'Leader'
        ]);

        $staff = User::create([
            'name' => 'Mg Mg',
            'email' => 'staff@gmail.com',
            'phone' => '09687717767',
            'role_id'=> $staff->id,
            'password' => 'helloworld'
        ]);
        User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@gmail.com',
            'phone' => '09777637858',
            'role_id' => $supervisor->id,
            'password' => 'helloworld'
        ]);
        User::create([
            'name' => 'Leader',
            'email' => 'leader@gmail.com',
            'phone' => '09763196236',
            'role_id' => $leader->id,
            'password' => 'helloworld'
        ]);

        $ticket = Ticket::create([
            'ticket' => '#05DPXJIWRF6U',
            'title' => 'Web Developement',
            'user_id'=> $staff->id,
            'description' => 'Here is a description of web development.',
        ]);

        $ticket1 = Ticket::create([
            'ticket' => '#04DPEJIWRF2U',
            'title' => 'Application Bug',
            'user_id'=> $staff->id,
            'description' => 'Here is a description of Bug App.',
        ]);

        Log::create([
          'title' => 'created',
          'token' => $ticket['ticket'],
          'user_id' => $staff->id
        ]);

        Log::create([
            'title' => 'created',
            'token' => $ticket1['ticket'],
            'user_id' => $staff->id
          ]);
    }
}
