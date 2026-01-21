<?php

namespace App\Services;

use App\Models\ContactSetting;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Validator;

class ContactService
{
    public function getSettings(): ContactSetting
    {
        return ContactSetting::firstOrCreate(
            [],
            [
                'badge_label' => 'Contact Us',
                'main_heading' => 'Reach Together, We Can Make a Difference',
                'description' => 'We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.',
                'submit_button_text' => 'Send Now',
                'subject_options' => 'Nothing,Donation,Volunteer,General Inquiry',
                'card_phone_enabled' => true,
                'card_phone_title' => 'Call Us Today',
                'card_phone_subtitle' => '24/7 Service',
                'card_email_enabled' => true,
                'card_email_title' => 'Mail Information',
                'card_email_subtitle' => 'Drop Line',
                'card_location_enabled' => true,
                'card_location_title' => 'Our Location',
                'card_location_subtitle' => 'Address',
            ]
        );
    }

    public function updateSettings(array $data): ContactSetting
    {
        $settings = $this->getSettings();
        $settings->update($data);
        return $settings->fresh();
    }

    public function submitContactForm(array $data): ContactMessage
    {
        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'amount' => 'nullable|numeric|min:0',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed');
        }

        return ContactMessage::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'amount' => $data['amount'] ?? null,
            'subject' => $data['subject'] ?? null,
            'message' => $this->sanitizeMessage($data['message']),
            'status' => 'new',
        ]);
    }

    public function deleteMessage(ContactMessage $message): void
    {
        $message->delete();
    }

    private function sanitizeMessage(string $message): string
    {
        // Remove HTML tags
        $message = strip_tags($message);
        
        // Remove excessive whitespace
        $message = preg_replace('/\s+/', ' ', $message);
        
        return trim($message);
    }
}
