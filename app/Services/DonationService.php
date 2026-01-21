<?php

namespace App\Services;

use App\Models\Donation;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class DonationService
{
    /** Submit a donation tied to an event (nullable) */
    public function submit(array $data, ?Event $event = null): Donation
    {
        $donation = new Donation();
        if ($event) {
            $donation->event_id = $event->id;
        }
        $donation->fill($data);
        $donation->save();
        return $donation->fresh();
    }

    /** Toggle status */
    public function updateStatus(Donation $donation, string $status): Donation
    {
        $donation->status = $status;
        $donation->save();
        return $donation->fresh();
    }

    /** Export CSV */
    public function exportCsv(?int $eventId = null, ?string $status = null, ?string $method = null): string
    {
        $query = Donation::query();
        if ($eventId) $query->where('event_id', $eventId);
        if ($status) $query->where('status', $status);
        if ($method) $query->where('payment_method', $method);
        
        $rows = $query->orderByDesc('id')->get();

        $csv = fopen('php://temp', 'w+');
        fputcsv($csv, ['ID','Event ID','Amount','Full Name','Email','Phone','Method','Status','Reference','Notes','Created At']);
        foreach ($rows as $row) {
            fputcsv($csv, [
                $row->id,
                $row->event_id,
                $row->amount,
                $row->full_name,
                $row->email,
                $row->phone,
                $row->payment_method,
                $row->status,
                $row->transaction_reference,
                $row->notes,
                $row->created_at,
            ]);
        }
        rewind($csv);
        $content = stream_get_contents($csv);
        fclose($csv);

        $filename = 'exports/donations-' . uniqid() . '.csv';
        Storage::put($filename, $content);
        return $filename;
    }
}
