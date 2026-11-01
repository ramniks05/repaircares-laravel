<?php

namespace App\Support;

use App\Models\Booking;
use App\Models\City;
use App\Models\Service;
use App\Models\TechnicianApplication;
use App\Models\TimeSlot;

class WhatsAppLink
{
    public static function normalizePhone(?string $raw): string
    {
        $digits = preg_replace('/\D/', '', (string) $raw);
        if ($digits === '') {
            return '';
        }
        if (strlen($digits) === 10) {
            return '91'.$digits;
        }
        if (str_starts_with($digits, '0')) {
            return '91'.ltrim($digits, '0');
        }

        return $digits;
    }

    public static function url(?string $message = null, ?string $rawPhone = null): ?string
    {
        $phone = self::normalizePhone($rawPhone ?? SiteSettings::get('whatsapp', ''));
        if ($phone === '') {
            return null;
        }
        $base = 'https://wa.me/'.$phone;
        if ($message === null || trim($message) === '') {
            return $base;
        }

        return $base.'?text='.rawurlencode($message);
    }

    public static function chatMessage(?string $serviceName = null): string
    {
        $siteName = SiteSettings::get('site_name', 'Home Services');
        $region = SiteSettings::get('region_label', 'Delhi NCR');

        if ($serviceName) {
            return "Hello {$siteName}! I'm interested in *{$serviceName}* in {$region}. Please share pricing and the earliest available slot.";
        }

        return "Hello {$siteName}! I would like to book a doorstep repair service in {$region}. Please help me with service options and available slots.";
    }

    public static function bookingRequestMessage(
        Booking $booking,
        ?City $city,
        ?Service $service,
        ?TimeSlot $slot,
    ): string {
        $siteName = SiteSettings::get('site_name', 'Home Service');
        $lines = [
            "*NEW SERVICE BOOKING — {$siteName}*",
            '',
        ];

        if ($service) {
            $lines[] = '🔧 *Service:* '.$service->displayTitle();
            $lines[] = '💰 *Starts at:* ₹'.number_format($service->price_sale, 0);
        } else {
            $lines[] = '🔧 *Service:* General enquiry';
        }

        $lines[] = '📍 *Location:* '.($city?->name ?? SiteSettings::get('region_label', 'Delhi NCR'));
        $lines[] = '👤 *Customer:* '.$booking->customer_name;
        $lines[] = '📱 *Phone:* '.$booking->phone;
        $lines[] = '📅 *Preferred date:* '.$booking->booking_date->format('d M Y');
        $lines[] = '⏰ *Time slot:* '.($slot?->label ?? '—');

        if ($booking->address) {
            $lines[] = '📌 *Address / note:* '.$booking->address;
        }

        $lines[] = '';
        $lines[] = 'Booking ID: #'.$booking->id;
        $lines[] = '_Sent via website booking form_';

        return implode("\n", $lines);
    }

    public static function technicianApplicationMessage(TechnicianApplication $application): string
    {
        $siteName = SiteSettings::get('site_name', 'Home Services');
        $skills = implode(', ', $application->work_categories ?? []);

        return implode("\n", array_filter([
            "*NEW TECHNICIAN PARTNER REGISTRATION — {$siteName}*",
            '',
            '👤 *Name:* '.$application->full_name,
            '📱 *Phone:* '.$application->phone,
            '📧 *Email:* '.$application->email,
            '📍 *City:* '.($application->city?->name ?? '—'),
            '🏠 *Address:* '.$application->address,
            '🛠 *Experience:* '.$application->work_experience,
            '📋 *Skills:* '.$skills,
            '🪪 *Aadhaar:* '.$application->aadhar_number,
            '🪪 *PAN:* '.$application->pan_number,
            '',
            'Application ID: #'.$application->id,
            '_Documents uploaded on website admin panel_',
        ]));
    }
}
