<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'author',
        'category',
        'is_physical',
        'access_code_required',
        'access_code',
        'available',
        'status',  // Add 'status' to manage the approval state
    ];

    /**
     * Get the formatted type of the book.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return $this->is_physical ? 'Physical Book' : 'E-Book';
    }

    /**
     * Check if the book is accessible.
     *
     * @return string
     */
    public function isAccessible(): string
    {
        if ($this->is_physical) {
            return $this->available ? 'Available for borrowing' : 'Currently unavailable';
        }

        return $this->access_code_required
            ? 'Access code required from librarian'
            : 'Accessible on university’s LAN network';
    }

    /**
     * Get the status of the book.
     *
     * @return string
     */
    public function getStatusTextAttribute(): string
    {
        switch ($this->status) {
            case 'pending':
                return 'Pending Approval';
            case 'approved':
                return 'Approved';
            case 'rejected':
                return 'Rejected';
            default:
                return 'Unknown Status';
        }
    }

    /**
     * Scope for getting only approved books.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for getting only pending books.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for getting only rejected books.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
