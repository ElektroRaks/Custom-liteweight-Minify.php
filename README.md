# Custom-liteweight-Minify.php
Custom lightweight PHP script for minifying JavaScript files in development mode and renaming them for production use.

A simple PHP script for minifying JavaScript files in development mode and renaming them for production use. This script is designed to be used in the footer view of a CodeIgniter project or any PHP-based project.

📌 Features
Automatically minifies JavaScript files during development.
Saves the minified version with a new name for production use.
Includes the correct script dynamically based on the environment (development or production).
🚀 How It Works
In Development Mode (ENVIRONMENT !== "production")

Fetches JavaScript files from the development directory.
Minifies the content using a helper function.
Injects the minified JavaScript directly into the page.
Saves the minified file for future use in production.
In Production Mode (ENVIRONMENT === "production")

Loads the already minified JavaScript file from the production directory.
📄 Usage
Add the following code inside the footer view (footer.php) of your CodeIgniter project or any PHP-based project:

```php
<?php
    $fileName = 'manage-user.min.js'; // New file name  
    if (ENVIRONMENT !== "production") {
        // Minify and include JavaScript files
        $jsFilePaths = [
            base_url() . '/public/assets/js/development/manage-user-dev.js',
        ];
        $minifiedJsContent = '';
        foreach ($jsFilePaths as $filePath) {
            $jsContent = file_get_contents($filePath);
            $minifiedJsContent .= $this->minifyjs->minifyJsContent($jsContent);
        }
        echo '<script>' . $minifiedJsContent . '</script>';
        $this->minifyjs->saveMinifiedJs($minifiedJsContent, $fileName);
    } else {
        echo '<script src="' . base_url() . 'public/assets/js/production/' . $fileName . '"></script>';
    }
?>
```

🔧 Configuration
Modify $fileName to change the output filename of the minified JavaScript file.
Add more file paths inside the $jsFilePaths array if you have multiple JavaScript files to minify.
Ensure you have a helper/library ($this->minifyjs) that contains the following methods:
minifyJsContent($jsContent): Minifies the JavaScript content.
saveMinifiedJs($minifiedJsContent, $fileName): Saves the minified JavaScript file for production use.
📂 File Structure

```markdown
## 📂 File Structure  

```bash
/public/assets/js/
├── development/
│   ├── manage-user-dev.js
├── production/
│   ├── manage-user.min.js
```

📌 Requirements
PHP 7.4 or later
CodeIgniter or any PHP-based project
A minification library (custom or third-party)

📜 License
This project is open-source and available for use under the MIT License.
