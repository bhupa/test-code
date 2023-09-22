<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\Jobseeker\JobseekerStoreRequest;
use App\Http\Requests\V1\Jobseeker\JobseekerUpdateRequest;
use App\Http\Resources\V1\Jobseeker\JobseekerDetailsResource;
use App\Http\Resources\V1\Jobseeker\JobseekerPaginationResource;
use App\Models\Jobseeker;
use App\Services\ImageFileService;
use App\Services\JobseekerService;
use Illuminate\Http\Request;

class JobSeekerController extends BaseController
{
    protected $jobseekerservice;

    protected $imagefileservice;

    // in this controller we have call the jobseekerService where all the model working will be perfrom on this service
    public function __construct(JobseekerService $jobseekerservice, ImageFileService $imagefileservice)
    {
        $this->jobseekerservice = $jobseekerservice;
        $this->imagefileservice = $imagefileservice;
    }

    //  it is used to fetch all the jobseeker lists
    public function index(Request $request)
    {
        // $perPage = $request->get('per_page') ? $request->get('per_page') : '30';
        $jobseekers = $this->jobseekerservice->filter($request);

        return $this->success(new JobseekerPaginationResource($jobseekers), 'Jobseeker lists');
    }

    // this function will create the jobseeker
    public function store(JobseekerStoreRequest $request)
    {
        $this->middleware('jobseeker'); // this will check the user type jobseeker to give access
        try {
            if (auth()->user()->jobseeker) {
                return $this->success(new JobseekerDetailsResource(auth()->user()->jobseeker), 'Jobseeker account already exists');
            }
            $output = $this->jobseekerservice->create($request);

            $id = $output->id;
            $model = 'App\Models\Jobseeker';
            if ($request->hasFile('image')) {
                $this->imagefileservice->create($id, $request->image, $model, 'jobseeker');
            }

            return $this->success(new JobseekerDetailsResource($output), 'Jobseeker created successfully');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }

    // this function will update the jobseeker
    public function update(JobseekerUpdateRequest $request, Jobseeker $jobseeker)
    {
        $this->middleware('jobseeker'); // this will check the user type jobseeker to give access
        try {
            $this->jobseekerservice->update($request, $jobseeker);
            $id = $jobseeker->id;
            $model = 'App\Models\Jobseeker';
            if ($request->hasFile('image')) {
                $this->imagefileservice->create($id, $request->image, $model, 'jobseeker');
            }
            if ($request->has('image_ids')) {
                $this->imagefileservice->deleteBulkImage($request->image_ids);
            }
            $output = $this->jobseekerservice->find($jobseeker->id);

            return $this->success(new JobseekerDetailsResource($output), 'Jobseeker updated successfully');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }

    // it is used to get the details of the jobseeker
    public function show(Jobseeker $jobseeker)
    {
        try {
            return $this->success(new JobseekerDetailsResource($jobseeker), 'Jobseeker details');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }

     // it is used to get the delete  jobseeker
    public function destroy(Jobseeker $jobseeker)
    {
        $this->middleware('jobseeker'); // this will check the user type jobseeker to give access
        try {
            $this->jobseekerservice->deleteImage($jobseeker->image);
            $jobseeker->delete();

            return $this->success([], 'Jobseeker deleted successfully');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }

 // this function is used to get the jobseeker details of login jobseeker
    public function getJobSeekerDetails()
    {
        $jobseeker = Jobseeker::where('user_id', auth()->id())->first();
        if ($jobseeker) {
            return $this->success(new JobseekerDetailsResource($jobseeker), 'Jobseeker details');
        }

        return $this->errors('Jobseeker not found', 404);
    }
}
