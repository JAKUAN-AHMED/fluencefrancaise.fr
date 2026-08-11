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
            'image_url' => self::storageUrl($course->course_image),
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
            'image_url' => self::storageUrl($examPrep->exam_prep_image),
            'level' => $examPrep->exam_prep_level,
            'category' => $examPrep->exam_prep_category,
            'language' => $examPrep->exam_prep_language,
        ];
    }

    private static function storageUrl(?string $path): ?string
    {
        $path = is_string($path) ? rtrim(trim($path), '/') : '';

        return $path === '' ? null : '/storage/' . ltrim($path, '/');
    }
}
