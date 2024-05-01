<?php
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     required={"id", "name", "email"}, 
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-05-02 12:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-05-02 12:00:00"),
 * )
 */