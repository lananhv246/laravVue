<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Exports\CsvExport;
use Symfony\Component\HttpFoundation\Response;
use App\Imports\CsvImport;
use App\Http\Resources\UserResource;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class CsvController extends Controller
{
    public function index() {
        $users = User::latest()->paginate(20);
        return UserResource::collection($users)->additional(['meta'=>[
            'version' => '1.0.0',
            'API_base_url' => url('/'),
        ]]);
    }

    /**
     * import
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request) {
        $file = $request->file('file');
        Excel::import(new CsvImport, $file);
        //return back();
        return response()->json(null, Response::HTTP_OK);
    }

    
    /**
     * import update
     * @return \Illuminate\Support\Collection
     */
    public function update(Request $request) {
        $table = User::getModel()->getTable();
        $file = $request->file('file');
        if($file === null || $file === '') {
            return response()->json('Please check file...', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $data = Excel::toArray(new CsvImport, $file);
        $excels =[];
        foreach ($data as $key => $value) {
            # code...
            $excels = $value;
        }
        // values to update
        $values = [['id' => '22','name' =>'Barca',  'email' => 'argentina@gmail.com'],
                    ['id' => '23','name' =>'Man Utd','email' => 'portugal@gmail.com'],
                    ['id' => '24','name' =>'Chelsea','email' => 'egypte@gmail.com']];
        // dd($values);

        $cases = [];
        $ids = [];
        $param1 = []; // for the first column
        $param2 = []; // for the Seconde column
        $params = []; // for merging all columns
        // dd($excels);
        foreach ($excels as $value) {
            # code...
            $value= $value;
            $id = (int)$value['id'];
            $cases[] = "WHEN {$id} then ?";
            $param1[] =$value['name'];
            $param2[] =$value['email'];
            $ids[] = $id;
        }
        # check...
        $users = User::all();
        $arrId =[];
        foreach ($users as $user) {
            # code...
            #check exist
            if(in_array($user->email,$param2)) {
            return  response()->json('Email `'.$user->email.'` exist...!!!', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            $arrId[] = $user->id;
        }
        $result = array_diff($ids, $arrId);
        $dataInserts =[];
        foreach ($excels as $value) {
            # code...
            $value= $value;
            $id = (int)$value['id'];
            if(in_array($id, $result) && $id) {
                $value['id'] = (int)$value['id'];
                $value['password'] = \Hash::make($value['password']);
                $dataInserts[] = $value;
            }
        }
        User::insert($dataInserts);
        $params=array_merge($param1,$param2);

        $ids = implode(',', $ids);
        $cases = implode(' ', $cases);
        \DB::update("UPDATE `{$table}` 
             SET `name`    = CASE `id` {$cases} END ,
                 `email` = CASE `id` {$cases} END 
             WHERE `id` in ({$ids})", $params);
        ////_______________
        return response()->json('Success...!!!', Response::HTTP_OK);
    }
    /**
     * export
     * @return \Illuminate\Support\Collection
     */
    public function export() {
        $tableUser = User::getModel()->getTable();
        return Excel::download(new CsvExport(), time() .'_'. $tableUser . '.xlsx');
    }
}
