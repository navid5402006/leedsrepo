<?php
// app/Models/Setting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        // Institute
        'institute_logo',
        'institute_name',
        'tagline',
        'about_description',
        'years_experience',
        'address',
        'google_map_embed_url',

        // CEO
        'ceo_name',
        'ceo_designation',
        'ceo_photo',
        'ceo_vision',
        'ceo_message',
        'ceo_signature',

        // About
        'about_us',
        'our_mission',
        'our_vision',
        'why_choose_us',
        'institute_image',
        'achievement_counter',

        // Contact
        'contact_email',
        'contact_phone',
        'contact_whatsapp',
        'alternate_phone',
        'contact_address',
        'google_maps_url',

        // Social
        'facebook_url',
        'tiktok_url',
        'youtube_url',
        'instagram_url',
        'linkedin_url',
        'twitter_url',
    ];

    // Get the first settings record (singleton pattern)
    public static function getSettings()
    {
        return self::first() ?? new self();
    }

    // ─── Helper methods for frontend ───

    public static function getInstituteInfo()
    {
        $settings = self::getSettings();
        return [
            'logo' => $settings->institute_logo,
            'name' => $settings->institute_name ?? 'Leeds Institute',
            'tagline' => $settings->tagline ?? 'Quality Education Since 2005',
            'about_description' => $settings->about_description,
            'years_experience' => $settings->years_experience ?? 20,
            'address' => $settings->address,
            'map_url' => $settings->google_map_embed_url,
        ];
    }

    public static function getCEOInfo()
    {
        $settings = self::getSettings();
        return [
            'name' => $settings->ceo_name ?? 'Dr. Imran Khalil',
            'designation' => $settings->ceo_designation ?? 'Principal & CEO',
            'photo' => $settings->ceo_photo,
            'vision' => $settings->ceo_vision,
            'message' => $settings->ceo_message,
            'signature' => $settings->ceo_signature,
        ];
    }

    public static function getAboutInfo()
    {
        $settings = self::getSettings();
        return [
            'about_us' => $settings->about_us,
            'mission' => $settings->our_mission,
            'vision' => $settings->our_vision,
            'why_choose' => $settings->why_choose_us,
            'image' => $settings->institute_image,
            'achievement_counter' => $settings->achievement_counter,
        ];
    }

    public static function getContactInfo()
    {
        $settings = self::getSettings();
        return [
            'email' => $settings->contact_email ?? 'info@leedsinstitute.edu.pk',
            'phone' => $settings->contact_phone ?? '+92-XXX-XXXXXXX',
            'whatsapp' => $settings->contact_whatsapp,
            'alternate_phone' => $settings->alternate_phone,
            'address' => $settings->contact_address,
            'map_url' => $settings->google_maps_url,
        ];
    }

    public static function getSocialMedia()
    {
        $settings = self::getSettings();
        return [
            'facebook' => $settings->facebook_url,
            'tiktok' => $settings->tiktok_url,
            'youtube' => $settings->youtube_url,
            'instagram' => $settings->instagram_url,
            'linkedin' => $settings->linkedin_url,
            'twitter' => $settings->twitter_url,
        ];
    }

    // Get all settings as an array for views
    public static function getAllSettings()
    {
        $settings = self::getSettings();
        return [
            'institute' => [
                'logo' => $settings->institute_logo,
                'name' => $settings->institute_name ?? 'Leeds Institute',
                'tagline' => $settings->tagline ?? 'Quality Education Since 2005',
                'about_description' => $settings->about_description,
                'years_experience' => $settings->years_experience ?? 20,
                'address' => $settings->address,
                'map_url' => $settings->google_map_embed_url,
            ],
            'ceo' => [
                'name' => $settings->ceo_name ?? 'Dr. Imran Khalil',
                'designation' => $settings->ceo_designation ?? 'Principal & CEO',
                'photo' => $settings->ceo_photo,
                'vision' => $settings->ceo_vision,
                'message' => $settings->ceo_message,
                'signature' => $settings->ceo_signature,
            ],
            'about' => [
                'about_us' => $settings->about_us,
                'mission' => $settings->our_mission,
                'vision' => $settings->our_vision,
                'why_choose' => $settings->why_choose_us,
                'image' => $settings->institute_image,
                'achievement_counter' => $settings->achievement_counter,
            ],
            'contact' => [
                'email' => $settings->contact_email ?? 'info@leedsinstitute.edu.pk',
                'phone' => $settings->contact_phone ?? '+92-XXX-XXXXXXX',
                'whatsapp' => $settings->contact_whatsapp,
                'alternate_phone' => $settings->alternate_phone,
                'address' => $settings->contact_address,
                'map_url' => $settings->google_maps_url,
            ],
            'social' => [
                'facebook' => $settings->facebook_url,
                'tiktok' => $settings->tiktok_url,
                'youtube' => $settings->youtube_url,
                'instagram' => $settings->instagram_url,
                'linkedin' => $settings->linkedin_url,
                'twitter' => $settings->twitter_url,
            ],
        ];
    }
}