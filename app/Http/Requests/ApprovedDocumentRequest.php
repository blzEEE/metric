<?php

namespace App\Http\Requests;

use App\Models\InputDocument;
use App\Models\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ApprovedDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $inputDocument = InputDocument::findOrFail($this->id);

        return Auth::user()->user_role_id === UserRole::ROLE_SYSADMIN
            || (Auth::user()->company_id === $inputDocument->company_id && $this->getMethod() === 'POST');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:input_documents,id'],
        ];
    }
}
