<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ============================================
    // MASS ASSIGNMENT
    // ============================================

    protected $fillable = [
        'name',
        'email',
        'password',
        'church_id',
        'role',
        'profile_picture',
        'avatar_color',
        'preferred_language',
        'two_factor_enabled',
        'session_timeout',
        'last_activity',
        'last_login_at',
        'phone',
        'birthday',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ============================================
    // CASTS
    // ============================================

    protected $casts = [
        'email_verified_at'  => 'datetime',
        'two_factor_enabled' => 'boolean',
        'session_timeout'    => 'integer',
        'last_activity'      => 'datetime',
        'last_login_at'      => 'datetime',
        'birthday'           => 'date',
        'avatar_color'       => 'string',
    ];

    /**
     * Auto-append these computed attributes when the model is serialized to JSON.
     */
    protected $appends = [
        'profile_picture_url',
        'initials',
        'has_profile_picture',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * The church that owns this user.
     */
    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    /**
     * Church settings through church.
     */
    public function churchSettings()
    {
        return $this->hasOneThrough(
            ChurchSetting::class,
            Church::class,
            'id',        // Foreign key on churches table
            'church_id', // Foreign key on church_settings table
            'church_id', // Local key on users table
            'id'         // Local key on churches table
        );
    }

    // ============================================
    // HELPERS
    // ============================================

    /**
     * Check if user is a church admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'church_admin';
    }

    /**
     * Check if the user has a profile picture set.
     */
    public function hasProfilePicture(): bool
    {
        return !empty($this->profile_picture);
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * Get profile picture URL with cache-buster.
     *
     * ✅ IMPORTANT: Appends "?v={updated_at}" so the browser always
     * fetches the FRESH image after an update, instead of using the
     * cached old one.
     *
     * Handles:
     *  - External URLs (http/https)
     *  - New format: "profile-pictures/abc.jpg"
     *  - Legacy format: "profile_pictures/abc.jpg"
     *  - Bare filename: "abc.jpg" (auto-prefixed)
     */
    public function getProfilePictureUrlAttribute(): ?string
    {
        if (empty($this->profile_picture)) {
            return null;
        }

        // External URL — return as-is
        if (filter_var($this->profile_picture, FILTER_VALIDATE_URL)) {
            return $this->profile_picture;
        }

        // Normalize path
        $path = $this->profile_picture;

        if (
            !str_starts_with($path, 'profile-pictures/') &&
            !str_starts_with($path, 'profile_pictures/')
        ) {
            $path = 'profile-pictures/' . $path;
        }

        $url = Storage::disk('public')->url($path);

        // ✅ Append cache-buster (forces browser to reload after update)
        if ($this->updated_at) {
            $separator = str_contains($url, '?') ? '&' : '?';
            $url .= $separator . 'v=' . $this->updated_at->timestamp;
        }

        return $url;
    }

    /**
     * Get the raw stored path (no URL, no cache-buster).
     * Useful for Storage operations, delete, etc.
     */
    public function getProfilePicturePathAttribute(): ?string
    {
        if (empty($this->profile_picture)) {
            return null;
        }

        if (filter_var($this->profile_picture, FILTER_VALIDATE_URL)) {
            return null;
        }

        $path = $this->profile_picture;

        if (
            !str_starts_with($path, 'profile-pictures/') &&
            !str_starts_with($path, 'profile_pictures/')
        ) {
            $path = 'profile-pictures/' . $path;
        }

        return $path;
    }

    /**
     * Boolean accessor for $appends — whether user has a picture.
     */
    public function getHasProfilePictureAttribute(): bool
    {
        return !empty($this->profile_picture);
    }

    /**
     * Get user initials (max 2 characters).
     */
    public function getInitialsAttribute(): string
    {
        $name = trim($this->name ?? '');

        if (empty($name)) {
            return 'A';
        }

        $words = preg_split('/\s+/', $name);
        $initials = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= mb_strtoupper(mb_substr($word, 0, 1));
            }
        }

        return mb_substr($initials, 0, 2) ?: 'A';
    }

    /**
     * Get avatar color — deterministic fallback based on user ID.
     * Does NOT save on read (no side effects).
     */
    public function getAvatarColorAttribute($value): string
    {
        if (!empty($value)) {
            return $value;
        }

        $colors = [
            '#4F46E5', '#10B981', '#EF4444', '#F59E0B',
            '#3B82F6', '#8B5CF6', '#EC4899', '#14B8A6',
            '#F97316', '#6366F1', '#06B6D4', '#D946EF',
        ];

        return $colors[($this->id ?? 0) % count($colors)];
    }

    /**
     * Get preferred language with fallback.
     */
    public function getPreferredLanguageAttribute($value): string
    {
        return $value ?: 'en';
    }

    // ============================================
    // SECURITY / SESSION METHODS
    // ============================================

    public function hasTwoFactorEnabled(): bool
    {
        return (bool) $this->two_factor_enabled;
    }

    public function getSessionTimeout(): int
    {
        return (int) ($this->session_timeout ?? 30);
    }

    public function isSessionExpired(): bool
    {
        if (!$this->last_activity || $this->session_timeout === 0) {
            return false;
        }

        return now()->greaterThan(
            $this->last_activity->copy()->addMinutes((int) $this->session_timeout)
        );
    }

    public function updateLastActivity(): void
    {
        $this->last_activity = now();
        $this->save();
    }

    public function forceLogoutOtherSessions(): void
    {
        $this->remember_token = null;
        $this->last_activity = now();
        $this->save();
    }

    // ============================================
    // PROFILE PICTURE MANAGEMENT
    // ============================================

    /**
     * Delete current profile picture from storage.
     *
     * ✅ Also clears the model attribute BEFORE saving, so subsequent
     * calls to hasProfilePicture() return false immediately.
     */
    public function deleteProfilePicture(): bool
    {
        if (empty($this->profile_picture)) {
            return false;
        }

        $path = $this->getProfilePicturePathAttribute();

        // Delete from storage (skip external URLs)
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // Clear attribute before save
        $this->profile_picture = null;
        $this->save();

        return true;
    }

    /**
     * Store a new profile picture and update the model.
     *
     * Returns the stored path (relative, e.g. "profile-pictures/abc.jpg").
     */
    public function storeProfilePicture(\Illuminate\Http\UploadedFile $file): string
    {
        // Delete old picture first
        if ($this->hasProfilePicture()) {
            $this->deleteProfilePicture();
        }

        // Store new picture
        $path = $file->store('profile-pictures', 'public');

        $this->profile_picture = $path;
        $this->save();

        return $path;
    }
}