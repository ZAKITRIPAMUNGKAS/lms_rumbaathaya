<?php

if (!function_exists('api_get')) {
    /**
     * Helper function to make GET API request
     */
    function api_get(string $endpoint, array $params = []): array
    {
        return \App\Helpers\ApiHelper::get($endpoint, $params);
    }
}

if (!function_exists('api_post')) {
    /**
     * Helper function to make POST API request
     */
    function api_post(string $endpoint, array $data = []): array
    {
        return \App\Helpers\ApiHelper::post($endpoint, $data);
    }
}

if (!function_exists('api_put')) {
    /**
     * Helper function to make PUT API request
     */
    function api_put(string $endpoint, array $data = []): array
    {
        return \App\Helpers\ApiHelper::put($endpoint, $data);
    }
}

if (!function_exists('api_delete')) {
    /**
     * Helper function to make DELETE API request
     */
    function api_delete(string $endpoint): array
    {
        return \App\Helpers\ApiHelper::delete($endpoint);
    }
}

if (!function_exists('api_error_message')) {
    /**
     * Helper function to extract error message from API response
     */
    function api_error_message(array $response): string
    {
        return \App\Helpers\ApiHelper::getErrorMessage($response);
    }
}

