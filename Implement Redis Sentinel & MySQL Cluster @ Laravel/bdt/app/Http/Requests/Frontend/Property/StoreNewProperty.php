<?php

namespace App\Http\Requests\Frontend\Property;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewProperty extends FormRequest
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
        return [
            'name' => 'required', 
            'built_up' => 'required_if:property_type,1,2,4,5,6|integer|min:0',
            'land_size' => 'required_if:property_type,1,3,4,5,6|integer|min:0',
            'price' => 'required|integer|min:1',
            'address' => 'required',
            // 'agent_id' => 'required',
            'listing_type' => 'required',
            'property_type' => 'required',
            'description' => 'required',
            // 'area' => 'required|integer|min:0',
            'bedrooms' => 'required_if:property_type:1,2,6|integer|min:0',
            'bathrooms' => 'required_if:property_type:1,2,4,6|integer|min:0',
            // 'beds' => 'required|integer|min:0',
            'garages' => 'nullable|integer|min:0',
            'cities' => 'required|numeric',
            'subdistrict' => 'required|numeric',
            'maid_bedrooms' => 'nullable|integer|min:0',
            'maid_bathrooms' => 'nullable|integer|min:0',
            'certificate' => 'required_if:property_type:1,2,3,4,5|min:1',
            'year_built' => 'required_if:property_type:1,2,4,5,6',
            'electrical_power' => 'required_if:property_type:1,2,4,5,6|integer|min:0',
            'amount_of_down_payment' => 'nullable|integer|min:0',
            'estimated_installments' => 'nullable|integer|min:0',
            'complete_address' =>'required',
            'owner_name' => 'required',
            'owner_phone' =>'required',
            'floor_number' => 'required_with:property_type:2|min:0',
            'parking_amount' => 'required_with:property_type:4|integer|min:0',
            'number_of_floors' => 'required_if:property_type:1,4|integer|min:0',
            'colisting' => 'nullable|numeric'
        ];
    }

    protected function validationData()
    {

        $this->merge(['price'=>(int)str_replace('.','',$this->price)]);
        // dd($this);
        $this->merge(['amount_of_down_payment'=>(int)str_replace('.','',$this->amount_of_down_payment)]);
        // dd($this);
        return $this->all();
    }


    public function messages(){
        return [
            'required' => ':attribute wajib diisi!',
            'integer' => ":attribute harus bernilai bilangan!",
            'required_if' => ":attribute wajib diisi!",
            'required_with' => ":attribute wajib diisi!",
            'min' => ':attribute harus bernilai bilangan positif!',
            'certificate.min' => "Sertifikat tidak boleh kosong!",
            'price.min' => "Harga tidak boleh 0!",
            'floor_number.min' => "Nomer Lantai tidak boleh kosong!"
        ];
    }

    public function attributes(){
        return [
            'name' => 'Nama Properti',
            'built_up' => "Luas Bangunan",
            'land_size' => "Luas Tanah",
            'price' => "Harga",
            'address' => "Alamat",
            'listing_type' => "Tipe",
            'property_type' => 'Kategori',
            'description' => "Deskripsi",
            'bedrooms' => "Kamar Tidur",
            'bathrooms' => "Kamar Mandi",
            'garages' => "Garasi",
            "cities" => "Kota",
            'subdistrict' => "Kecamatan",
            "maid_bedrooms" => "Kamar Tidur Pembantu",
            "maid_bathrooms" => "Kamar Mandi Pembantu",
            "certificate" => "Sertifikat",
            "year_built" => "Tahun Dibangun",
            "electrical_power" => "Daya Listrik",
            "amount_of_down_payment" => "DP",
            "estimated_installments" => "Estimasi Cicilan",
            "complete_address" => "Alamat Lengkap",
            "owner_name" => "Nama Pemilik",
            "owner_phone" => "Telepon Pemilik",
            "floor_number" => "No Lantai",
            "parking_amount" => "Parkir",
            "number_of_floors" => "Jumlah Lantai",
            'colisting' => 'Co-Listing'
        ];
    }
}
