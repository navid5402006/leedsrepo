<?php
// app/Models/Enquiry.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'full_name',
        'phone_number',
        'email',
        'interested_course',
        'message',
        'status',
        'admin_notes',
        'timeline',
        'read_at',
        'replied_at',
        'contacted_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
        'contacted_at' => 'datetime',
        'timeline' => 'array',
    ];

    // Available statuses
    const STATUSES = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'interested' => 'Interested',
        'converted' => 'Converted',
        'closed' => 'Closed',
    ];

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeContacted($query)
    {
        return $query->where('status', 'contacted');
    }

    public function scopeInterested($query)
    {
        return $query->where('status', 'interested');
    }

    public function scopeConverted($query)
    {
        return $query->where('status', 'converted');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    // Mark as read
    public function markAsRead()
    {
        if ($this->status === 'new') {
            $this->status = 'read';
            $this->read_at = now();
            $this->save();
        }
    }

    // Mark as replied
    public function markAsReplied()
    {
        $this->status = 'replied';
        $this->replied_at = now();
        $this->save();
    }

    // Mark as converted to student
    public function markAsConverted()
    {
        $this->status = 'converted';
        $this->save();
    }

    // Add timeline entry
    public function addTimelineEntry($desc, $dot = 'blue')
    {
        $timeline = $this->timeline ?? [];
        $timeline[] = [
            'time' => now()->format('d M Y, h:i A'),
            'desc' => $desc,
            'dot' => $dot
        ];
        $this->timeline = $timeline;
        $this->save();
    }
}