<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project_data = new \stdClass();
        if (Auth::user()->role=='engineer') {
            $project_data = Projects::where('status','!=','archived')->get();
        }else{
            $project_data = Projects::where('user_id',Auth::user()->id)->where('status','!=','archived')->get();
        }
        foreach ($project_data as $key => $value) {
            $project_data[$key] = $value;
             $project_data[$key]->user_name = $project_data[$key]->engineer_name = '';
            if ($user = User::where('id',$value->user_id)->first()) {
                $project_data[$key]->user_name = $user->username;
            }
            if ($engineer = User::where('id',$value->engineer_user_id)->first()) {
                $project_data[$key]->engineer_name = $engineer->username;
            }
        }
        if ($project_data == null || $project_data == '') {
            return response()->json(["status" => false, "message" => 'Record not found', 'data' => array()]);
        }
        try {
            return response()->json(["status" => true, "message" => 'Record found successfully..!', "data" => $project_data]);
        } catch (\Throwable $th) {
            $error_code = $th->getCode();
            return response()->json(["status" => false, "message" => 'Result not found..!', 'data' => $project_data]);
        } catch (\Exception $ex) {
            $error_code = $ex->getCode();
            return response()->json(["status" => false, "message" => $ex->getMessage(), 'data' => $project_data]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->id) {
            return response()->json(["status" => false, "message" => 'Authentication is requried']);
        }

        $project_data = new \stdClass();
        $data = array(
            "user_id"=>Auth::user()->id,
            "engineer_user_id"=>$request->engineer_user_id ? $request->engineer_user_id : 0,
            "address"=>$request->address,
            "city"=>$request->city,
            "state"=>$request->state,
            "zip"=>$request->zip,
            "county"=>$request->county,
            "project_name"=>$request->project_name,
            "client_po"=>$request->client_po,
            "project_number"=>$request->project_number,
            "project_notes"=>$request->project_notes,
            "type"=>$request->type,
            "status"=>$request->status,
        );
        try {
            $project_data = [];
            $accounts = Projects::create($data);
            return response()->json(["status" => true, "message" => 'Data stored successfully..!', "data" => $accounts]);
        } catch (\Throwable $th) {
            $error_code = $th->getCode();
            return response()->json(["status" => false, "message" => 'Data not stored..!', 'error' => $th]);
        } catch (\Exception $ex) {
            $error_code = $ex->getCode();
            return response()->json(["status" => false, "message" => $ex->getMessage(), 'data' => $project_data]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function getProjectById($id)
    {
        $project_data = new \stdClass();
        $project_data = Projects::find($id);
        if ($engineer = User::where('id',$project_data->engineer_user_id)->first()) {
            $project_data->engineer_name = $engineer->username;
        }
        if ($project_data == null || $project_data == '') {
            return response()->json(["status" => false, "message" => 'Record not found', 'data' => array()]);
        }
        try {
            return response()->json(["status" => true, "message" => 'Data Found', "data" => $project_data]);
        } catch (\Throwable $th) {
            $error_code = $th->getCode();
            return response()->json(["status" => false, "message" => 'Result not found..!', 'data' => $response_data]);
        } catch (\Exception $ex) {
            $error_code = $ex->getCode();
            return response()->json(["status" => false, "message" => $ex->getMessage(), 'data' => $response_data]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function edit(Projects $projects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project_data = new \stdClass();
        $account_info = Projects::find($id);
        $project_data = [];
        if ($account_info == null || $account_info == '') {
            return response()->json(["status" => false, "message" => 'Data Not Found', 'data' => $project_data]);
        }

        $data = array(
            "user_id"=>Auth::user()->id,
            "engineer_user_id"=>$request->engineer_user_id,
            "address"=>$request->address,
            "city"=>$request->city,
            "state"=>$request->state,
            "zip"=>$request->zip,
            "county"=>$request->county,
            "project_name"=>$request->project_name,
            "client_po"=>$request->client_po,
            "project_number"=>$request->project_number,
            "project_notes"=>$request->project_notes,
            "type"=>$request->type,
            "status"=>$request->status,
        );

        try {
            $project_data = [];
            Projects::where('id', $id)->update($data);
            $account_info = Projects::findOrfail($id);
            return response()->json(["status" => true, "message" => 'Record updated successfully', "data" => $account_info]);
        } catch (\Throwable $th) {
            $error_code = $th->getCode();
            return response()->json(["status" => false, "message" => $th->getMessage(), 'data' => $project_data]);
        } catch (\Exception $ex) {
            $error_code = $ex->getCode();
            return response()->json(["status" => false, "message" => $ex->getMessage(), 'data' => $project_data]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account_data = new \stdClass();
        try {
            $account_data = [];
            Projects::where('id', $id)->delete();
            return response()->json(["status" => true, "message" => 'Record deleted successfully']);
        } catch (\Throwable $th) {
            $error_code = $th->getCode();
            return response()->json(["status" => false, "message" => $th->getMessage(), 'data' => $account_data]);
        } catch (\Exception $ex) {
            $error_code = $ex->getCode();
            return response()->json(["status" => false, "message" => $ex->getMessage(), 'data' => $account_data]);
        }
    }

    public function changeProjectStatus(Request $request, $id)
    {
        $account_info = Projects::find($id);
        $project_data = [];
        if ($account_info == null || $account_info == '') {
            return response()->json(["status" => false, "message" => 'Data Not Found', 'data' => $project_data]);
        }

        $data = array(
            "engineer_user_id"=>$request->engineer_user_id,
            "status"=>$request->status,
        );

        try {
            $project_data = [];
            Projects::where('id', $id)->update($data);
            $account_info = Projects::findOrfail($id);
            return response()->json(["status" => true, "message" => 'Project completed successfully', "data" => $account_info]);
        } catch (\Throwable $th) {
            $error_code = $th->getCode();
            return response()->json(["status" => false, "message" => $th->getMessage(), 'data' => $project_data]);
        } catch (\Exception $ex) {
            $error_code = $ex->getCode();
            return response()->json(["status" => false, "message" => $ex->getMessage(), 'data' => $project_data]);
        }
    }
}