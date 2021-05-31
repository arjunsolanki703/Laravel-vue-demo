<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Files;
use Illuminate\Http\Request;
use Auth;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $filename = '';
        $images_destination = public_path('files');
        if ($request->hasfile('filename')) {
            $image = $request->file('filename');
            if ($image) {
                $filename = md5(rand('111111', '999999')) . '.' . $image->getClientOriginalExtension();
                $image->move($images_destination, $filename);
            }
        }

        $response_data = new \stdClass();
        $data = array(
            "user_id" => Auth::user()->id,
            "comment_id" => $request->comment_id,
            "path" => $images_destination.'/'.$filename,
            "filename" => $filename,
        );
        try {
            $response_data = [];
            $audioBooks = Files::create($data);
            if ($audioBooks->image) {
                $audioBooks->image = env('APP_URL') . 'public/files/' . $audioBooks->image;
            }
            return response()->json(["status" => true, "message" => 'Data Found', "data" => $audioBooks]);
        } catch (\Throwable $th) {
            // dd($th);
            $error_code = $th->getCode();
            return response()->json(["status" => false, "message" => 'Data not stored..!', 'data' => $response_data]);
        } catch (\Exception $ex) {
            $error_code = $ex->getCode();
            return response()->json(["status" => false, "message" => $ex->getMessage(), 'data' => $response_data]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function show(Files $files)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function edit(Files $files)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Files $files)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function destroy(Files $files)
    {
        //
    }
}
