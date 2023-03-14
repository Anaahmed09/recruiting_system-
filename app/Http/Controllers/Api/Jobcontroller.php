<?php

namespace App\Http\Controllers\Api;
use App\Models\Job;
use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
class Jobcontroller extends Controller
{
    //
    function index()
    {
        $jobs = Job::paginate();
        return response()->json(['jobs' => $jobs]);
    }

    function show($id)
    {
        $job = Job::where('id',$id)->get();
        return response()->json(['job' => $job]);
    }

    function destroy($id)
    {
       Question::where('job_id',$id)->delete(); 
       $job = Job::with('user')->get();

        for($i=0 ; $i<count($job); $i++ )
        {
            foreach($job[$i]->user as $user)
            {
                $pivot=$user->pivot->where('job_id',$id)->delete();
            }
        }

        Job::where('id',$id)->delete();
    }

    
    function store(JobRequest $request)
    {
        $jobcreate=[
            'title'=> $request->input('title'),
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'end_data' => $request->input('end_data'),
            'admin_id' => $request->input('admin_id')
          // 'admin_id'=> Auth::Admin()->id

        ];

        $job = Job::create($request->all());
        // $job = Job::create($jobcreate);
        return response()->json(['job' => $job]);
    }

    function edit(JobRequest $request,$id)
    {
        $job=Job::where('id',$id);
        $job->update($request->except(['_method', '_token']));
    }

    function count()
    {
        $jobs = Job::get()->count();
        return response()->json(['jobcount' => $jobs]);
    }
    
    function available()
    {
        $date=now();
        $job=Job::where('end_data','>',$date)->get();
        return response()->json([$job]);
    }

    function search(Request $request)
    {
        $key = $request->input('key');
        $results = Job::where('title', 'LIKE', "%{$key}%")->get();
        return response()->json(['results' => $results]);
    }
}
