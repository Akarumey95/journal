<?php

namespace App\Http\Controllers;

use App\journals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JournalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = journals::all();
        return view('home', [
            'data' => $data,
            'file_path' => 'storage/app/public/',
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $data = journals::all();
        return view('admin', ['data' => $data]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $id
     * @return \Illuminate\Http\Response
     */
    public function getJournal($id=null)
    {
        $full_path = config('app.url', 'http://localhost:3000') . '/storage/app/public/';

        try{
            if($id == null){
                $data = journals::all();
            }else{
                $data = journals::where('id', $id)->get();
            }
        }catch (\mysqli_sql_exception $e){
            $msg = ['status' => 400, 'msg' => $e];
        }

        if(!empty($data)){
            foreach ($data as $item){
                $item->journal_path = $full_path . $item->journal_path;
                $item->poster_path = $full_path . $item->poster_path;
            }

            $msg = ['status' => 200, 'data' => $data];
        }

        echo json_encode($msg);
        //return json_encode($msg);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pdf = $request->file('journal');
        $poster = $request->file('poster');
        if($pdf && $poster){
            if($pdf->extension() == 'pdf') {
                $journal_path = $pdf->store('journals', 'public');
                $poster_path = $poster->store('posters', 'public');

                journals::create([
                    'name' => $request['name'],
                    'journal_path' => $journal_path,
                    'poster_path' => $poster_path,
                ]);

                $msg = ['status' => 200, 'journal' => $request['name'], 'msg' => 'Journal saved'];
            }else{
                $msg = ['status'=>400, 'journal' => $request['name'], 'msg' => 'File extension not correct'];
            }
        }else{
            $msg = ['status'=>400, 'journal' => $request['name'], 'msg' => 'Journal not saved'];
        }

        return json_encode($msg);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $data = journals::where('id', $request['id'])->get()[0];
        Storage::disk('public')->delete($data->journal_path);
        Storage::disk('public')->delete($data->poster_path);

        if(!Storage::disk('public')->exists($data->journal_path) &&
        !Storage::disk('public')->exists($data->poster_path)){
            journals::where('id', $request['id'])->delete();
            $msg = ['status'=>200, 'journal' => $data->name, 'msg' => 'Journal deleted'];
        }else{
            $msg = ['status'=>400, 'journal' => $data->name, 'msg' => 'Journal not deleted'];
        }

        return json_encode($msg);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return void
     */
    public function show($id)
    {
        $data = journals::where('id', $id)->get()[0];
        return view('journal', [
            'data' => $data,
            'file_path' => 'storage/app/public/',
        ]);
    }
}
