<?php

namespace App\Livewire\Student;

use App\Models\Repositories;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class StudentRepositories extends Component
{

    use WithFileUploads;

    public $files;

    public $folder_name;

    public $ffs;

    public $current_folder;

    public $previous_folder;

    public function openFolder($current_folder)
    {
        $this->current_folder = $current_folder;
        array_push($this->previous_folder, $current_folder);
        $this->fetchAll();
    }

    public function DownloadFile($file_id)
    {
        $file = Repositories::where([['ff_id', $file_id]])->first();
        $filePath = storage_path('app/' . $file->file_path);
        if (File::exists($filePath)) {
            return response()->download($filePath, $file->ff_title);
        }



        abort(404);
        // $file = Repositories::where('sub_ff_of', $file_id)->get();
        // $counter = 0;
        // $filenames = "";
        // foreach ($file as $filepath) {
        //     $filePath = storage_path('app/' . $file->file_path);
        //     $counter++;
        // }

        // foreach ($file as $key => $value) {
        //     $counter++;

        //     $filenames = $file->file_path;

        // }

        // for ($i = 0; $i < count($file); $i++) {
        //     $filenames .= storage_path("app/" . $file[$i]->file_path);
        //     if (File::exists($filenames)) {

        //         return response()->download($filenames, $file[$i]->ff_title);
        //     }
        //     // $filePath = storage_path('app/' . $file[$i]->file_path);

        // }



        // $filePath = storage_path('app/' . $file->file_path);
        // if (File::exists($filePath)) {

        //     return response()->download($filePath, $file->ff_title);
        // } else {
        //     echo "no";
        // }



        // $data = $file->ff_id;

        // return response()->json($filenames, 200);



        // return response()->download($file, $file->ff_title);

        abort(404);
    }
    public function DownloadAll($id)
    {

        $repo = Repositories::where("sub_ff_id", $id)->all();
        $this->dispatch("repo", ["message" => $repo, "type" => "success", "title" => "good"]);
        

    }
    public function goBackFolder()
    {
        array_pop($this->previous_folder);
        $this->current_folder = $this->previous_folder[count($this->previous_folder) - 1];
        $this->fetchAll();
    }

    public function deleteFF($id)
    {
        $repo = Repositories::where("ff_id", $id)->first();
        // dd($repo);
        if ($repo) {
            $repo->delete();
            $this->fetchAll();
            $this->dispatch("repo", [ "message" => "File Deleted Successfully.", "type" => "success", "title" => "Deleted"]);
        }
    }

    public function create_folder()
    {

        if (strlen($this->folder_name) == 0) {
            $this->dispatch("repo", [ "message" => "Invalid Folder Name.", "type" => "error", "title" => "Invalid"]);
            return;
        }
        $duplicate = Repositories::where("group_no", Auth::user()->group_no)
            ->where("sub_ff_of", $this->current_folder)
            ->where("ff_title", $this->folder_name)
            ->first();

        if ($duplicate) {
            $this->dispatch("repo", [ 
                "message" => "Folder name already exists.", 
                "type" => "error", 
                "title" => "Duplicate Folder"
            ]);
            return;
        }

        $new_folder = new Repositories([
            "group_no" => Auth::user()->group_no,
            "is_folder" => true,
            "sub_ff_of" => $this->current_folder,
            "ff_title" => $this->folder_name,
        ]);

        $new_folder->save();

        $this->reset(["folder_name"]);

        $this->fetchAll();
        $this->dispatch("repo", [ "message" => "New Folder Added Successfully.", "type" => "success", "title" => "Added"]);

    }

    function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function uploadFile()
    {
        $this->validate([
            'files.*' => 'required|file',
        ]);

        $group_no = Auth::user()->group_no;

        try {
            foreach ($this->files as $key => $file) {
                $fileName = $file->getClientOriginalName();
                $fileSize = $this->formatFileSize($file->getSize());
                $uniqueFileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $file_path = $file->storeAs('public/files', $uniqueFileName);

                $new_file = new Repositories([
                    "group_no" => $group_no,
                    "is_folder" => false,
                    "file_path" => $file_path,
                    "ff_title" => $fileName,
                    "file_size" => $fileSize,
                    "sub_ff_of" => $this->current_folder,
                ]);
                $new_file->save();
            }

            $this->fetchAll();
            $this->dispatch("repo", [ "message" => "New File Uploaded Successfully.", "type" => "success", "title" => "Uploaded"]);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function fetchAll()
    {


        if ($this->current_folder == null) {
            $this->ffs = Repositories::where("group_no", Auth::user()->group_no)
            ->where("sub_ff_of", null)
            ->orderBy("ff_id", "desc")
            ->get();
        } else {
            $this->ffs = Repositories::where("group_no", Auth::user()->group_no)
            ->where("sub_ff_of", $this->current_folder)
            ->orderBy("ff_id", "desc")
            ->get();
        }

    }

    public function mount()
    {
        $this->current_folder = null;
        $this->previous_folder = [null];
        $this->fetchAll();
    }

    public function render()
    {
        return view('livewire.student.student-repositories');
    }

    public function getAllFilesInFolder($folderId)
    {
        $allFiles = [];
        
        // Get all items in current folder
        $items = Repositories::where('sub_ff_of', $folderId)->get();
        
        foreach ($items as $item) {
            if ($item->is_folder) {
                // Recursively get files from subfolders
                $allFiles = array_merge($allFiles, $this->getAllFilesInFolder($item->ff_id));
            } else {
                // Add file to the list
                $allFiles[] = $item;
            }
        }
        
        return $allFiles;
    }

    public function downloadFolder($folderId)
    {
        $folder = Repositories::where('ff_id', $folderId)->first();
        
        if (!$folder || !$folder->is_folder) {
            $this->dispatch("repo", [
                "message" => "Invalid folder selected.",
                "type" => "error",
                "title" => "Error"
            ]);
            return;
        }

        // Get all files in the folder and subfolders
        $files = $this->getAllFilesInFolder($folderId);
        
        if (empty($files)) {
            $this->dispatch("repo", [
                "message" => "Folder is empty.",
                "type" => "warning",
                "title" => "Empty Folder"
            ]);
            return;
        }

        // Create a temporary ZIP file
        $zipFileName = $folder->ff_title . '_' . time() . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);
        
        // Ensure temp directory exists
        if (!File::exists(storage_path('app/temp'))) {
            File::makeDirectory(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive();
        
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($files as $file) {
                $filePath = storage_path('app/' . $file->file_path);
                if (File::exists($filePath)) {
                    // Add file to zip
                    $zip->addFile($filePath, $file->ff_title);
                }
            }
            $zip->close();

            // Download the zip file
            $headers = [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
            ];

            return response()->download($zipPath, $zipFileName, $headers)->deleteFileAfterSend(true);
        }

        $this->dispatch("repo", [
            "message" => "Could not create zip file.",
            "type" => "error",
            "title" => "Error"
        ]);
        return;
    }
}
