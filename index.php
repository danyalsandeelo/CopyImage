<?php 

$files = [];
$path = "D://";
$destinationFolder = "images3/";

$formats  = [".jpg",".jpeg",".png"];   //file with formats that you want to copy

function endsWith($haystack, $needle) {
    return substr_compare($haystack, $needle, -strlen($needle)) === 0;
}


function getDirContents($dir, &$results = array(),&$images= array()) {
    global $formats;
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
            
            foreach($formats as $format){
                $endsWithString = endsWith(strtolower($path), $format);
                if(!empty($endsWithString)){
                    $images[] = $path; 
                    break;
                }    
            }
    
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results, $images);
            $results[] = $path;
        }
    }
    //$results has everything, all files and all folders
    return $images;
}

$allImages = getDirContents('D://');  // any drive name or folder name

foreach($allImages as $key => $value){
    $fileName = end(explode("\\", $value));  //get the file name
    copy($value, $destinationFolder.$fileName);
}
