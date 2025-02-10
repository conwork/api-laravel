<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class RevokeUserTokens extends Command
{
    protected $signature = 'app:revoke-all-user-tokens {--user_id=}';
    protected $description = 'Delete all personal access tokens for the given user_id.';
    public function handle()
    {
        $userId = $this->option('user_id');

        if (!$userId) {
            $this->error('Please provide a valid --user_id.');
            return 1;
        }

        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID $userId not found.");
            return 1;
        }

        $user->tokens()->delete();

        $this->info("All personal access tokens for user ID $userId have been deleted.");
        return 0;
    }
}
