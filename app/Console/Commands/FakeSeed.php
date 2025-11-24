<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FakeSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insere dados falsos no banco de dados';

    public function handle(): int
    {
        $this->call('db:seed', ['--class' => 'FakeSeeder']);
        $this->info('Dados falsos inseridos com sucesso.');

        return parent::SUCCESS;
    }
}
