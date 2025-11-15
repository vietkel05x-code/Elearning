<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Lesson;
use App\Services\YouTubeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LessonController extends Controller
{

    public function store(Request $request, Section $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:1331200', // 1.3GB max (1331200 KB)
            'video_path' => 'nullable|string|max:500',
            'video_url' => 'nullable|url|max:500',
            'attachment_file' => 'nullable|file|mimes:pdf,doc,docx,zip,rar|max:1331200', // 1.3GB max
            'attachment_path' => 'nullable|string|max:500',
            'duration' => 'nullable|integer|min:0',
            'position' => 'nullable|integer',
        ]);

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            $videoFile = $request->file('video_file');
            $videoPath = $videoFile->store('videos/lessons', 'public');
            $validated['video_path'] = $videoPath;
            
            // Calculate duration immediately from uploaded file (before it's moved)
            $tempPath = $videoFile->getRealPath();
            if ($tempPath && file_exists($tempPath)) {
                $calculatedDuration = $this->getVideoDurationFromPath($tempPath);
                if ($calculatedDuration > 0) {
                    $validated['duration'] = $calculatedDuration;
                    Log::info('Duration calculated from uploaded file (temp path)', [
                        'duration' => $calculatedDuration,
                        'file' => $videoFile->getClientOriginalName()
                    ]);
                }
            }
        }

        // Handle attachment file upload
        if ($request->hasFile('attachment_file')) {
            $attachmentPath = $request->file('attachment_file')->store('attachments/lessons', 'public');
            $validated['attachment_path'] = $attachmentPath;
        }

        // Remove file inputs from validated array
        unset($validated['video_file'], $validated['attachment_file']);

        // Auto-calculate duration if not already calculated from uploaded file
        if (!isset($validated['duration']) || $validated['duration'] == null || $validated['duration'] == 0) {
            // Try YouTube API first if video_url is provided
            if (!empty($validated['video_url'])) {
                $youtubeService = new YouTubeService();
                if ($youtubeService->isYouTubeUrl($validated['video_url'])) {
                    $youtubeDuration = $youtubeService->getVideoDuration($validated['video_url']);
                    if ($youtubeDuration['seconds'] > 0) {
                        // Store duration in seconds for precision (will be converted to minutes for display)
                        $validated['duration'] = (int) $youtubeDuration['seconds'];
                        Log::info('Duration calculated from YouTube API', [
                            'url' => $validated['video_url'],
                            'seconds' => $youtubeDuration['seconds'],
                            'minutes' => $youtubeDuration['duration'],
                            'formatted' => $youtubeDuration['formatted']
                        ]);
                    }
                }
            }
            
            // If still no duration, try from stored video path
            if ((!isset($validated['duration']) || $validated['duration'] == 0) && !empty($validated['video_path']) && !$request->hasFile('video_file')) {
                // Try to calculate from stored video path (if file was uploaded previously)
                $videoFile = Storage::disk('public')->path($validated['video_path']);
                if (file_exists($videoFile)) {
                    $calculatedDuration = $this->getVideoDurationFromPath($videoFile);
                    if ($calculatedDuration > 0) {
                        $validated['duration'] = $calculatedDuration;
                        Log::info('Duration calculated from stored video_path', [
                            'path' => $validated['video_path'],
                            'duration' => $calculatedDuration
                        ]);
                    }
                }
            }
        }
        
        // Ensure duration is always set (not null) - default to 0
        if (!isset($validated['duration']) || $validated['duration'] === null) {
            $validated['duration'] = 0;
            Log::info('Duration set to default 0', [
                'has_video_file' => $request->hasFile('video_file'),
                'has_video_path' => !empty($validated['video_path'] ?? ''),
                'has_video_url' => !empty($validated['video_url'] ?? '')
            ]);
        }

        // Get max position if not provided (only if truly empty/null, not if user entered 0)
        if (!isset($validated['position']) || $validated['position'] === null || $validated['position'] === '') {
            $maxPosition = $section->lessons()->max('position') ?? 0;
            $validated['position'] = $maxPosition + 1;
        } else {
            // Ensure position is an integer
            $validated['position'] = (int) $validated['position'];
        }

        $validated['is_preview'] = $request->has('is_preview') ? 1 : 0;

        $lesson = $section->lessons()->create($validated);

        // Update course video count
        $course = $section->course;
        $course->increment('video_count');

        return back()->with('success', 'Đã thêm bài học mới!');
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:1331200', // 1.3GB max (1331200 KB)
            'video_path' => 'nullable|string|max:500',
            'video_url' => 'nullable|url|max:500',
            'attachment_file' => 'nullable|file|mimes:pdf,doc,docx,zip,rar|max:1331200', // 1.3GB max
            'attachment_path' => 'nullable|string|max:500',
            'duration' => 'nullable|integer|min:0',
            'position' => 'nullable|integer',
        ]);

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            // Delete old video if exists
            if ($lesson->video_path) {
                Storage::disk('public')->delete($lesson->video_path);
            }
            $videoPath = $request->file('video_file')->store('videos/lessons', 'public');
            $validated['video_path'] = $videoPath;
        }

        // Handle attachment file upload
        if ($request->hasFile('attachment_file')) {
            // Delete old attachment if exists
            if ($lesson->attachment_path) {
                Storage::disk('public')->delete($lesson->attachment_path);
            }
            $attachmentPath = $request->file('attachment_file')->store('attachments/lessons', 'public');
            $validated['attachment_path'] = $attachmentPath;
        }

        // Remove file inputs from validated array
        unset($validated['video_file'], $validated['attachment_file']);

        // Auto-calculate duration from video file if available and not manually set
        if ((!isset($validated['duration']) || $validated['duration'] == null || $validated['duration'] == 0) || $request->hasFile('video_file')) {
            if ($request->hasFile('video_file')) {
                $duration = $this->getVideoDuration($request->file('video_file'));
                $validated['duration'] = $duration;
            } elseif (!empty($validated['video_url'])) {
                // Try YouTube API if video_url is provided
                $youtubeService = new YouTubeService();
                if ($youtubeService->isYouTubeUrl($validated['video_url'])) {
                    $youtubeDuration = $youtubeService->getVideoDuration($validated['video_url']);
                    if ($youtubeDuration['seconds'] > 0) {
                        // Store duration in seconds for precision
                        $validated['duration'] = (int) $youtubeDuration['seconds'];
                        Log::info('Duration calculated from YouTube API (update)', [
                            'url' => $validated['video_url'],
                            'seconds' => $youtubeDuration['seconds'],
                            'minutes' => $youtubeDuration['duration'],
                            'formatted' => $youtubeDuration['formatted']
                        ]);
                    }
                }
            } elseif (!empty($validated['video_path'])) {
                $videoFile = Storage::disk('public')->path($validated['video_path']);
                if (file_exists($videoFile)) {
                    $duration = $this->getVideoDurationFromPath($videoFile);
                    $validated['duration'] = $duration;
                }
            }
        }

        // Set default duration to 0 if still not set
        if (!isset($validated['duration']) || $validated['duration'] == null) {
            $validated['duration'] = $lesson->duration ?? 0; // Keep existing if updating
        }

        // Ensure position is set (only if truly empty/null, preserve user input)
        if (!isset($validated['position']) || $validated['position'] === null || $validated['position'] === '') {
            $validated['position'] = $lesson->position ?? 0; // Keep existing if updating
        } else {
            // Ensure position is an integer (preserve user input)
            $validated['position'] = (int) $validated['position'];
        }

        $validated['is_preview'] = $request->has('is_preview') ? 1 : 0;

        $lesson->update($validated);

        return back()->with('success', 'Đã cập nhật bài học!');
    }

    public function destroy(Lesson $lesson)
    {
        // Delete files if exist
        if ($lesson->video_path) {
            Storage::disk('public')->delete($lesson->video_path);
        }
        if ($lesson->attachment_path) {
            Storage::disk('public')->delete($lesson->attachment_path);
        }

        $course = $lesson->section->course;
        $lesson->delete();

        // Update course video count
        $course->decrement('video_count');

        return back()->with('success', 'Đã xóa bài học!');
    }

    /**
     * Get video duration from uploaded file
     * Returns duration in minutes (integer)
     */
    private function getVideoDuration($file)
    {
        try {
            $path = $file->getRealPath();
            return $this->getVideoDurationFromPath($path);
        } catch (\Exception $e) {
            Log::warning('Cannot get video duration: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get video duration from file path
     * Tries multiple methods: ffprobe, getID3, or fallback to 0
     */
    private function getVideoDurationFromPath($filePath)
    {
        if (!file_exists($filePath)) {
            Log::warning('Video file not found', ['path' => $filePath]);
            return 0;
        }

        // Method 1: Try ffprobe (if available)
        if (function_exists('shell_exec') && !ini_get('safe_mode')) {
            $ffprobePath = $this->findFFprobe();
            if ($ffprobePath) {
                try {
                    // Use absolute path for Windows compatibility
                    $absolutePath = realpath($filePath);
                    if (!$absolutePath) {
                        $absolutePath = $filePath;
                    }
                    
                    $command = escapeshellarg($ffprobePath) . ' -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 ' . escapeshellarg($absolutePath) . ' 2>&1';
                    $output = @shell_exec($command);
                    
                    if ($output && is_numeric(trim($output))) {
                        $seconds = (float) trim($output);
                        // Return seconds (as integer) for precision
                        Log::info('Duration calculated via ffprobe', ['seconds' => $seconds]);
                        return (int) round($seconds);
                    } else {
                        Log::debug('ffprobe output invalid', ['output' => $output]);
                    }
                } catch (\Exception $e) {
                    Log::warning('ffprobe execution error: ' . $e->getMessage());
                }
            } else {
                Log::debug('ffprobe not found');
            }
        }

        // Method 2: Try getID3 library (if installed via composer)
        if (class_exists('\getID3')) {
            try {
                $getID3 = new \getID3;
                $fileInfo = $getID3->analyze($filePath);
                if (isset($fileInfo['playtime_seconds']) && $fileInfo['playtime_seconds'] > 0) {
                    $seconds = (float) $fileInfo['playtime_seconds'];
                    // Return seconds (as integer) for precision
                    Log::info('Duration calculated via getID3', ['seconds' => $seconds]);
                    return (int) round($seconds);
                }
            } catch (\Exception $e) {
                Log::warning('getID3 error: ' . $e->getMessage());
            }
        }

        // Method 3: Try PHP getID3 alternative (simple file reading for MP4)
        $duration = $this->getVideoDurationSimple($filePath);
        if ($duration > 0) {
            return $duration;
        }

        // Fallback: Return 0 (user can manually set duration)
        Log::info('Could not calculate video duration, returning 0', ['path' => $filePath]);
        return 0;
    }

    /**
     * Simple method to get video duration (for MP4 files)
     * This is a fallback when ffprobe/getID3 are not available
     */
    private function getVideoDurationSimple($filePath)
    {
        // Only works for MP4 files
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if ($extension !== 'mp4') {
            return 0;
        }

        try {
            $file = fopen($filePath, 'rb');
            if (!$file) {
                return 0;
            }

            // Read file to find duration (simplified method)
            // This is a basic implementation and may not work for all MP4 files
            fseek($file, -8, SEEK_END);
            $data = fread($file, 8);
            fclose($file);

            // This is a very basic check - for production, use ffprobe or getID3
            return 0; // Return 0 to indicate we couldn't calculate
        } catch (\Exception $e) {
            Log::debug('Simple duration calculation failed: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Find ffprobe executable path
     */
    private function findFFprobe()
    {
        $possiblePaths = [
            'ffprobe',
            '/usr/bin/ffprobe',
            '/usr/local/bin/ffprobe',
            'C:\\ffmpeg\\bin\\ffprobe.exe',
            'C:\\Program Files\\ffmpeg\\bin\\ffprobe.exe',
            'C:\\xampp\\ffmpeg\\bin\\ffprobe.exe',
            'C:\\laragon\\bin\\ffmpeg\\ffprobe.exe',
        ];

        foreach ($possiblePaths as $path) {
            if (PHP_OS_FAMILY === 'Windows') {
                // Windows: check if file exists
                if (file_exists($path)) {
                    return $path;
                }
            } else {
                // Linux/Mac: check if executable
                if (is_executable($path)) {
                    return $path;
                }
            }
        }

        // Try to find in PATH
        if (function_exists('shell_exec') && !ini_get('safe_mode')) {
            $which = PHP_OS_FAMILY === 'Windows' ? 'where' : 'which';
            $result = @shell_exec($which . ' ffprobe 2>&1');
            
            if ($result && !empty(trim($result))) {
                $result = trim($result);
                // Check if result is actually a path (not an error message)
                if (strpos($result, 'INFO:') === false && 
                    strpos($result, 'Could not find') === false &&
                    strpos($result, 'not found') === false &&
                    (file_exists($result) || strpos($result, '\\') !== false || strpos($result, '/') !== false)) {
                    return $result;
                }
            }
        }

        return null;
    }

    /**
     * API endpoint to get YouTube video duration
     * Called from frontend JavaScript
     */
    public function getYouTubeDuration(Request $request)
    {
        $request->validate([
            'video_url' => 'required|url',
        ]);

        $youtubeService = new YouTubeService();
        $result = $youtubeService->getVideoDuration($request->video_url);

        return response()->json($result);
    }
}

