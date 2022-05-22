<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
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
            'individual_npi' => 'required|digits:10',
            'full_name' => 'required|string|max:50',
            'tax_id' => 'required|digits:9',
            'ssn' => 'required|digits:9',
            'speciality' => 'max:50',
            'taxonomy' => 'max:50',
            'home_street' => 'max:50',
            'home_city' => 'max:50',
            'home_state' => 'max:50',
            'home_zip' => 'max:50',
            'cell' => 'max:50',
            'gender' => 'max:50',
            'email' => 'max:50',
//            'dob' => 'max:50',
            'dob' => 'nullable|date',
//            'password' => 'string|max:50',
            'rail_road_group' => 'max:50',
            'ptan' => 'max:50',
            'caqh_user' => 'max:50',
            'caqh_pass' => 'max:50',
            'caqh_id' => 'max:50',
            'pecos_user' => 'max:50',
            'pecos_pass' => 'max:50',
            'manager_name' => 'max:50',
            'manager_email' => 'max:50',
            'manager_contact' => 'max:50',
            'medicaid_id' => 'max:50',
            'grp_madicaid_id' => 'max:50',
            'grp_mrc_id' => 'max:50',
            'medicaid_user' => 'max:50',
            'medicare_id' => 'max:50',
//            'website' => 'string|max:50',
            'dea' => 'max:50',
            'dea_certification_number' => 'max:50',
            'dea_effective_date' => 'max:50',
            'dea_expiry_date' => 'max:50',
//            'state_license' => 'string|max:50',
            'cds_license_option' => 'max:50',
            'cds_license_number' => 'max:50',
            'cds_effective_date' => 'max:50',
            'cds_expiry_date' => 'max:50',
//            'hospital_affiliation' => 'string|max:50',
//            'hospital_name' => 'string|max:50',
//            'hospital_effective_date' => 'date|max:50',
//            'hospital_expiry_date' => 'date|max:50',
            'state_license_option' => 'max:50',
            'state_license_number' => 'max:50',
            'state_license_date' => 'max:50',
            'state_license_expiry' => 'max:50',
//            'status' => 'string|max:50',
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
            'individual_npi' => 'required|digits:10',
            'full_name' => 'required|string|max:50',
            'tax_id' => 'required|digits:9',
            'ssn' => 'required|digits:9',
            'speciality' => 'max:50',
            'taxonomy' => 'max:50',
            'home_street' => 'max:50',
            'home_city' => 'max:50',
            'home_state' => 'max:50',
            'home_zip' => 'max:50',
            'cell' => 'max:50',
            'gender' => 'max:50',
            'email' => 'max:50',
//            'dob' => 'max:50',
            'dob' => 'nullable|date',
//            'password' => 'string|max:50',
            'rail_road_group' => 'max:50',
            'ptan' => 'max:50',
            'manager_name' => 'max:50',
            'manager_email' => 'max:50',
            'manager_contact' => 'max:50',
            'medicaid_id' => 'max:50',
            'grp_madicaid_id' => 'max:50',
            'grp_mrc_id' => 'max:50',
            'medicaid_user' => 'max:50',
            'medicare_id' => 'max:50',
//            'website' => 'string|max:50',
            'dea' => 'max:50',
            'dea_certification_number' => 'max:50',
            'dea_effective_date' => 'max:50',
            'dea_expiry_date' => 'max:50',
//            'state_license' => 'string|max:50',
            'cds_license_option' => 'max:50',
            'cds_license_number' => 'max:50',
            'cds_effective_date' => 'max:50',
            'cds_expiry_date' => 'max:50',
//            'hospital_affiliation' => 'string|max:50',
//            'hospital_name' => 'string|max:50',
//            'hospital_effective_date' => 'date|max:50',
//            'hospital_expiry_date' => 'date|max:50',
            'state_license_option' => 'max:50',
            'state_license_number' => 'max:50',
            'state_license_date' => 'max:50',
            'state_license_expiry' => 'max:50',
//            'status' => 'string|max:50',
        ];
    }
}
