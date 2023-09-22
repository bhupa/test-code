<?php

namespace App\Services;

use App\Http\Resources\V1\Matching\FavouriteResource;
use App\Http\Resources\V1\Matching\MatchingReceiveResource;
use App\Http\Resources\V1\Matching\MatchingResource;
use App\Http\Resources\V1\Matching\MatchingSentResource;
use App\Models\Jobs;
use App\Models\Matching;
use Carbon\Carbon;

class MatchingService extends BaseService
{
    public function __construct(Matching $matching)
    {
        $this->model = $matching;
    }

      // this function isused  for sending the matching request
    public function create($request)
    {
        $message = 'Alerady added in mactching';
        $data = '';
        $check = '';
        if (auth()->user()->user_type === 1) {
            $job = Jobs::find($request->job_id);
            $check = $this->checkJobseeker($job->id, $job->user->compnay->id);
            $data = ($check) ? '' : $this->common($request);
        } else {
            $check = $this->cehckEmployer($request, auth()->user()->company->id);
            $data = ($check) ? '' : $this->common($request);
        }
        if (!empty($data)) {
            $data['created_by'] = auth()->id();

            return $this->model->create($data);
        }

        return ['message' => $message, 'check' => $check];
    }

  // this function isused to check the job seeker exists in matching database or not with give field
    public function checkJobseeker($request)
    {
        return $this->model->where('job_seeker_id', $request->job_seeker_id)
                               ->where('company_id', $request->company_id)->first();
    }

    // this function isused to check the employer exists in matching database or not with give field
    public function cehckEmployer($request, $companyId)
    {
        return $this->model->where('job_seeker_id', $request->job_seeker_id)
                                ->where('job_id', $request->job_id)
                               ->where('company_id', $companyId)->first();
    }

   // thisfunction is used forto add and remove the favourite lists
   public function favourite($request)
   {
       $favourite = ($request->favourite == 1) ? auth()->id() : null;

       $output = '';
       // $data['favourite_by'] =  $favourite;
       if (auth()->user()->user_type === 1) {
           $companyId = $request->company_id;
           $jobseekerId = auth()->user()->jobseeker->id;
       } else {
           $companyId = auth()->user()->company->id;
           $jobseekerId = $request->job_seeker_id;
       }
       $favouriteBy = auth()->id();
       $createdBy = auth()->id();
       $result = [
        'company_id' => $companyId,
        'job_seeker_id' => $jobseekerId,
        'favourite_by' => $favouriteBy,
        'created_by' => $createdBy,
       ];

       $old = Matching::where($result)->first();

       if (empty($favourite) && !empty($old)) {
           $old->delete();
           $output = [];
           $message = 'Remove from favourite list succesfully';
       }
       if (!empty($favourite) && !empty($old)) {
           $output = $old;
           $message = 'Already added to favourite list succesfully';
       }
       if (empty($old) && !empty($favourite)) {
           $output = $this->model->create($result);
           $message = 'Added to favourite list succesfully';
       }
       if (empty($old) && empty($favourite)) {
           $message = 'First it sould be add to favourite list  after that we can only remove from favourite lists succesfully';
       }

       return [
          'data' => $output,
          'message' => $message,
       ];
   }

     // this function is used for matching accept and refuse
   public function accept($request, $matching)
   {
       if (auth()->user()->user_type === 1) {
           $data['job_id'] = $request->job_id;
       } else {
           $data['job_seeker_id'] = $request->job_seeker_id;
       }if ($request->type === 'accept') {
           $data['matched'] = Carbon::today();
       } else {
           $data['unmatched'] = Carbon::today();
       }

       $matching->update($data);

       return $this->model->find($matching->id);
   }

   public function common($request)
   {
       if (auth()->user()->user_type === 1) {
           $data['job_id'] = $request->job_id;
           $job = Jobs::find($request->job_id);
           $data['company_id'] = $job->company->id;
       } else {
           $data['company_id'] = auth()->user()->company->id;
           $data['job_seeker_id'] = $request->job_seeker_id;
       }
    //    $data['created_by'] = auth()->id();

       return $data;
   }
    // this function is used to get all the request of the matching

   public function getAllsentRequest($type)
   {
       $query = new Matching();
       $column = (auth()->user()->user_type == 1) ? 'job_seeker_id' : 'company_id';
       $value = (auth()->user()->user_type == 1) ? auth()->user()->jobseeker->id : auth()->user()->company->id;
       if ($type == 'created_by') {
           return $this->sent($query, $type);
       } elseif ($type == 'received') {
           return $this->received($query, $value, $column);
       } elseif ($type == 'match') {
           return $this->matched($query, $column);
       } elseif ($type == 'favourite_by') {
           return $this->favourites($query, $type);
       }

       return $query;
   }

  // this function will fetch all the matching received
   public function received($query, $value, $column)
   {
       $query = $query->with(['company.jobs' => function ($query) {
           $query->where('status', 1);
       }])->whereNull('favourite_by')
                  ->whereNull('job_id')
                  ->whereNull('matched')
                   ->whereNull('unmatched')
                   ->where($column, $value)
                   ->orderBy('created_at', 'desc')->get();

       return MatchingReceiveResource::collection($query);
   }

  // this function will fetch all the matching request to user
   public function sent($query, $type)
   {
       $output = $query->with(['company', 'company.user', 'job'])->whereNull('favourite_by')->where($type, auth()->id())->orderBy('created_at', 'desc')->get();

       return MatchingSentResource::collection($output);
   }

   // this function will fetch all the matching jobs and company forjobseeker and jobseeker for company
   public function matched($query, $column)
   {
       $userId = (auth()->user()->user_type == 1) ? auth()->user()->jobseeker->id : auth()->user()->company->id;

       $query = $query->with(['company', 'job'])->whereNull('favourite_by')->whereNotNull('matched')->where(function ($query) use ($column, $userId) {
           $query->where($column, $userId);
       })->orderBy('created_at', 'desc')->get();

       return MatchingResource::collection($query);
   }

   // this function will fetch all the favourite lists of the login user
   public function favourites($query, $type)
   {
       $query = $query
       ->whereNull('job_id')
       ->whereNull('matched')
       ->whereNull('unmatched')
       ->where($type, auth()->id())->orderBy('created_at', 'desc')->get();

       return FavouriteResource::collection($query);
   }
}
