<?php

namespace App\Helpers;

class VideoHelper
{
    /**
     * Extract YouTube video ID from URL
     */
    public static function getYouTubeId($url)
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Extract Vimeo video ID from URL
     */
    public static function getVimeoId($url)
    {
        preg_match('/vimeo\.com\/(?:.*\/)?(\d+)/', $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Check if URL is YouTube
     */
    public static function isYouTube($url)
    {
        return strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false;
    }

    /**
     * Check if URL is Vimeo
     */
    public static function isVimeo($url)
    {
        return strpos($url, 'vimeo.com') !== false;
    }

    /**
     * Check if URL is Google Drive
     */
    public static function isGoogleDrive($url)
    {
        return strpos($url, 'drive.google.com') !== false;
    }

    /**
     * Extract Google Drive file ID from URL
     * Supports multiple formats:
     * - https://drive.google.com/file/d/FILE_ID/view
     * - https://drive.google.com/open?id=FILE_ID
     * - https://drive.google.com/file/d/FILE_ID/edit
     * - https://drive.google.com/file/d/FILE_ID/preview
     * - https://drive.google.com/uc?id=FILE_ID
     */
    public static function getGoogleDriveId($url)
    {
        // Format: /file/d/FILE_ID/
        if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        
        // Format: ?id=FILE_ID
        if (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        
        // Format: /uc?id=FILE_ID
        if (preg_match('/\/uc\?id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        
        return null;
    }

    /**
     * Get embed URL for YouTube or Vimeo (iframe)
     * Note: Google Drive should use getDirectVideoUrl() instead
     */
    public static function getEmbedUrl($url)
    {
        if (self::isYouTube($url)) {
            $id = self::getYouTubeId($url);
            return $id ? "https://www.youtube.com/embed/{$id}" : null;
        }
        
        if (self::isVimeo($url)) {
            $id = self::getVimeoId($url);
            return $id ? "https://player.vimeo.com/video/{$id}" : null;
        }
        
        // Google Drive không dùng iframe embed, dùng direct link trong video tag
        return null;
    }

    /**
     * Get direct video URL for Google Drive (for use in <video> tag)
     * File must be shared publicly (Anyone with the link)
     * 
     * Note: Google Drive có CORS restrictions, nên có thể không phát được trực tiếp
     * Nếu không hoạt động, người dùng nên upload video lên YouTube hoặc server riêng
     */
    public static function getDirectVideoUrl($url)
    {
        if (self::isGoogleDrive($url)) {
            $id = self::getGoogleDriveId($url);
            if ($id) {
                // Thử dùng streaming link (không download)
                // Nếu không hoạt động, có thể cần dùng Google Drive API
                return "https://drive.google.com/uc?export=view&id={$id}";
            }
        }
        
        return null;
    }

    /**
     * Check if URL should use iframe (YouTube, Vimeo) or video tag (Google Drive, direct links)
     */
    public static function shouldUseIframe($url)
    {
        return self::isYouTube($url) || self::isVimeo($url);
    }

    /**
     * Format duration from seconds to MM:SS or H:MM:SS format
     * 
     * @param int $value Duration value from database (can be seconds or legacy minutes)
     * @return string Formatted duration (MM:SS or H:MM:SS)
     */
    public static function formatDuration($value)
    {
        // Handle legacy format: if value is less than 7200 (2 hours in seconds),
        // and when multiplied by 60 gives a reasonable duration (less than 10 hours),
        // assume it's in minutes (old format)
        // Otherwise assume it's in seconds (new format)
        $totalSeconds = 0;
        
        if ($value <= 0) {
            return '0:00';
        }
        
        // Heuristic: if value * 60 < 72000 (10 hours), likely it's in minutes
        // Otherwise, assume it's already in seconds
        if ($value < 120 && ($value * 60) < 72000) {
            // Legacy format: convert minutes to seconds
            $totalSeconds = (int) round($value * 60);
        } else {
            // New format: already in seconds
            $totalSeconds = (int) $value;
        }

        $hours = floor($totalSeconds / 3600);
        $mins = floor(($totalSeconds % 3600) / 60);
        $secs = $totalSeconds % 60;

        // If more than 1 hour, show H:MM:SS format
        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $mins, $secs);
        }

        // Otherwise show MM:SS format
        return sprintf('%d:%02d', $mins, $secs);
    }
}

