<?php

namespace App\Console\Commands;

use App\Data\Models\Account;
use App\Data\Models\Domain;
use App\Data\Repositories\Interfaces\DomainRepository;
use App\Features\ListAccountsFeature;
use Illuminate\Http\Request;
use Lucid\Bus\ServesFeatures;

class FtpAccountListCommand extends BaseCommand
{
    use ServesFeatures;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:account:list {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List existing accounts of a domain.';

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
     * @return mixed
     */
    public function handle(Request $request, DomainRepository $domainRepository)
    {
        $columns = ['id', 'created_at', 'updated_at', 'login', 'status', 'relative_dir', 'description'];

        try {
            $domain = $domainRepository->firstByFieldOrFail('name', $this->argument('domain'));

            $request->replace([
                'domain_id' => $domain->id,
                'paginate' => false,
                'columns' => $columns,
            ]);

            $accounts = $this->serve(ListAccountsFeature::class)->getData(true)['data'];

            $this->table(
                $columns,
                $accounts
            );
        } catch (ValidationException $e) {
            $this->handleValidationError($e);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
