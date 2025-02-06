<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportController extends Controller
{
    public function showForm()
    {
        return view('import.form');
    }
    // Fetch tables for the heightcomparison database
    public function getTables($databaseName)
    {
        try {
            // Use the heightcomparison database
            DB::statement("USE $databaseName");

            // Get the list of tables
            $tables = DB::select('SHOW TABLES');
            $tableNames = array_map(function ($table) use ($databaseName) {
                return $table->{'Tables_in_' . $databaseName};
            }, $tables);

            // Return the list of table names as JSON
            return response()->json($tableNames);
        } catch (\Exception $e) {
            // Return a 404 error if something goes wrong
            return response()->json(['error' => 'Database not found or error in query.'], 404);
        }
    }
    // Handle file upload and data import
    public function importData(Request $request)
    {
        // Validate input
        $request->validate([
            'json_file' => 'required|file|mimes:json',
            'database_name' => 'required|string',
            'table_name' => 'required|string',
        ]);

        // Get the uploaded JSON file
        $file = $request->file('json_file');
        $jsonData = json_decode(file_get_contents($file), true);

        if (!$jsonData) {
            return response()->json(['error' => 'Invalid JSON data'], 400);
        }

        // Set the connection to the selected database
        $databaseName = $request->input('database_name');
        DB::statement("USE $databaseName");

        // Insert data
        foreach ($jsonData as &$item) {
            // Remove old `id` field if it exists
            unset($item['id']);

            // Handle the 'extras' field if it's an array, convert it to JSON
            if (isset($item['extras']) && is_array($item['extras'])) {
                $item['extras'] = json_encode($item['extras']);  // Convert array to JSON string
            }

            // Find or create `category_id`
            $category = DB::table('categories')->where('name', $item['category'])->first();
            if (!$category) {
                $categoryId = DB::table('categories')->insertGetId(['name' => $item['category']]);
            } else {
                $categoryId = $category->id;
            }
            $item['category_id'] = $categoryId;

            // Assign `subcategory_id` or `fictional_subcategory_id`
            if ($item['category'] === 'Celebrity') {
                // Handle subcategory logic for 'Celebrity' category
                $subCategory = DB::table('subcategories')->where('name', $item['subCat1'])->first();
                if (!$subCategory) {
                    $subCategoryId = DB::table('subcategories')->insertGetId([
                        'category_id' => $categoryId,
                        'name' => $item['subCat1']
                    ]);
                } else {
                    $subCategoryId = $subCategory->id;
                }
                $item['subcategory_id'] = $subCategoryId;
                $item['fictional_subcategory_id'] = null;
            } else {
                // Handle fictional subcategory logic for non-'Celebrity' categories
                $fictionalSubCategory = DB::table('fictional_subcategories')->where('name', $item['subCat1'])->first();
                if (!$fictionalSubCategory) {
                    $fictionalSubCategoryId = DB::table('fictional_subcategories')->insertGetId([
                        'subcategory1_id' => $categoryId,
                        'name' => $item['subCat1']
                    ]);
                } else {
                    $fictionalSubCategoryId = $fictionalSubCategory->id;
                }
                $item['fictional_subcategory_id'] = $fictionalSubCategoryId;
                $item['subcategory_id'] = null;
            }

            // Handle `createdAt` and `updatedAt`
            if (isset($item['createdAt'])) {
                // Convert the 'createdAt' field to a proper datetime format
                $item['created_at'] = $this->convertToDatetime($item['createdAt']);
                unset($item['createdAt']);
            } else {
                // Set created_at to the current timestamp if not provided
                $item['created_at'] = now();
            }

            // Ensure 'updated_at' is set to the current timestamp
            $item['updated_at'] = now();
            unset($item['updatedAt']);

            // Remove unnecessary fields that aren't needed for the insert
            unset($item['category']);
            unset($item['subCat1']);

            // Insert the data into the specified table
            DB::table($request->input('table_name'))->insert($item);
        }

        return response()->json(['message' => 'Data imported successfully'], 200);
    }

    public function importDataFromFolder(Request $request)
    {
        // Validate input
        $request->validate([
            'folder_name' => 'required|string',
            'table_name' => 'required|string',
        ]);
    
        $folderPath = $request->input('folder_name');
        $tableName = $request->input('table_name');
    
        if (!is_dir($folderPath)) {
            return response()->json(['error' => 'Folder does not exist: ' . $folderPath], 400);
        }
    
        $jsonFiles = glob("$folderPath/*.json");
    
        if (empty($jsonFiles)) {
            return response()->json(['error' => 'No JSON files found in the folder: ' . $folderPath], 400);
        }
    
        $processedData = [];
        $skippedFiles = [];
    
        foreach ($jsonFiles as $filePath) {
            $jsonContent = file_get_contents($filePath);
    
            if (empty(trim($jsonContent))) {
                $skippedFiles[] = basename($filePath);
                continue;
            }
    
            $jsonData = json_decode($jsonContent, true);
    
            if (json_last_error() !== JSON_ERROR_NONE || !$jsonData) {
                $skippedFiles[] = basename($filePath);
                continue;
            }
    
            // Fetch existing categories, subcategories, and fictional subcategories
            $categories = DB::table('categories')->pluck('id', 'name')->toArray();
            $subcategories = DB::table('subcategories')->pluck('id', 'name')->toArray();
            $fictionalSubcategories = DB::table('fictional_subcategories')->pluck('id', 'name')->toArray();
    
            foreach ($jsonData as &$item) {
                unset($item['id']);
    
                // Convert `extras` field to JSON if it's an array
                $item['extras'] = isset($item['extras']) && is_array($item['extras'])
                    ? json_encode($item['extras'], JSON_UNESCAPED_UNICODE)
                    : json_encode([]);
    
                // Handle Category
                $categoryName = $item['category'] ?? 'Unknown';
                if (!isset($categories[$categoryName])) {
                    $categories[$categoryName] = DB::table('categories')->insertGetId(['name' => $categoryName]);
                }
                $item['category_id'] = $categories[$categoryName];
    
                // Handle Subcategory (subCat1)
                $subcategoryName = $item['subCat1'] ?? null;
                if ($subcategoryName) {
                    if (!isset($subcategories[$subcategoryName])) {
                        $subcategories[$subcategoryName] = DB::table('subcategories')->insertGetId([
                            'category_id' => $item['category_id'],
                            'name' => $subcategoryName
                        ]);
                    }
                    $item['subcategory_id'] = $subcategories[$subcategoryName];
                } else {
                    $item['subcategory_id'] = null;
                }
    
                // Handle Fictional Subcategory (subCat2) if category is 'Fictional'
                $fictionalSubcategoryName = $item['subCat2'] ?? null;
                if (strtolower($categoryName) === 'fictional' && $fictionalSubcategoryName) {
                    if (!isset($fictionalSubcategories[$fictionalSubcategoryName])) {
                        $fictionalSubcategories[$fictionalSubcategoryName] = DB::table('fictional_subcategories')->insertGetId([
                            'subcategory1_id' => $item['subcategory_id'], // Link to subcategory
                            'name' => $fictionalSubcategoryName
                        ]);
                    }
                    $item['fictional_subcategory_id'] = $fictionalSubcategories[$fictionalSubcategoryName];
                } else {
                    $item['fictional_subcategory_id'] = null;
                }
    
                // Ensure missing fields are set to NULL
                $item['subcategory_id'] = $item['subcategory_id'] ?? null;
                $item['fictional_subcategory_id'] = $item['fictional_subcategory_id'] ?? null;
    
                // Ensure `subCat2` is inserted
                $item['subCat2'] = $fictionalSubcategoryName;
    
                // Fix timestamps: Ensure `createdAt` is in proper MySQL format
                $item['created_at'] = isset($item['createdAt']) ? $this->convertToDatetime($item['createdAt']) : now();
                $item['updated_at'] = now();
                unset($item['createdAt'], $item['updatedAt']);
    
                $processedData[] = $item;
            }
        }
    
        // Insert processed data
        if (!empty($processedData)) {
            $chunkSize = 500;
            foreach (array_chunk($processedData, $chunkSize) as $chunk) {
                DB::table($tableName)->insert($chunk);
            }
        }
    
        return response()->json([
            'message' => 'Data imported successfully',
            'skipped_files' => $skippedFiles,
        ], 200);
    }
    
    
    
    





    // Helper function to convert date string to MySQL-compatible format
    private function convertToDatetime($dateString)
    {
        try {
            $date = \Carbon\Carbon::createFromFormat('M d, h:i A', $dateString);
            return $date->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }
}
