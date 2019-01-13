<?php 

if (! function_exists('save_avatar'))
{
    function save_avatar($file, $crop_x, $crop_y, $crop_width, $crop_height)
    {
        $destinationPath = config('variables.avatar.folder');
        $full_name       = str_random(64) . '.' . $file->getClientOriginalExtension();
        
        $image = Image::make($file->getRealPath());
        $image->crop($crop_width, $crop_height, $crop_x, $crop_y);
        $image->fit(config('variables.avatar.width'), config('variables.avatar.height'));

        Storage::disk('avatars_uploads')->put($destinationPath . '/' . $full_name, (string) $image->encode());

        return $full_name;
    }
}

if (! function_exists('delete_avatar_file'))
{
    function delete_avatar_file($filename)
    {
        $destinationPath = config('variables.avatar.folder');
        Storage::disk('avatars_uploads')->delete($destinationPath . '/' . $filename);
    }
}