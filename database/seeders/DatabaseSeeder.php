<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Create user 'joe'
        $userId = DB::table('users')->insertGetId([
            'name' => 'john',
            'email' => 'john@example.com', // Use a unique email for the user
            'password' => Hash::make('1'), // Encrypt password
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create workspaces
        for ($i = 1; $i <= 3; $i++) {
            $workspaceId = DB::table('workspaces')->insertGetId([
                'uuid' => Str::uuid(),
                'name' => "workspace{$i}",
                'detail' => "Detail for workspace{$i}",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Assign user to workspace
            DB::table('userspaces')->insert([
                'user_id' => $userId,
                'workspace_id' => $workspaceId,
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create 2 tasks per workspace
            for ($j = 1; $j <= 2; $j++) {
                DB::table('tasks')->insert([
                    'name' => "Task {$j} in workspace{$i}",
                    'detail' => "Details for task {$j} in workspace{$i}",
                    'is_completed' => false,
                    'workspace_id' => $workspaceId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $userId1 = DB::table('users')->insertGetId([
            'name' => 'joe',
            'email' => 'joe@example.com', // Use a unique email for the user
            'password' => Hash::make('1'), // Encrypt password
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        for ($i = 4; $i <= 6; $i++) {
            $workspaceId = DB::table('workspaces')->insertGetId([
                'uuid' => Str::uuid(),
                'name' => "workspace{$i}",
                'detail' => "Detail for workspace{$i}",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Assign user to workspace
            DB::table('userspaces')->insert([
                'user_id' => $userId1,
                'workspace_id' => $workspaceId,
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create 2 tasks per workspace
            for ($j = 1; $j <= 2; $j++) {
                DB::table('tasks')->insert([
                    'name' => "Task {$j} in workspace{$i}",
                    'detail' => "Details for task {$j} in workspace{$i}",
                    'is_completed' => false,
                    'workspace_id' => $workspaceId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        for ($i=1; $i <=3 ; $i++) { 
            DB::table('userspaces')->updateOrInsert([
                'user_id' => $userId1,
                'workspace_id' => $i,
                'is_admin' => false,
                'request' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
