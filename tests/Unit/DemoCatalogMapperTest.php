<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\ExamPrep;
use App\Support\DemoCatalogMapper;
use Tests\TestCase;

class DemoCatalogMapperTest extends TestCase
{
    private function makeCourse(): Course
    {
        $course = new Course([
            'course_title' => 'French A1 Foundations',
            'course_subtitle' => 'Start here',
            'course_description' => 'An introduction to French.',
            'course_category' => 'grammar',
            'course_language' => 'French',
            'course_level' => 'Beginner',
            'course_json_content' => '{"secret":"TOP_SECRET_LESSON_BODY"}',
            'course_image' => 'courses/a1.png',
            'course_is_active' => true,
            'custom_url' => 'https://internal.example.com/private',
            'custom_url_target' => '_blank',
            'display_order' => 3,
        ]);
        $course->id = 42;

        return $course;
    }

    public function test_map_course_returns_exactly_the_whitelisted_keys(): void
    {
        $mapped = DemoCatalogMapper::mapCourse($this->makeCourse());

        $this->assertSame(DemoCatalogMapper::COURSE_KEYS, array_keys($mapped));
    }

    public function test_map_course_copies_the_public_values(): void
    {
        $mapped = DemoCatalogMapper::mapCourse($this->makeCourse());

        $this->assertSame(42, $mapped['id']);
        $this->assertSame('French A1 Foundations', $mapped['title']);
        $this->assertSame('Start here', $mapped['subtitle']);
        $this->assertSame('An introduction to French.', $mapped['description']);
        $this->assertSame('Beginner', $mapped['level']);
        $this->assertSame('grammar', $mapped['category']);
        $this->assertSame('French', $mapped['language']);
    }

    public function test_map_course_never_leaks_private_fields(): void
    {
        $encoded = json_encode(DemoCatalogMapper::mapCourse($this->makeCourse()));

        $this->assertStringNotContainsString('TOP_SECRET_LESSON_BODY', $encoded);
        $this->assertStringNotContainsString('internal.example.com', $encoded);
    }

    public function test_map_course_builds_a_storage_image_url(): void
    {
        $mapped = DemoCatalogMapper::mapCourse($this->makeCourse());

        $this->assertSame('/storage/courses/a1.png', $mapped['image_url']);
    }

    public function test_map_course_returns_null_image_when_absent(): void
    {
        $course = $this->makeCourse();
        $course->course_image = null;

        $this->assertNull(DemoCatalogMapper::mapCourse($course)['image_url']);
    }

    public function test_map_course_strips_trailing_slashes_from_image_path(): void
    {
        $course = $this->makeCourse();
        $course->course_image = 'courses/a1.png//';

        $this->assertSame('/storage/courses/a1.png', DemoCatalogMapper::mapCourse($course)['image_url']);
    }

    public function test_map_course_passes_an_absolute_image_url_through_unchanged(): void
    {
        // admin/Courses.vue:607 branches on startsWith('http'), so records can hold a full URL.
        $course = $this->makeCourse();
        $course->course_image = 'https://cdn.example.com/course-art/a1.png';

        $this->assertSame(
            'https://cdn.example.com/course-art/a1.png',
            DemoCatalogMapper::mapCourse($course)['image_url']
        );
    }

    public function test_map_course_does_not_double_prefix_an_already_rooted_storage_path(): void
    {
        $course = $this->makeCourse();
        $course->course_image = '/storage/courses/a1.png';

        $this->assertSame('/storage/courses/a1.png', DemoCatalogMapper::mapCourse($course)['image_url']);
    }

    public function test_map_course_roots_a_bare_storage_prefixed_path(): void
    {
        $course = $this->makeCourse();
        $course->course_image = 'storage/courses/a1.png';

        $this->assertSame('/storage/courses/a1.png', DemoCatalogMapper::mapCourse($course)['image_url']);
    }

    public function test_map_course_falls_back_to_the_banner_when_no_image_is_set(): void
    {
        // tutor/Courses.vue:42 renders course_banner || course_image, so a course may
        // carry only a banner. The demo should show that rather than a grey placeholder.
        $course = $this->makeCourse();
        $course->course_image = null;
        $course->course_banner = 'courses/banners/a1-wide.jpg';

        $this->assertSame(
            '/storage/courses/banners/a1-wide.jpg',
            DemoCatalogMapper::mapCourse($course)['image_url']
        );
    }

    public function test_map_course_prefers_the_image_over_the_banner(): void
    {
        $course = $this->makeCourse();
        $course->course_banner = 'courses/banners/a1-wide.jpg';

        $this->assertSame('/storage/courses/a1.png', DemoCatalogMapper::mapCourse($course)['image_url']);
    }

    public function test_map_course_ignores_a_whitespace_only_image(): void
    {
        $course = $this->makeCourse();
        $course->course_image = '   ';
        $course->course_banner = null;

        $this->assertNull(DemoCatalogMapper::mapCourse($course)['image_url']);
    }

    public function test_map_exam_prep_falls_back_to_the_banner_when_no_image_is_set(): void
    {
        $examPrep = new ExamPrep([
            'exam_prep_title' => 'TCF Oral',
            'exam_prep_image' => null,
            'exam_prep_banner' => 'exam-preps/banners/tcf-wide.jpg',
        ]);

        $this->assertSame(
            '/storage/exam-preps/banners/tcf-wide.jpg',
            DemoCatalogMapper::mapExamPrep($examPrep)['image_url']
        );
    }

    public function test_map_exam_prep_returns_exactly_the_whitelisted_keys(): void
    {
        $examPrep = new ExamPrep([
            'exam_prep_title' => 'TEF Written',
            'exam_prep_subtitle' => 'Written module',
            'exam_prep_description' => 'Prepare for the TEF written exam.',
            'exam_prep_category' => 'written',
            'exam_prep_language' => 'French',
            'exam_prep_level' => 'B2',
            'exam_prep_json_content' => '{"secret":"TOP_SECRET_EXAM_BODY"}',
            'exam_prep_image' => 'exams/tef.png',
            'exam_prep_is_active' => true,
        ]);
        $examPrep->id = 7;

        $mapped = DemoCatalogMapper::mapExamPrep($examPrep);

        $this->assertSame(DemoCatalogMapper::EXAM_PREP_KEYS, array_keys($mapped));
        $this->assertSame('TEF Written', $mapped['title']);
        $this->assertSame('/storage/exams/tef.png', $mapped['image_url']);
        $this->assertStringNotContainsString('TOP_SECRET_EXAM_BODY', json_encode($mapped));
    }
}
