<?php

namespace App\Services;

use App\Models\Company;

class CompanyService extends BaseService
{
    public function __construct(Company $company)
    {
        $this->model = $company;
    }

      // this function is used to create company
     public function create($request)
     {
         $data = $request->except('_token', 'image', 'logo', 'job');
         $data['user_id'] = auth()->id();
         $data['status'] = 1;
         if ($request->hasFile('logo')) {
             $data['logo'] = $this->uploadImg($request->logo, 'company/logo');
         }

         return $this->model->create($data);
     }

     // this function is used to update company
     public function update($request, $company)
     {
         $data = $request->except('_token', 'image', 'logo', 'image_ids');
         if ($request->hasFile('logo')) {
             $data['logo'] = $this->uploadImg($request->logo, 'company/logo');
             $this->deleteImage($company->logo);
         }

         return tap($company->update($data));
     }

     // this function is used for the filter of the company
     public function filter($request)
     {
         $companies = Company::query();

         if ($request->has('company_name') && $request->company_name !== null && $request->company_name !== '') {
             $companies->where('company_name', 'like', '%'.$request->company_name.'%');
         }

         if ($request->has('address') && $request->address !== null && $request->address !== '') {
             $companies->where('address', 'like', '%'.$request->address.'%');
         }

         $perPage = $request->has('per_page') ? $request->get('per_page') : '30';

         return $companies->paginate($perPage);
     }
}
