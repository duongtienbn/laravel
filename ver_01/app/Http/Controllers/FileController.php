<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;

class FileController extends Controller
{
    // maybe better to use config????????)
    const USER_DIRECTORY = 'user_files';

    public function index($id)
    {
        $student = Student::find($id);
        $folderName = $student->folder_name;

        // user folder is null
        if($folderName === null){
            // generate new user folderName
            $student->folder_name = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);
            $student->save();
        }
        $folderName = $student->folder_name;

        // check "uploads" directory if not exist
        if (!Storage::exists(self::USER_DIRECTORY . "/". $folderName)) {
            Storage::makeDirectory(self::USER_DIRECTORY . "/" . $folderName);
        }

        // show all files in directory
        $files = Storage::allFiles(self::USER_DIRECTORY . "/" . $folderName);
        $files_info = array();

        foreach ($files as $file) {

            // file name/size/extension(.type)
            $name = basename($file);
            $size = Storage::size($file);
            $extension = pathinfo($file, PATHINFO_EXTENSION);

            // file info array
            $files_info[] = array(
                'name' => $name,
                'size' => $size,
                'extension' => $extension
            );
        }

        return view('user_files.files-index')
            ->with('files', $files_info)
            ->with('id', $id);
    }

    public function show($id, $fileName)
    {
        $folderName = Student::find($id)->folder_name;
        // file Path
        $filePath = self::USER_DIRECTORY . "/" . $folderName . '/' . $fileName;
        
        if (Storage::exists($filePath)) {
            
            $file = Storage::get($filePath);
            
            $response = new Response($file, 200);
            $response->header('Content-Type', Storage::mimeType($filePath))
                ->withHeaders(['Content-Disposition' => 'inline; filename="' . $fileName . '"',]);

            return $response;

        } else {
            abort(404); // file not found
        }
    }

    public function upload(Request $request, $id)
    {
        $student = Student::find($id);
        $folderName = $student->folder_name;

        // Get the uploaded file
        $file = $request->file('file');

        // Checking if the file has been uploaded
        if ($file) {
            // get the original file name
            $fileName = $request->file('file')->getClientOriginalName();

            // Saving the file on the server
            $request->file->storeAs(self::USER_DIRECTORY . "/" . $folderName, $fileName);

            // redirect with 
            return redirect()->back()->with('success ', $fileName . ' File uploaded successfully!');
        }

        return redirect()->back()->with('error', 'No file uploaded!');
    }

    public function download($id, $fileName)
    {
        $student = Student::find($id);
        $folderName = $student->folder_name;
        $filePath = self::USER_DIRECTORY . "/" . $folderName . '/' . $fileName;
        
        return Storage::download($filePath);
    }

    public function delete($id, $fileName)
    {
        $student = Student::find($id);
        $folderName = $student->folder_name;
        $filePath = self::USER_DIRECTORY . "/" . $folderName . '/' . $fileName;
        Storage::delete($filePath);

        return redirect()->back()->with('success ', $fileName . ' successfully!');
    }
}
