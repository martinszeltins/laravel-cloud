<?php

namespace App\Http\Requests;

use App\Models\StorageProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDatabaseBackupRequest extends FormRequest
{
    /**
     * Get the storage provider instance.
     *
     * @return \App\Models\StorageProvider
     */
    public function storageProvider()
    {
        return StorageProvider::find($this->storage_provider_id);
    }

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
        return [
            'storage_provider_id' => ['required', Rule::exists('storage_providers', 'id')->where(function ($query) {
                $query->where('user_id', $this->user()->id);
            })],
            'database_name' => 'required|string|max:255',
        ];
    }
}
