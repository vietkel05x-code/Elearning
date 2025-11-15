<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:fix-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix admin password by hashing it if it is plain text';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admin = User::where('email', 'admin@example.com')->first();

        if (!$admin) {
            $this->error('Admin user not found!');
            return 1;
        }

        // Check if password is plain text (doesn't start with $2y$)
        if (!str_starts_with($admin->password, '$2y$')) {
            $admin->password = Hash::make('12345678');
            $admin->save();
            $this->info('Admin password has been hashed successfully!');
        } else {
            $this->info('Admin password is already hashed.');
        }

        return 0;
    }
}
