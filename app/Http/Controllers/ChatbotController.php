<?php

namespace App\Http\Controllers;

use App\Helpers\ChatbotFAQ;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\RateLimiter;

class ChatbotController extends Controller
{
    /**
     * Handle chatbot query
     */
    public function query(Request $request): JsonResponse
    {
        // Rate limiting: max 10 queries per minute
        $key = 'chatbot:' . $request->ip();
        $maxAttempts = 10;
        $decayMinutes = 1;

        if (\RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = \RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again in ' . ceil($seconds / 60) . ' minute(s).',
            ], 429);
        }

        // Validate input
        $validated = $request->validate([
            'query' => 'required|string|min:1|max:500',
        ]);

        $query = trim($validated['query']);
        
        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Query tidak boleh kosong',
            ], 400);
        }

        \RateLimiter::hit($key, $decayMinutes * 60);

        // Sanitize query to prevent injection
        $query = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');
        
        $results = ChatbotFAQ::search($query);

        if (empty($results)) {
            return response()->json([
                'success' => true,
                'message' => 'Maaf, saya tidak menemukan jawaban untuk pertanyaan Anda. Silakan hubungi kami di WhatsApp +62 812-3456-7890 untuk informasi lebih lanjut.',
                'results' => [],
                'suggested_questions' => ChatbotFAQ::getSuggestedQuestions(3),
            ]);
        }

        // Format results for chatbot
        $formattedResults = array_map(function ($faq) {
            return [
                'id' => $faq['id'],
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'formatted' => ChatbotFAQ::formatForChatbot($faq),
            ];
        }, $results);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menemukan jawaban',
            'results' => $formattedResults,
            'count' => count($formattedResults),
        ]);
    }

    /**
     * Get all FAQs
     */
    public function getAll(): JsonResponse
    {
        $faqs = ChatbotFAQ::getAll();

        return response()->json([
            'success' => true,
            'data' => $faqs,
            'count' => count($faqs),
        ]);
    }

    /**
     * Get FAQ by ID
     */
    public function getById(int $id): JsonResponse
    {
        $faq = ChatbotFAQ::find($id);

        if (!$faq) {
            return response()->json([
                'success' => false,
                'message' => 'FAQ tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $faq,
        ]);
    }

    /**
     * Get suggested questions
     */
    public function getSuggested(): JsonResponse
    {
        $questions = ChatbotFAQ::getSuggestedQuestions(5);

        return response()->json([
            'success' => true,
            'data' => $questions,
        ]);
    }
}

