<?php
/**
 *  app/Http/Requests/Admin/ServiceRequest.php
 *
 * Date-Time: 06.08.21
 * Time: 14:56
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;


class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        // Check if method is get,fields are nullable.
        if ($this->method() === 'GET') {
            return [];
        }

        return [
            config('translatable.fallback_locale') . '.title' => 'required',
        ];
    }
}
