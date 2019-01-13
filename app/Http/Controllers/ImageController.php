<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        // A list of permitted file extensions
        if(empty($_FILES['file']))
        {
            exit();
        }

        $errorImgFile = public_path()."/uploads/img/img_upload_error.jpg";
        $destinationFilePath = public_path().'/uploads/img-uploads/'.$_FILES['file']['name'];
        if(!move_uploaded_file($_FILES['file']['tmp_name'], $destinationFilePath)){
            echo $errorImgFile;
        }
        else{
            echo url('/').'/public/uploads/img-uploads/'.$_FILES['file']['name'];
        }
    }
}
