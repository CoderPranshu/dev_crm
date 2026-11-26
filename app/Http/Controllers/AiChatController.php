<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiChatController extends Controller
{
    public function index()
    {
        return view('ai-chat.index');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:2000'],
            'thread_id' => ['nullable', 'string', 'max:100'],
            'api_profile' => [
                'nullable',
                'string',
                'in:primary,secondary',
            ],
        ]);

        $threadId = $validated['thread_id']
            ?? session('ai_chat_thread_id')
            ?? Str::uuid()->toString();

        $apiProfile = $validated['api_profile']
            ?? session('ai_chat_api_profile')
            ?? 'primary';

        session([
            'ai_chat_thread_id' => $threadId,
            'ai_chat_api_profile' => $apiProfile,
        ]);

        $user = $request->user();
        $role = 'guest';

        if ($user && method_exists($user, 'getRoleNames')) {
            $role = $user->getRoleNames()->first() ?? 'user';
        } elseif ($user && isset($user->role)) {
            $role = $user->role;
        }

        try {
            $response = Http::acceptJson()
                ->asJson()
                ->withHeaders([
                    'X-Internal-Token' => config(
                        'services.ai_agent.token'
                    ),
                ])
                ->timeout(120)
                ->post(
                    rtrim(
                        config('services.ai_agent.url'),
                        '/'
                    ) . '/chat',
                    [
                        'message' => $validated['message'],
                        'thread_id' => $threadId,
                        'user_id' => $user?->id,
                        'role' => $role,
                        'api_profile' => $apiProfile,
                    ]
                );

            $responseBody = $response->body();

            $isRateLimited =
                $response->status() === 429
                || Str::contains($responseBody, [
                    'rate_limit_exceeded',
                    'RESOURCE_EXHAUSTED',
                    'Error code: 429',
                    '429 RESOURCE_EXHAUSTED',
                ]);

            if ($isRateLimited) {
                return response()->json([
                    'message' => 'Selected AI account ki rate limit reached hai. Dusra AI account select karein ya thodi der baad try karein.',
                    'thread_id' => $threadId,
                    'api_profile' => $apiProfile,
                ], 429);
            }

            if (!$response->successful()) {
                Log::error('AI Agent response error', [
                    'status' => $response->status(),
                    'body' => $responseBody,
                    'api_profile' => $apiProfile,
                ]);

                return response()->json([
                    'message' => 'AI assistant is currently unavailable.',
                    'thread_id' => $threadId,
                    'api_profile' => $apiProfile,
                ], 502);
            }

            return response()->json([
                'message' => $response->json('answer'),
                'thread_id' => $response->json(
                    'thread_id',
                    $threadId
                ),
                'api_profile' => $apiProfile,
            ]);
        } catch (ConnectionException $exception) {
            Log::error('AI Agent connection failed', [
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' => 'Python AI server is not running.',
                'thread_id' => $threadId,
                'api_profile' => $apiProfile,
            ], 503);
        } catch (\Throwable $exception) {
            Log::error('AI Agent unexpected error', [
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' => 'Something went wrong while processing your question.',
                'thread_id' => $threadId,
                'api_profile' => $apiProfile,
            ], 500);
        }
    }
}



