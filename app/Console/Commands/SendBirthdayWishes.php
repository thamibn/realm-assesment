<?php

namespace App\Console\Commands;

use App\Services\RealmAPI;
use App\Services\SendMessages;
use Illuminate\Console\Command;

class SendBirthdayWishes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:wishes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to send birthday wishes to employees';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Sending out realm employees birthday wishes, hang tight');
        $sendMessages = new SendMessages(new RealmAPI());
        $sendMessages->sendBirthdayWishes();
        $this->info('Done!, bye');
        return Command::SUCCESS;
    }
}
