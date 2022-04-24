<?php

namespace App\Http\Requests\Practices;

use Illuminate\Foundation\Http\FormRequest;

class PracticeRequest extends FormRequest
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
     * @return array
     */
        public function rules()
    {
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }
    /**
     * Define validation rules to store method for resource creation
     *
     * @return array
     */
    public function createRules(): array
    {
        return [
            'practice_name' => 'required|string|max:191',
            'practice_code' => 'max:10',
            'client_name' => 'required|string|max:64',
            'group_npi' => 'required|digits:10',
            // 'tags' => 'required|array',
            // 'photo' => 'sometimes|files',
        ];
    }
    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [
            'practice_name' => 'required|string|max:191',
            'practice_code' => 'max:10',
            'client_name' => 'required|string|max:64',
            'group_npi' => 'required|digits:10',
            // 'tags' => 'required|array',
            // 'photo' => 'sometimes|files',
        ];
    }
}
