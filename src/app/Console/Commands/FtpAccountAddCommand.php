<?php

namespace App\Console\Commands;

use App\Data\Models\Domain;
use App\Data\Repositories\Interfaces\DomainRepository;
use App\Features\CreateAccountFeature;
use Illuminate\Console\Command;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Lucid\Foundation\ServesFeaturesTrait;

class FtpAccountAddCommand extends Command
{
    use ServesFeaturesTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:account:add {domain} {login} 
                                                {--dir=/} 
                                                {--desc=}
                                                {--pass=secret}
                                                {--status=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new account.';

    protected $domain;

    /**
     * Create a new command instance.
     *
     * @param $account
     * @param $domain
     * @return void
     */
    public function __construct(Domain $domain)
    {
        parent::__construct();

        $this->domain = $domain;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Request $request, DomainRepository $domainRepository)
    {
        try {
            $domain = $domainRepository->findByField('name', $this->argument('domain'))->first();

            $request->replace([
                'domain_id' => $domain->id,
                'login' => $this->argument('login'),
                'password' => $this->option('pass'),
                'status' => $this->option('status'),
                'relative_dir' => $this->option('dir'),
                'description' => $this->option('desc'),
            ]);
            $account = $this->serve(CreateAccountFeature::class)->getData()->data;
            $this->info('Account #' . $account->id . ' ' . $account->login . ' added.');
        } catch (ValidationException $e) {
            $this->error($e->getMessage());
            foreach ($e->errors() as $field => $errors) {
                $this->error($field . ': ' . implode(' ', $errors));
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
