<?php

namespace App\Http\Requests;

use App\Data\Repositories\Interfaces\AccountRepository;
use App\Rules\UniqueLogin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param AccountRepository $accountRepository
     * @return array
     */
    public function rules(AccountRepository $accountRepository)
    {
        $domainID = $this->input('domain_id');
        $accountID = $this->route('account');
        if (!$domainID) {
            $domainID = $accountRepository->find($accountID, ['domain_id'])->domain_id;
        }

        $uniqueLoginRule = new UniqueLogin($accountRepository, $domainID, $accountID);

        return [
            'domain_id' => 'exists:domains,id',
            'login' => ['max:255', $uniqueLoginRule],
            'hashed_password' => 'max:255',
            'status' => 'integer',
            'relative_dir' => 'max:255',
            'description' => 'max:255',
        ];
    }
}
