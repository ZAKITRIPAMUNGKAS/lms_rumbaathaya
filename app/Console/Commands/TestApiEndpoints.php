<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\ApiHelper;

class TestApiEndpoints extends Command
{
    protected $signature = 'api:test {endpoint?}';
    protected $description = 'Test API endpoints';

    public function handle()
    {
        $endpoint = $this->argument('endpoint');

        if ($endpoint) {
            $this->testEndpoint($endpoint);
        } else {
            $this->testAllEndpoints();
        }
    }

    protected function testAllEndpoints()
    {
        $this->info('Testing Public API Endpoints...');
        $this->newLine();

        // Health check
        $this->testEndpoint('/api/health');
        $this->testEndpoint('/api/v1/health');
        
        // Public endpoints
        $this->testEndpoint('/api/v1/posts');
        $this->testEndpoint('/api/v1/tutors');
        $this->testEndpoint('/api/v1/materials');
        $this->testEndpoint('/api/v1/programs');
        $this->testEndpoint('/api/v1/documentation');
        $this->testEndpoint('/api/v1/testimonials');

        $this->newLine();
        $this->info('✅ Public API endpoints test completed');
    }

    protected function testEndpoint(string $endpoint)
    {
        $this->line("Testing: {$endpoint}...");
        
        // Ensure endpoint starts with /
        if (!str_starts_with($endpoint, '/')) {
            $endpoint = '/' . $endpoint;
        }
        
        // If endpoint doesn't start with /api/v1, add it
        if (!str_starts_with($endpoint, '/api/v1')) {
            if (str_starts_with($endpoint, '/v1')) {
                $endpoint = '/api' . $endpoint;
            } else {
                $endpoint = '/api/v1' . $endpoint;
            }
        }
        
        $response = ApiHelper::get($endpoint);
        
        if ($response['success']) {
            $this->info("  ✅ Success");
            if (isset($response['data'])) {
                $dataType = is_array($response['data']) ? 'array' : gettype($response['data']);
                $this->line("  Data type: {$dataType}");
            }
        } else {
            $this->error("  ❌ Failed: " . ($response['error'] ?? 'Unknown error'));
        }
    }
}

