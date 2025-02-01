<?php

namespace App\Http\Controllers;

use cloudinary;
use Illuminate\Http\Request;
use App\Models\Job as ModelJob;
use App\Models\Guest as ModelGuest;
use Illuminate\Support\Facades\Validator;

class Guest extends Controller
{
    public function getAllJobs(Request $request)
    {
        try {
            $jobs = ModelJob::latest('created_at')->get();

            // Check if no jobs found
            if (empty($jobs)) {
                return $this->sendErrorResponse(404, 'No jobs found', []);
            }

            // Return the jobs
            return $this->sendSuccessResponse(200, 'All jobs fetched', $jobs);
        } catch (\Throwable $e) {
            return $this->sendErrorResponse(500, 'Server Error. Please try again later', $e->getMessage());
        }
    }
    public function getSpecificJob(Request $request, $job_id)
    {
        try {
            $jobs = ModelJob::where('id', $job_id)->first();

            // Check if no jobs found
            if (empty($jobs)) {
                return $this->sendErrorResponse(404, 'No job found', []);
            }

            // Return the jobs
            return $this->sendSuccessResponse(200, 'Job details fetched', $jobs);
        } catch (\Throwable $e) {
            return $this->sendErrorResponse(500, 'Server Error. Please try again later', $e->getMessage());
        }
    }

    public function applyForJobs(Request $request, $job_id)
    {
        $cv_url = cloudinary()->upload($request->file('cv')->getRealPath())->getSecurePath();

        try {
            $validate = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|string',
                'phone' => 'required|string',
                'location' => 'required|string',
            ]);

            if ($validate->fails()) {
                return $this->sendErrorResponse(422, 'Validation failed.', $validate->errors()->first());
            }

            $jobs = ModelGuest::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'location' => $request->location,
                'cv' => $cv_url,
                'job_id' => $job_id
            ]);


            return $this->sendSuccessResponse(201, 'Job Application Successfully', $jobs);
        } catch (\Throwable $e) {
            return $this->sendErrorResponse(500, 'Server Error. Please try again later', $e->getMessage());
        }
    }
}
