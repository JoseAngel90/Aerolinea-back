<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServiciosExternosController extends Controller
{
    public function search(Request $request)
    {
        $url = 'https://api.stackexchange.com/2.2/search?order=desc&sort=activity&intitle=perl&site=stackoverflow';
        
        try {
            $response = Http::get($url);
            
            if ($response->successful()) {
                $data = $response->json();
                $items = $data['items'];
                
                $answeredCount = 0;
                $unansweredCount = 0;
                $highestReputationAnswer = null;
                $leastViewedAnswer = null;
                $oldestAnswer = null;
                $newestAnswer = null;

                foreach ($items as $item) {
                    if ($item['is_answered']) {
                        $answeredCount++;
                    } else {
                        $unansweredCount++;
                    }
                }

                if (!empty($items)) {
                    $highestReputationAnswer = collect($items)->sortByDesc('score')->first();
                    $leastViewedAnswer = collect($items)->sortBy('view_count')->first();
                    $oldestAnswer = collect($items)->sortBy('creation_date')->first();
                    $newestAnswer = collect($items)->sortByDesc('creation_date')->first();
                }

                return response()->json([
                    'answeredCount' => $answeredCount,
                    'unansweredCount' => $unansweredCount,
                    'highestReputationAnswer' => $highestReputationAnswer,
                    'leastViewedAnswer' => $leastViewedAnswer,
                    'oldestAnswer' => $oldestAnswer,
                    'newestAnswer' => $newestAnswer,
                    'items' => $items
                ]);
            } else {
                return response()->json(['error' => 'Unable to fetch data from Stack Exchange'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing your request'], 500);
        }
    }
}
