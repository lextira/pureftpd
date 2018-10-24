<?php

namespace App\Console\Commands;

use App\Console\FakeRoute;
use App\Data\Repositories\Interfaces\AccountRepository;
use App\Features\UpdateAccountFeature;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Lucid\Foundation\ServesFeaturesTrait;

class FtpAccountChangeCommand extends BaseCommand
{
    use ServesFeaturesTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:account:change {login}
                                                {--dir=/} 
                                                {--desc=}
                                                {--pass=secret}
                                                {--status=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change an existing account.';

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
     * @param Request $request
     * @param AccountRepository $accountRepository
     * @return mixed
     */
    public function handle(Request $request, AccountRepository $accountRepository)
    {
        try {
            $account = $accountRepository->firstByFieldOrFail('login', $this->argument('login'));

            $request->replace([
                'password' => $this->option('pass'),
                'status' => $this->option('status'),
                'relative_dir' => $this->option('dir'),
                'description' => $this->option('desc'),
            ]);

            $request->setRouteResolver(function() use ($account) {
                return new FakeRoute(['account' => $account->id]);
            });

            $account = $this->serve(UpdateAccountFeature::class)->getData()->data;
            $this->info('Account #' . $account->id . ' ' . $account->login . ' updated.');
        } catch (ValidationException $e) {
            $this->handleValidationError($e);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
