<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
    public function __construct(private Database $db)
    {
    } // End function __construct

    public function isEmailTaken(string $email) {
        $emailCount = $this->db->query(
            query: "SELECT COUNT(*) FROM users WHERE email = :email", 
            params: [
                "email" => $email
            ]
        )->count();
        if ($emailCount > 0) {
            throw new ValidationException(["email" => "Email is taken"]);
        }  
    } // End function isEmailTaken

    public function insertUser(array $in_post_data) {
        return $this->db->query(
            query: "INSERT INTO users (email, password, age, country, social_media_url) 
                    VALUES 
                    (:email, :password, :age, :country, :social_media_url)",
            params: [
                "email" => $in_post_data["email"],
                "password" => $in_post_data["password"],
                "age" => $in_post_data["age"],
                "country" => $in_post_data["country"],
                "social_media_url" => $in_post_data["socialMediaURL"]
            ]
        );

        
    } // insertUser

} // End class