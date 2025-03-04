<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Minifyjs extends CI_Model
{
    /**
     * Minify JS content
     * @return string
     * Custom Lite weight Minify.php  
     * 
     */

    public function minifyJsContent($jsContent)
    {
        // Remove comments
        $jsContent = preg_replace('/\/\*.*?\*\//s', '', $jsContent);
        $jsContent = preg_replace('/\/\/.*$/m', '', $jsContent);

        // Remove whitespace
        $jsContent = preg_replace('/\s+/', ' ', trim($jsContent));
        $jsContent = preg_replace('/\s*([\{\}\(\)\]\[\]\{\}\,;])\s*/', '$1', $jsContent);

        // Remove semicolons at the end of lines
        $jsContent = preg_replace('/;$/m', '', $jsContent);

        return $jsContent;
    }

    public function saveMinifiedJs($jsContent, $fileName)
    {
        // Use FCPATH to get the local file path
        $filePath = FCPATH . 'public/assets/js/production/' . $fileName;
        
        // Ensure the directory exists
        if (!is_dir(FCPATH . 'public/assets/js/production')) {
            mkdir(FCPATH . 'public/assets/js/production', 0755, true);
        }
        
        // Open the file in write mode and save the content, overwriting if the file exists
        $file = fopen($filePath, 'w');
        if ($file) {
            fwrite($file, $jsContent);
            fclose($file);
            return true;
        } else {
            return false; // Handle error if file cannot be opened
        }
    }


    public function minifyAndSaveJs($jsContent, $fileName)
    {
        $minifiedJsContent = $this->minifyJsContent($jsContent);
        $this->saveMinifiedJs($minifiedJsContent, $fileName);
    }

}
