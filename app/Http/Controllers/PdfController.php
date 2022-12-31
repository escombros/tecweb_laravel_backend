<?php

namespace App\Http\Controllers;

use App\Http\Facades\Utilities;
use App\Models\Pdf;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseApi;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiValidatorException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Validator;

class PdfController extends Controller
{
    
    use ResponseApi;

    public function store(Request $request){
        try{
            $input = $request->all();

            $rules = [
                'folio'=>'required|String',
            ];

            $validator = Validator::make($input, $rules);

            if ($validator->fails())  return $this->sendError('Validator', $validator->errors()->all(), 422);
       
            $pdf = new Pdf();
            DB::connection('mysql')->table('Pdf')->insert(['folio'=>$input['folio']]);
            Log::info('this works! ');

           // $pdf->folio = $input['folio'];
            
           // $pdf->save();

            return $this->sendResponse($pdf,'Pdf saved');
        }catch (ApiValidatorException $th) {
            return $this->sendError($th->getError(), $th->getMessage(), $th->getCode());
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function createPDF(Request $request){

    }

}
