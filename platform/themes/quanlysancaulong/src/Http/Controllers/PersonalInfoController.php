<?php

namespace Theme\QuanLySanCauLong\Http\Controllers;

use Botble\Theme\Http\Controllers\PublicController;
use Illuminate\Http\Request;

class PersonalInfoController extends PublicController
{
    /**
     * Save personal information
     */
    public function savePersonalInfo(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'field_*' => 'nullable|string|max:255',
            ]);

            // Get user (if authenticated)
            $user = auth()->user();

            // Process and save data
            // You can customize this based on your needs
            $personalData = [];
            foreach ($validated as $key => $value) {
                if (strpos($key, 'field_') === 0 && !empty($value)) {
                    $personalData[$key] = $value;
                }
            }

            // Example: Save to user profile or custom table
            if ($user) {
                // Save to user's profile
                $user->update([
                    'profile_data' => json_encode($personalData),
                ]);
            }

            // Log the activity
            \Log::info('Personal info saved', [
                'user_id' => $user?->id,
                'data' => $personalData,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thông tin cá nhân đã được lưu thành công!',
                'redirect' => null, // Optional: redirect URL
            ]);
        } catch (\Exception $e) {
            \Log::error('Error saving personal info', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra. Vui lòng thử lại.',
            ], 500);
        }
    }
}

