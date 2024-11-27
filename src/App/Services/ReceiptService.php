<?php

declare(strict_types=1);

namespace App\Services;


use Framework\Database;
use Framework\Exceptions\ValidationException;
use App\Config\Paths;

class ReceiptService {

    public function __construct(private Database $db)
    {
    }

    // ? allows the parameter to be null
    public function validateFile(?array $file) {


        if( !$file || $file['error'] !== UPLOAD_ERR_OK ) {

            $e = new ValidationException(errors: [
                "receipt" => ["Failed to upload file"]
            ]);
            throw $e;
        }

        $maxFileSizeMB = 3 * 1024 * 1024;

        if ( $file['size'] > $maxFileSizeMB ) {
            $e = new ValidationException(errors: [
                "receipt" => ["File size is greater than the maximum allowed - 3MB"]
            ]);
            throw $e;
        }

        $originalFileName = $file['name'];

        if ( !preg_match('/^[A-za-z0-9\s._-]+$/', $originalFileName, $matches)) {
            throw new ValidationException(errors: [
                "receipt" => ["Invalid file name"]
            ]);
        }

        $fileType = $file['type'];

        $allowedMimeTypes = ["image/jpeg", "image/png", "application/pdf"];

        if (!in_array( $fileType, $allowedMimeTypes )  ) {
            throw new ValidationException(errors: [
                "receipt" => ["Invalid file type, only images and pdf files allowed"]
            ]);
        }

    } // End function validateFile

    public function upload(array $file, $transaction) {


        $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);

        $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;

        $uploadPath = Paths::STORAGE_UPLOADS . "/" . $newFileName;

        if (!move_uploaded_file($file["tmp_name"], $uploadPath)) {
            throw new ValidationException(errors: [
                "receipt" => ["Failed to upload the file"]
            ]);
        }

        $this->db->query(
            "INSERT INTO receipts
                (transaction_id, 
                original_filename, 
                storage_filename, 
                media_type) 
            VALUES 
                (:transaction_id, 
                :original_filename, 
                :storage_filename, 
                :media_type);",
        [
            "transaction_id" => $transaction,
            "original_filename" => $file["name"],
            "storage_filename" => $newFileName,
            "media_type" => $file['type']
        ]);


    } // End function upload


    public function getReceipt($id) {

        return $this->db->query(
            "SELECT * FROM receipts WHERE id = :id",
             ["id" => $id])
             ->find();

    } // End function getReceipt


    public function read(array $receipt) {

        $filePath = Paths::STORAGE_UPLOADS . '/' . $receipt['storage_filename'];

        if (!file_exists($filePath)) {
            redirectTo('/');
        }

        header("Content-Disposition: inline;filename={$receipt["original_filename"]}");

        header("Content-Type: {$receipt["media_type"]}");

        readfile($filePath);


    } // End function read

} // End class