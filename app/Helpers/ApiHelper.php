<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiHelper
{
    /**
     * Get base API URL
     */
    protected static function getBaseUrl(): string
    {
        // If endpoint already includes /api/v1, don't add it again
        return config('app.url');
    }

    /**
     * Get authentication headers
     */
    protected static function getHeaders(): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        // Add CSRF token for web requests
        if (Auth::check()) {
            $headers['X-CSRF-TOKEN'] = csrf_token();
        }

        return $headers;
    }

    /**
     * Make GET request to API
     */
    public static function get(string $endpoint, array $params = []): array
    {
        try {
            // Ensure endpoint starts with /
            if (!str_starts_with($endpoint, '/')) {
                $endpoint = '/' . $endpoint;
            }
            
            // If endpoint doesn't start with /api, add /api/v1
            if (!str_starts_with($endpoint, '/api')) {
                $endpoint = '/api/v1' . $endpoint;
            }
            
            $url = self::getBaseUrl() . $endpoint;
            
            $response = Http::withHeaders(self::getHeaders())
                ->get($url, $params);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json('data', $response->json()),
                    'message' => $response->json('message', 'Success'),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('message', 'Request failed'),
                'errors' => $response->json('errors', []),
            ];
        } catch (\Exception $e) {
            Log::error('API GET Error: ' . $e->getMessage(), [
                'endpoint' => $endpoint,
                'params' => $params,
            ]);

            return [
                'success' => false,
                'error' => 'Network error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Make POST request to API
     */
    public static function post(string $endpoint, array $data = []): array
    {
        try {
            // Ensure endpoint starts with /
            if (!str_starts_with($endpoint, '/')) {
                $endpoint = '/' . $endpoint;
            }
            
            // If endpoint doesn't start with /api, add /api/v1
            if (!str_starts_with($endpoint, '/api')) {
                $endpoint = '/api/v1' . $endpoint;
            }
            
            $url = self::getBaseUrl() . $endpoint;
            
            $response = Http::withHeaders(self::getHeaders())
                ->post($url, $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json('data', $response->json()),
                    'message' => $response->json('message', 'Success'),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('message', 'Request failed'),
                'errors' => $response->json('errors', []),
            ];
        } catch (\Exception $e) {
            Log::error('API POST Error: ' . $e->getMessage(), [
                'endpoint' => $endpoint,
                'data' => $data,
            ]);

            return [
                'success' => false,
                'error' => 'Network error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Make PUT request to API
     */
    public static function put(string $endpoint, array $data = []): array
    {
        try {
            // Ensure endpoint starts with /
            if (!str_starts_with($endpoint, '/')) {
                $endpoint = '/' . $endpoint;
            }
            
            // If endpoint doesn't start with /api, add /api/v1
            if (!str_starts_with($endpoint, '/api')) {
                $endpoint = '/api/v1' . $endpoint;
            }
            
            $url = self::getBaseUrl() . $endpoint;
            
            $response = Http::withHeaders(self::getHeaders())
                ->put($url, $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json('data', $response->json()),
                    'message' => $response->json('message', 'Success'),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('message', 'Request failed'),
                'errors' => $response->json('errors', []),
            ];
        } catch (\Exception $e) {
            Log::error('API PUT Error: ' . $e->getMessage(), [
                'endpoint' => $endpoint,
                'data' => $data,
            ]);

            return [
                'success' => false,
                'error' => 'Network error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Make DELETE request to API
     */
    public static function delete(string $endpoint): array
    {
        try {
            // Ensure endpoint starts with /
            if (!str_starts_with($endpoint, '/')) {
                $endpoint = '/' . $endpoint;
            }
            
            // If endpoint doesn't start with /api, add /api/v1
            if (!str_starts_with($endpoint, '/api')) {
                $endpoint = '/api/v1' . $endpoint;
            }
            
            $url = self::getBaseUrl() . $endpoint;
            
            $response = Http::withHeaders(self::getHeaders())
                ->delete($url);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json('data', $response->json()),
                    'message' => $response->json('message', 'Success'),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('message', 'Request failed'),
                'errors' => $response->json('errors', []),
            ];
        } catch (\Exception $e) {
            Log::error('API DELETE Error: ' . $e->getMessage(), [
                'endpoint' => $endpoint,
            ]);

            return [
                'success' => false,
                'error' => 'Network error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Upload file with multipart/form-data
     */
    public static function postWithFile(string $endpoint, array $data = [], string $fileKey = 'file', $file = null): array
    {
        try {
            // Ensure endpoint starts with /
            if (!str_starts_with($endpoint, '/')) {
                $endpoint = '/' . $endpoint;
            }
            
            // If endpoint doesn't start with /api, add /api/v1
            if (!str_starts_with($endpoint, '/api')) {
                $endpoint = '/api/v1' . $endpoint;
            }
            
            $url = self::getBaseUrl() . $endpoint;
            
            $request = Http::withHeaders([
                'Accept' => 'application/json',
            ]);

            // Add file if provided
            if ($file) {
                $request = $request->attach($fileKey, $file);
            }

            $response = $request->post($url, $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json('data', $response->json()),
                    'message' => $response->json('message', 'Success'),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('message', 'Request failed'),
                'errors' => $response->json('errors', []),
            ];
        } catch (\Exception $e) {
            Log::error('API POST with File Error: ' . $e->getMessage(), [
                'endpoint' => $endpoint,
            ]);

            return [
                'success' => false,
                'error' => 'Network error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Extract error message from API response
     */
    public static function getErrorMessage(array $response): string
    {
        if (isset($response['error'])) {
            return $response['error'];
        }

        if (isset($response['errors']) && is_array($response['errors'])) {
            $firstError = reset($response['errors']);
            if (is_array($firstError)) {
                return $firstError[0] ?? 'Validation error';
            }
            return $firstError;
        }

        return 'An error occurred';
    }
}

