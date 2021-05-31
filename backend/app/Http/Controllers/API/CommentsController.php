<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Comments;
use App\Models\Files;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project_data = new \stdClass();
        $project_data = Comments::where('user_id',Auth::user()->id)->get();
        foreach ($project_data as $key => $value) {
            $project_data[$key] = $value;
            $project_data[$key]->user_name = User::find($value->user_id)->name;
        }

        if ($project_data == null || $project_data == '' || count($project_data) == 0) {
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
            "project_id"=>$request->project_id,
            "content"=>$request->content,
        );

        $all_files = array();
        if ($request->hasfile('file')) {
            $files = $request->file('file');
            foreach ($files as $image) {
            $filename = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $filename = rand(1111,5555)."-".date('his')."-".rand(0000,9999).".".$extension;
            $images_destination = public_path('files');
            $image->move($images_destination, $filename);
            $all_files[] = $filename;
        }
    }
        try {
            $project_data = [];
            $accounts = Comments::create($data);
            $images_array = array(
                "user_id"=>Auth::user()->id,
                "comment_id"=>$accounts->id,
                "path"=>env('APP_URL') . '/public/files/' ,
                "filename"=>json_encode($all_files),
            );
            $accounts = Files::create($images_array);
            return response()->json(["status" => true, "message" => 'Data stored successfully..!', "data" => $accounts]);
        } catch (\Throwable $th) {
            $error_code = $th->getCode();
            return response()->json(["status" => false, "message" => 'Data not stored..!', 'error' => $th]);
        } catch (\Exception $ex) {
            $error_code = $ex->getCode();
            return response()->json(["status" => false, "message" => $ex->getMessage(), 'data' => $project_data]);
        }
    }

    public function getCommentByProjectId($id)
    {
        $comment_data = Comments::where('project_id',$id)->get();
        foreach ($comment_data as $key => $value) {
            $comment_data[$key] = $value;
            $comment_data[$key]->user_name = User::find($value->user_id)->username;
            if ($files = Files::where('comment_id',$value->id)->first()) {
                $comment_data[$key]->filename = json_decode($files->filename);
                $comment_data[$key]->path = $files->path;
            }
        }
        if ($comment_data == null || $comment_data == '') {
            return response()->json(["status" => false, "message" => 'Record not found', 'data' => array()]);
        }
        try {
            return response()->json(["status" => true, "message" => 'Record Found successfully', "data" => $comment_data]);
        } catch (\Throwable $th) {
            $error_code = $th->getCode();
            return response()->json(["status" => false, "message" => 'Result not found..!', 'data' => $response_data]);
        } catch (\Exception $ex) {
            $error_code = $ex->getCode();
            return response()->json(["status" => false, "message" => $ex->getMessage(), 'data' => $response_data]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function show(Comments $comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function edit(Comments $comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comments $comments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account_data = new \stdClass();
        try {
            $account_data = [];
            Comments::where('id', $id)->delete();
            return response()->json(["status" => true, "message" => 'Record deleted successfully']);
        } catch (\Throwable $th) {
            $error_code = $th->getCode();
            return response()->json(["status" => false, "message" => $th->getMessage(), 'data' => $account_data]);
        } catch (\Exception $ex) {
            $error_code = $ex->getCode();
            return response()->json(["status" => false, "message" => $ex->getMessage(), 'data' => $account_data]);
        }
    }
}