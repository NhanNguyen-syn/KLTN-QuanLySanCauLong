<?php

namespace Botble\AiChatbot\Providers;

use Botble\AiChatbot\Commands\CancelExpiredBookingsCommand;
use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Console\Scheduling\Schedule;

class AiChatbotServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('plugins/ai-chatbot')->loadAndPublishConfigurations(['permissions']);
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'plugins/ai-chatbot');

        // Register artisan commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                CancelExpiredBookingsCommand::class,
            ]);
        }

        // Schedule auto-cancel every minute
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('chatbot:cancel-expired')->everyMinute();
        });

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-ai-chatbot',
                    'priority' => 80,
                    'parent_id' => null,
                    'name' => 'Trợ lý AI',
                    'icon' => 'ti ti-message-chatbot',
                    'url' => route('ai-chatbot.index'),
                    'permissions' => ['ai-chatbot.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-ai-chatbot-knowledge',
                    'priority' => 1,
                    'parent_id' => 'cms-plugins-ai-chatbot',
                    'name' => 'Kho tri thức',
                    'url' => route('ai-chatbot.knowledge'),
                    'permissions' => ['ai-chatbot.knowledge'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-ai-chatbot-live-chat',
                    'priority' => 2,
                    'parent_id' => 'cms-plugins-ai-chatbot',
                    'name' => 'Hỗ trợ trực tiếp',
                    'icon' => 'ti ti-headset',
                    'url' => route('ai-chatbot.live-chat'),
                    'permissions' => ['ai-chatbot.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-ai-chatbot-conversations',
                    'priority' => 3,
                    'parent_id' => 'cms-plugins-ai-chatbot',
                    'name' => 'Lịch sử hội thoại',
                    'url' => route('ai-chatbot.conversations'),
                    'permissions' => ['ai-chatbot.conversations'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-ai-chatbot-settings',
                    'priority' => 4,
                    'parent_id' => 'cms-plugins-ai-chatbot',
                    'name' => 'Cài đặt',
                    'url' => route('ai-chatbot.settings'),
                    'permissions' => ['ai-chatbot.settings'],
                ]);
        });
    }
}
