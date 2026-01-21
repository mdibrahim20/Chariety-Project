<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'badge_label',
        'main_heading',
        'description',
        'submit_button_text',
        'google_map_embed',
        'subject_options',
        'card_phone_enabled',
        'card_phone_title',
        'card_phone_subtitle',
        'card_phone_1',
        'card_phone_2',
        'card_phone_icon',
        'card_email_enabled',
        'card_email_title',
        'card_email_subtitle',
        'card_email_1',
        'card_email_2',
        'card_email_icon',
        'card_location_enabled',
        'card_location_title',
        'card_location_subtitle',
        'card_location_address',
        'card_location_icon',
    ];

    protected $casts = [
        'card_phone_enabled' => 'boolean',
        'card_email_enabled' => 'boolean',
        'card_location_enabled' => 'boolean',
    ];

    public function getSubjectOptionsArrayAttribute(): array
    {
        if (empty($this->subject_options)) {
            return ['Nothing', 'Donation', 'Volunteer', 'General Inquiry'];
        }
        
        return array_filter(array_map('trim', explode(',', $this->subject_options)));
    }
}
