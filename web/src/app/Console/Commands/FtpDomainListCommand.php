<?php

namespace App\Console\Commands;

use App\Data\Models\Domain;
use App\Features\ListDomainsFeature;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Lucid\Bus\ServesFeatures;

class FtpDomainListCommand extends BaseCommand
{
    use ServesFeatures;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:domain:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List existing domains.';

    /**
     * @var Domain
     */
    protected $domain;

    /**
     * Create a new command instance.
     *
     * @param Domain $domain
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
    public function handle(Request $request)
    {
        $columns = ['id', 'name', 'created_at'];

        try {
            $request->replace([
                'paginate' => false,
                'columns' => $columns,
            ]);

            $accounts = $this->serve(ListDomainsFeature::class)->getData(true)['data'];

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
