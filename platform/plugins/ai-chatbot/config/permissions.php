<?php

return [
    [
        'name' => 'AI Chatbot',
        'flag' => 'ai-chatbot.index',
    ],
    [
        'name' => 'Knowledge Base',
        'flag' => 'ai-chatbot.knowledge',
        'parent_flag' => 'ai-chatbot.index',
    ],
    [
        'name' => 'Conversations',
        'flag' => 'ai-chatbot.conversations',
        'parent_flag' => 'ai-chatbot.index',
    ],
    [
        'name' => 'Settings',
        'flag' => 'ai-chatbot.settings',
        'parent_flag' => 'ai-chatbot.index',
    ],
];
