<?php 

if (!function_exists('upload_image')) {
    function upload_image($imageFile)
    {
        if ($imageFile) {
            $imageName = time() . '-' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            
            $imageFile->move(public_path('uploads'), $imageName);
            
            return 'uploads/' . $imageName;
        }
        
        return null;
    }
}
