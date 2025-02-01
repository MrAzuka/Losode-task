<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job as ModelJob;
use Illuminate\Support\Facades\Validator;

class Job extends Controller
{
    public function createJob(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'category' => 'required',
            'salary' => 'required',
            'description' => 'required',
            'benefits' => 'required',
            'type' => 'required',
            'work_condition' => 'required'
        ]);

        if ($validate->fails()) {
            return $this->sendErrorResponse(422, 'Validation failed.', $validate->errors()->first());
        }
        try {
            // Get the authenticated user's business_id
            $businessId = $request->user()->id;
            $jobs = ModelJob::create([
                'title' => $request->title,
                'company' => $request->company,
                'location' => $request->location,
                'category' => $request->category,
                'salary' => $request->salary,
                'description' => $request->description,
                'benefits' => $request->benefits,
                'type' => $request->type,
                'work_condition' => $request->work_condition,
                'business_id' => $businessId
            ]);


            return $this->sendSuccessResponse(201, 'Job Created Successfully', $jobs);
        } catch (\Throwable $e) {
            return $this->sendErrorResponse(500, 'Server Error. Please try again later', $e->getMessage());
        }
    }

    public function getAllBusinessJobs(Request $request)
    {
        try {
            $keyword = $request->query('q');

            $query = ModelJob::where('business_id', $request->user()->id);

            // If a keyword is provided, use Scout to search
            if ($keyword) {
                $query->whereIn('id', ModelJob::search($keyword)->keys());
            }

            $jobs = $query->get();

            // Check if no jobs found
            if (empty($jobs)) {
                return $this->sendSuccessResponse(200, 'No jobs found', []);
            }

            // Return the jobs
            return $this->sendSuccessResponse(200, 'All jobs fetched', $jobs);
        } catch (\Throwable $e) {
            return $this->sendErrorResponse(500, 'Server Error. Please try again later', $e->getMessage());
        }
    }

    public function updateJobs(Request $request, $job_id)
    {
        $validationQuery = 'sometimes|required';
        $validate = Validator::make($request->all(), [
            'title' => $validationQuery,
            'company' => $validationQuery,
            'location' => $validationQuery,
            'category' => $validationQuery,
            'salary' => $validationQuery,
            'description' => $validationQuery,
            'benefits' => $validationQuery,
            'type' => $validationQuery,
            'work_condition' => $validationQuery
        ]);

        if ($validate->fails()) {
            return $this->sendErrorResponse(422, 'Validation failed.', $validate->errors()->first());
        }
        try {
            $job = ModelJob::where('id', $job_id)->where('business_id', $request->user()->id)->first();

            // Check if no jobs found
            if (empty($job)) {
                return $this->sendErrorResponse(404, 'No job found');
            }

            $job->update($request->all());
            return $this->sendSuccessResponse(200, 'Job updated successfully', $job);
        } catch (\Throwable $e) {
            return $this->sendErrorResponse(500, 'Server Error. Please try again later', $e->getMessage());
        }
    }
}
