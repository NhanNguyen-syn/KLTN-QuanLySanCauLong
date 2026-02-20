<?php

namespace Botble\AiChatbot\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $table = 'ai_api_keys';

    protected $fillable = [
        'provider',
        'api_key',
        'model',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Available models per provider
    public const GEMINI_MODELS = [
        'gemini-pro' => 'Gemini Pro',
        'gemini-1.5-pro' => 'Gemini 1.5 Pro',
        'gemini-1.5-flash' => 'Gemini 1.5 Flash',
    ];

    public const OPENAI_MODELS = [
        'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
        'gpt-4' => 'GPT-4',
        'gpt-4-turbo' => 'GPT-4 Turbo',
        'gpt-4o' => 'GPT-4o',
        'gpt-4o-mini' => 'GPT-4o Mini',
    ];

    /**
     * Get masked API key for display (e.g., sk-...Y50A)
     */
    public function getMaskedKey(): string
    {
        $key = $this->api_key;
        
        if (empty($key)) {
            return '';
        }

        $length = strlen($key);
        
        if ($length <= 8) {
            return str_repeat('•', $length);
        }

        $prefix = substr($key, 0, 4);
        $suffix = substr($key, -4);
        
        return $prefix . '...' . $suffix;
    }

    /**
     * Get API key for a specific provider
     */
    public static function getKeyForProvider(string $provider): ?string
    {
        $record = self::where('provider', $provider)
            ->where('is_active', true)
            ->first();

        return $record?->api_key;
    }

    /**
     * Get model for a specific provider
     */
    public static function getModelForProvider(string $provider): ?string
    {
        $record = self::where('provider', $provider)->first();

        if (!$record || empty($record->model)) {
            // Return default model
            return $provider === 'gemini' ? 'gemini-pro' : 'gpt-3.5-turbo';
        }

        return $record->model;
    }

    /**
     * Get masked key for a specific provider
     */
    public static function getMaskedKeyForProvider(string $provider): string
    {
        $record = self::where('provider', $provider)->first();

        return $record ? $record->getMaskedKey() : '';
    }

    /**
     * Save or update API key and model for a provider
     */
    public static function saveKey(string $provider, ?string $apiKey = null, ?string $model = null): ?self
    {
        $existing = self::where('provider', $provider)->first();
        
        // If no existing record and no API key provided, do nothing
        if (!$existing && (empty($apiKey))) {
            // Just update model in settings if provided but no key
            if ($model !== null) {
                // Create record only with model and empty api_key placeholder
                // This requires api_key to accept null, so we'll skip for now
            }
            return null;
        }
        
        // If existing record, update it
        if ($existing) {
            if ($apiKey !== null && $apiKey !== '') {
                $existing->api_key = $apiKey;
            }
            if ($model !== null) {
                $existing->model = $model;
            }
            $existing->is_active = true;
            $existing->save();
            return $existing;
        }
        
        // Create new record only if API key is provided
        if ($apiKey !== null && $apiKey !== '') {
            return self::create([
                'provider' => $provider,
                'api_key' => $apiKey,
                'model' => $model ?? ($provider === 'gemini' ? 'gemini-pro' : 'gpt-3.5-turbo'),
                'is_active' => true,
            ]);
        }
        
        return null;
    }

    /**
     * Check if provider has an API key configured
     */
    public static function hasKey(string $provider): bool
    {
        return self::where('provider', $provider)
            ->whereNotNull('api_key')
            ->where('api_key', '!=', '')
            ->exists();
    }

    /**
     * Get available models for a provider
     */
    public static function getModelsForProvider(string $provider): array
    {
        return $provider === 'gemini' ? self::GEMINI_MODELS : self::OPENAI_MODELS;
    }
}
