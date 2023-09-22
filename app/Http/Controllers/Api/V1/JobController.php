<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Job\JobStoreRequest;
use App\Http\Requests\V1\Job\JobUpdateRequest;
use App\Http\Resources\V1\Job\JobDetailsResource;
use App\Http\Resources\V1\Job\JobPaginationResource;
use App\Http\Resources\V1\Jobseeker\JobseekerDetailsResource;
use App\Models\Jobs;
use App\Services\JobService;
use Illuminate\Http\Request;

class JobController extends BaseController
{
    protected $job;
   
    // in this controller we have call the Jobservice where all the model working will be perfrom on this service
    public function __construct(JobService $job)
    {
        $this->job = $job;
    }

    //it is used to fetch all the lists of  job
    public function index(Request $request){

        // $perPage = $request->get('per_page') ? $request->get('per_page') : '30';
        $jobseekers = $this->job->filter($request);

        return $this->success(new JobPaginationResource($jobseekers),'Job lists');
    }

    // it is used to store the job 
    public function store(JobStoreRequest $request){
       
        $this->middleware('company_owner'); // this will check the user type employer to give access
        try{
            $job = $this->job->create($request);  
             return $this->success(new JobDetailsResource($job),'Job has been created successfully');

       }catch(\Exception $e){
           return $this->errors($e->getMessage(),400);
       }   

    }

    // it is used for update job
    public function update(JobUpdateRequest $request, Jobs $jobs){
        $this->middleware('company_owner'); // this will check the user type employer to give access
        try{
              $this->job->update($request,$jobs);
              $job = $this->job->find($jobs->id);
              return $this->success(new JobDetailsResource($job),'Job has been updated successfully');
        }catch(\Exception $e){
            return $this->errors($e->getMessage(),400);
        }
    }
    // it is used to fetch all the details of the job
    public function show(Jobs $jobs){
        try{
            return $this->success(new JobDetailsResource($jobs),'Job details');
        }catch(\Exception $e){
            return $this->errors($e->getMessage(),400);
        }
    }
    // it is used for delete job
    public function destroy(Jobs $jobs){
        $this->middleware('company_owner'); // this will check the user type employer to give access
        try{
            $jobs->delete();
            return $this->success([],'Jobs has been deleted successfully');
        }catch(\Exception $e){
           return  $this->errors($e->getMessage(),400);
        }
    }

    // it is used for the fetch the jobas that match with jobseeker 
    public function match(Request $request){
        
        $this->middleware('jobseeker'); // this will check the user type employer to give access
        try{
            $jobseekers = $this->job->match($request);
            return $this->success(JobDetailsResource::collection($jobseekers),'Jobseeker matching job lists');
        }catch(\Exception $e){
           return  $this->errors($e->getMessage(),400);
        }

    }
}
