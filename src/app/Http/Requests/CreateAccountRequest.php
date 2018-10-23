<?php

namespace App\Http\Requests;

use App\Data\Repositories\Interfaces\AccountRepository;
use App\Rules\UniqueLogin;
use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
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
        $uniqueLoginRule = new UniqueLogin($accountRepository, $domainID);

        return [
            'domain_id' => 'required|exists:domains,id',
            'login' => ['required', 'regex:/^[a-zA-Z_0-9\.]+$/u', 'max:255', $uniqueLoginRule],
            'password' => 'required_without:hashed_password',
            'hashed_password' => 'required_without:password|max:255',
            'status' => 'integer',
            'relative_dir' => 'required|regex:/^[a-zA-Z_\/0-9]+$/u|max:255',
            'description' => 'max:255',
        ];
    }
}
