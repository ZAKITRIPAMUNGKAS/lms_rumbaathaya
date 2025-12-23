<?php

namespace App\Helpers;

class ChatbotFAQ
{
    /**
     * Get all FAQs
     */
    public static function getAll(): array
    {
        $faqPath = public_path('faq.json');
        
        if (!file_exists($faqPath)) {
            return [];
        }

        $faqData = json_decode(file_get_contents($faqPath), true);
        
        return $faqData['faq'] ?? [];
    }

    /**
     * Find FAQ by keyword
     */
    public static function search(string $query): array
    {
        $faqs = self::getAll();
        $query = strtolower($query);
        $results = [];

        foreach ($faqs as $faq) {
            // Check if query matches question
            if (stripos($faq['question'], $query) !== false) {
                $results[] = $faq;
                continue;
            }

            // Check if query matches answer
            if (stripos($faq['answer'], $query) !== false) {
                $results[] = $faq;
                continue;
            }

            // Check keywords
            foreach ($faq['keywords'] as $keyword) {
                if (stripos($keyword, $query) !== false || stripos($query, $keyword) !== false) {
                    $results[] = $faq;
                    break;
                }
            }
        }

        return array_unique($results, SORT_REGULAR);
    }

    /**
     * Get FAQ by ID
     */
    public static function find(int $id): ?array
    {
        $faqs = self::getAll();

        foreach ($faqs as $faq) {
            if ($faq['id'] === $id) {
                return $faq;
            }
        }

        return null;
    }

    /**
     * Get random FAQ
     */
    public static function random(int $count = 3): array
    {
        $faqs = self::getAll();
        shuffle($faqs);
        
        return array_slice($faqs, 0, min($count, count($faqs)));
    }

    /**
     * Format FAQ for chatbot response
     */
    public static function formatForChatbot(array $faq): string
    {
        return "❓ *{$faq['question']}*\n\n{$faq['answer']}";
    }

    /**
     * Get suggested questions
     */
    public static function getSuggestedQuestions(int $count = 5): array
    {
        $faqs = self::getAll();
        shuffle($faqs);
        
        $suggested = array_slice($faqs, 0, min($count, count($faqs)));
        
        return array_map(fn($faq) => $faq['question'], $suggested);
    }
}

