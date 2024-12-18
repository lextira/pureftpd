<?php

namespace App\Console\Commands;

use App\Console\FakeRoute;
use App\Data\Models\Account;
use App\Data\Models\Domain;
use App\Data\Repositories\Interfaces\AccountRepository;
use App\Features\DeleteAccountFeature;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Lucid\Bus\ServesFeatures;

class FtpAccountRmCommand extends BaseCommand
{
    use ServesFeatures;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:account:rm {login}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove an account.';

    protected $account;
    protected $domain;

    /**
     * Create a new command instance.
     *
     * @param $account
     * @param $domain
     * @return void
     */
    public function __construct(Account $account, Domain $domain)
    {
        parent::__construct();

        $this->account = $account;
        $this->domain = $domain;
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

            $request->setRouteResolver(function() use ($account) {
                return new FakeRoute(['account' => $account->id]);
            });

            $this->serve(DeleteAccountFeature::class);
            $this->info('Account #' . $account->id . ' was deleted.');
        } catch (ValidationException $e) {
            $this->handleValidationError($e);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
