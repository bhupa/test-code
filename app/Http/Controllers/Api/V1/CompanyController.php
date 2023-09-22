<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\Company\CompanyStoreRequest;
use App\Http\Requests\V1\Company\CompanyUpdateRequest;
use App\Http\Resources\V1\Company\CompanyDetailsResource;
use App\Http\Resources\V1\Company\CompanyPaginationResource;
use App\Http\Resources\V1\ImageFile\ImageFileResource;
use App\Http\Resources\V1\Job\JobDetailsResource;
use App\Http\Resources\V1\User\UserDetailsResources;
use App\Models\Company;
use App\Services\CompanyService;
use App\Services\ImageFileService;
use App\Services\JobService;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{
    protected $companyservice;
    protected $imagefileservice;
    protected $jobservice;

    // in this controller we have call the CompanyService,ImageFileService  where all the model working will be perfrom on this service
    public function __construct(CompanyService $companyservice, ImageFileService $imagefileservice, JobService $jobservice)
    {
        $this->companyservice = $companyservice;
        $this->imagefileservice = $imagefileservice;
        $this->jobservice = $jobservice;
    }

    // this function will fetch all the lists of the company
    public function index(Request $request)
    {
        $jobseekers = $this->companyservice->filter($request);

        return $this->success(new CompanyPaginationResource($jobseekers), 'Job lists');
    }

    // it is used to create the company
    public function store(CompanyStoreRequest $request)
    {
        $this->middleware('company_owner');  // this will check if user is employer to create company
        try {
            if (empty(auth()->user()->company)) {
                $company = $this->companyservice->create($request);
                $id = $company->id;
                $model = 'App\Models\Company';
                if ($request->hasFile('image')) {
                    $this->imagefileservice->create($id, $request->image, $model, 'company');
                }

                $job = $this->jobservice->create($request);
                $output = [
                'id' => $company->id,
                'companyName' => $company->company_name,
                'aboutCompany' => $company->about_company,
                'address' => $company->address,
                'status' => $company->status,
                'logo' => url('/').'/storage/'.$company->logo,
                'image' => ImageFileResource::collection($company->images),
                'user' => new UserDetailsResources($company->user),
                'job' => new JobDetailsResource($job),
                ];

                return $this->success($output, 'Company added successfully');
            }

            return $this->success(new CompanyDetailsResource(auth()->user()->company), 'Company already created');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }

    // it is used for the company update
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $this->middleware('company_owner');  // this will check if user is employer to update company
        try {
            $this->companyservice->update($request, $company);
            $id = $company->id;
            $model = 'App\Models\Company';
            if ($request->hasFile('image')) {
                $this->imagefileservice->create($id, $request->image, $model, 'company');
            }
            if ($request->has('image_ids')) {
                $this->imagefileservice->deleteBulkImage($request->image_ids);
            }
            $output = $this->companyservice->find($company->id);

            return $this->success(new CompanyDetailsResource($output), 'Company updated successfully');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }

    // it is used fto fetch the company details
    public function show(Company $company)
    {
        try {
            return $this->success(new CompanyDetailsResource($company), 'Company details');
        } catch (\Exception $e) {
            $this->errors($e->getMessage(), 400);
        }
    }

    // it is used to delete the destroy
    public function destroy(Company $company)
    {
        $this->middleware('company_owner');  // this will check if user is employer to delete company
        try {
            $company->delete();

            return $this->success([], 'Company deleted successfully');
        } catch (\Exception $e) {
            $this->errors($e->getMessage(), 400);
        }
    }

     // this function is used to get the compnay details for the login user
    public function getCompanyDetails()
    {
        $company = Company::where('user_id', auth()->id())->first();
        if ($company) {
            return $this->success(new CompanyDetailsResource($company), 'Company details');
        }

        return $this->errors('Company not found', 404);
    }
}
