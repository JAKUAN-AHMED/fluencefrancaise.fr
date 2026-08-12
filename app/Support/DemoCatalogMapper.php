<?php

namespace App\Support;

use App\Models\Course;
use App\Models\ExamPrep;

/**
 * Projects catalogue records down to the fields that are safe to expose publicly.
 *
 * This is the single security boundary for the guest demo. The authenticated browse
 * endpoints return whole models (including lesson content); nothing here may.
 */
final class DemoCatalogMapper
{
    public const COURSE_KEYS = [
        'id', 'title', 'subtitle', 'description', 'image_url', 'level', 'category', 'language',
    ];

    public const EXAM_PREP_KEYS = self::COURSE_KEYS;

    public static function mapCourse(Course $course): array
    {
        return [
            'id' => $course->id,
            'title' => $course->course_title,
            'subtitle' => $course->course_subtitle,
            'description' => $course->course_description,
            'image_url' => self::storageUrl($course->course_image, $course->course_banner),
            'level' => $course->course_level,
            'category' => $course->course_category,
            'language' => $course->course_language,
        ];
    }

    public static function mapExamPrep(ExamPrep $examPrep): array
    {
        return [
            'id' => $examPrep->id,
            'title' => $examPrep->exam_prep_title,
            'subtitle' => $examPrep->exam_prep_subtitle,
            'description' => $examPrep->exam_prep_description,
            'image_url' => self::storageUrl($examPrep->exam_prep_image, $examPrep->exam_prep_banner),
            'level' => $examPrep->exam_prep_level,
            'category' => $examPrep->exam_prep_category,
            'language' => $examPrep->exam_prep_language,
        ];
    }

    /**
     * Resolve catalogue art to a browser-usable URL.
     *
     * Records do not agree on a single format: uploads store a relative path
     * (`courses/images/x.jpg`, AdminController@329), while other records hold a full URL
     * or an already-rooted `/storage/` path — both cases the admin and exam prep screens
     * already branch on. Prefixing blindly turns those into `/storage/https://…`.
     *
     * Falls back to the banner so a course carrying only banner art still shows a real
     * picture instead of the placeholder.
     */
    private static function storageUrl(?string $path, ?string $fallback = null): ?string
    {
        foreach ([$path, $fallback] as $candidate) {
            $candidate = is_string($candidate) ? rtrim(trim($candidate), '/') : '';

            if ($candidate === '') {
                continue;
            }

            // Absolute URL or protocol-relative: already addressable, leave it alone.
            if (preg_match('#^(https?:)?//#i', $candidate) === 1) {
                return $candidate;
            }

            $candidate = ltrim($candidate, '/');

            if (str_starts_with(strtolower($candidate), 'storage/')) {
                return '/' . $candidate;
            }

            return '/storage/' . $candidate;
        }

        return null;
    }
}
