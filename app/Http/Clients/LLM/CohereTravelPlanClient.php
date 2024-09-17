<?php

namespace App\Http\Clients\LLM;

use Illuminate\Support\Facades\Http;

class CohereTravelPlanClient
{
    const CHAT_API_URL = 'https://api.cohere.com/v1/chat';

    protected string $prompt;

    protected array $chatHistory;

    /**
     * Setter for prompt attribute.
     *
     * @param string $prompt
     * @return void
     */
    public function setPrompt(string $prompt): void
    {
        $this->prompt = $prompt;
    }

    /**
     * Setter for chatHistory attribute.
     *
     * @param array $chatHistory
     * @return void
     */
    public function setChatHistory(array $chatHistory): void
    {
        $this->chatHistory = $chatHistory;
    }

    /**
     * Invoke the Cohere API to generate HTML travel plan pages.
     *
     * Return the HTML as an string.
     *
     * @return ?string
     */
    public function generateTravelPlanHtml(): ?string
    {
        $body = [
            'preamble' => '
                You are an AI assistant specialized in generating HTML travel plan pages.
                Your task is to create a well-structured, engaging, and informative HTML page based on the data
                provided for each type of establishment. Follow these guidelines:

                1. **Structure**:
                The HTML page should include a standardized structure with specific sections for each establishment,
                including the name, type, address, status, rating, and a storytelling section.

                2. **Content**:
                For each establishment, use the provided data to fill in the details in the HTML structure.
                Ensure to include the type of establishment (e.g., Nightlife Experiences, Local Restaurants)
                and any relevant information such as the address, rating, and number of reviews.

                3. **Storytelling**:
                Generate engaging and relevant storytelling for each type of establishment. Tailor the storytelling to
                fit the type of establishment. For example, describe the vibrant atmosphere of nightclubs, highlight
                the unique dishes at local restaurants, or emphasize the cultural significance of museums.

                4. **HTML Template**:
                Use the following HTML template for each establishment:

                <div class="establishment">
                    <h2>{{establishment_name}}</h2>
                    <p><strong>' . trans("main.type") . ':</strong> {{establishment_type}}</p>
                    <p><strong>' . trans("main.address") . ':</strong> {{address}}</p>
                    <p><strong>' . trans("main.status") . ':</strong> ' . trans("main.operational") . '</p>
                    <p><strong>' . trans("main.rating") . ':</strong> {{rating}} ({{user_ratings_total}} ' . trans("main.reviews") . ')</p>
                    <p>{{storytelling}}</p>
                </div>

                You **SHOULD NOT** return another HTML template, you should only return the concat the establishment
                into an string, do not add html or body tags, for example.

                5. **Data Handling**:

                Ensure that all data fields are accurately filled in based on the provided information. If any data
                is missing or not provided, handle it gracefully in the output by either omitting it or using a
                placeholder.

                Your response should focus on generating clean, readable, and correctly formatted HTML code that
                aligns with these guidelines.
            ',
            'chat_history' => $this->chatHistory,
            'message' => $this->prompt
        ];

        return Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('services.cohere.key')
        ])
            ->timeout(60)
            ->post(self::CHAT_API_URL, $body)
            ->json()['text'] ?? null;
    }
}
