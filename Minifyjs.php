<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Minifyjs extends CI_Model
{
    /**
     * Minify JS content
     * Custom-liteweight-Minify.php
     * https://github.com/ElektroRaks/Custom-liteweight-Minify.php
     * @param string $jsContent
     * @return string $minifiedJsContent
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

    /**
     * Save minified JS content
     * @param string $jsContent
     * @param string $fileName
     * @return bool
     */
    public function saveMinifiedJs($jsContent, $fileName)
    {
        // Use FCPATH to get the local file path
        $filePath = FCPATH . 'public/assets/module/production/' . $fileName;
        
        // Ensure the directory exists
        if (!is_dir(FCPATH . 'public/assets/module/production')) {
            mkdir(FCPATH . 'public/assets/module/production', 0755, true);
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


    /**
     * Load and minify JS file
     * @param string $js_filename
     * @param string $new_filename
     * @return string
     */
    function loadRequestJS($js_filename, $new_filename)
    {
        if (empty($js_filename) || empty($new_filename)) {
            return '<script>console.log("Please provide a valid JS file name");</script>';
        }

        if (ENVIRONMENT !== "production") {
            $jsFilePath = FCPATH . 'public/assets/module/development/' . $js_filename;
            if (!file_exists($jsFilePath)) {
                return '<script>console.log("JS file not found: ' . $js_filename . '");</script>';
            }

            $jsContent = file_get_contents($jsFilePath);
            if ($jsContent === false) {
                return '<script>console.log("Error reading JS file: ' . $js_filename . '");</script>';
            }

            $minifiedJsContent = $this->minifyjs->minifyJsContent($jsContent);
            if (!$minifiedJsContent) {
                return '<script>console.log("Minification failed");</script>';
            }

            $this->minifyjs->saveMinifiedJs($minifiedJsContent, $new_filename);

            return '<script src="' . DEVELOPMENT_JS_URL . $js_filename . '"></script>';
        } 
        return '<script src="' . PRODUCTION_JS_URL . $new_filename . '"></script>';
    }


}
