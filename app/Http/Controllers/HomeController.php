<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use XMLReader;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function uploadKml(Request $request)
    {   
      
        // $request->validate([
        //     'kml_file' => 'required|mimes:kml',
        // ]);
    
        $kmlFile = $request->file('kml_file');
        $filename = time() . '.' . $request->file('kml_file')->getClientOriginalExtension();

        $path = Storage::disk('s3')->put(
            'kmls/'.$filename,
            file_get_contents($kmlFile),
            'public'
        );
        $s3url="https://denizkml2.s3.eu-central-1.amazonaws.com/kmls/".$filename;
        $kmlPath = $kmlFile->storeAs('public/uploads' ,$filename);
        // $s3 = Storage::disk('s3')->getAdapter()->getClient();
        // $s3path= $s3->getObjectUrl( env('AWS_BUCKET'), $kmlPath);

        if ($this->validateKmlFile($kmlPath)) {
            
            return view('map', ['kmlPath' => $s3url]);
        } else {
            return back()->with('error', 'Invalid KML file.');
        }
   
    }


    private function validateKmlFile($kmlPath)
{
    $xml = new XMLReader();
    $xml->open(storage_path('app/'.$kmlPath));

    while ($xml->read()) {
        if ($xml->nodeType === XMLReader::ELEMENT && $xml->name === 'kml') {
          
            return true; // Valid KML file
        }
    }

    return false; // Invalid KML file
}
}
