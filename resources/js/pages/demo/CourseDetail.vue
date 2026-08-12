<template>
  <div class="p-8">
    <router-link to="/demo/courses" class="text-[#0055A4] hover:text-[#003d7a] mb-4 inline-block">
      ← Back to Courses
    </router-link>

    <div v-if="loading" class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-[#0055A4]"></div>
      <p class="mt-2 text-gray-500">Loading course...</p>
    </div>

    <div v-else-if="error" class="text-center py-12 bg-white rounded-lg mt-4">
      <p class="text-gray-700 mb-4">{{ error }}</p>
      <router-link
        to="/demo/courses"
        class="inline-block px-4 py-2 bg-[#0055A4] hover:bg-[#003d7a] text-white rounded-lg transition-colors"
      >
        Back to Courses
      </router-link>
    </div>

    <div v-else class="bg-white rounded-lg shadow-lg p-8 mt-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Course Image -->
        <div class="md:col-span-1">
          <img
            :src="course.image_url || COURSE_PLACEHOLDER"
            :alt="course.title"
            class="w-full rounded-lg shadow-lg mb-4 bg-gray-100"
            @error="onImageError"
          />
          <button
            class="block w-full px-6 py-3 bg-[#0055A4] hover:bg-[#003d7a] text-white rounded-lg font-bold text-center transition-colors"
            @click="gate.open('to enrol')"
          >
            Enroll Now
          </button>
          <p class="text-xs text-gray-500 text-center mt-3">
            Create an account, then pick a plan or subscription to enrol.
          </p>
        </div>

        <!-- Course Details -->
        <div class="md:col-span-2">
          <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ course.title }}</h1>
          <p v-if="course.subtitle" class="text-gray-600 text-lg mb-4">{{ course.subtitle }}</p>

          <!-- Each cell renders only if the course actually carries that value. -->
          <div v-if="facts.length" class="grid gap-4 mb-8 p-4 bg-gray-50 rounded-lg"
               :class="facts.length === 1 ? 'grid-cols-1' : facts.length === 2 ? 'grid-cols-2' : 'grid-cols-3'">
            <div v-for="fact in facts" :key="fact.label">
              <p class="text-gray-600 text-sm">{{ fact.label }}</p>
              <p class="text-lg font-bold text-[#0055A4]">{{ fact.value }}</p>
            </div>
          </div>

          <template v-if="course.description">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">About This Course</h2>
            <p class="text-gray-700 mb-6 whitespace-pre-line">{{ course.description }}</p>
          </template>

          <!-- Only the course's own published count. Nothing on this page describes
               content the record does not actually state. -->
          <template v-if="course.total_texts">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Course Structure</h2>
            <div class="border border-gray-200 rounded-lg p-4">
              <h3 class="font-bold text-gray-800 mb-1">
                {{ course.total_texts }} {{ course.total_texts === 1 ? 'lesson' : 'lessons' }}
              </h3>
              <p class="text-gray-600">Available to enrolled students.</p>
            </div>
          </template>

          <!-- Locked lesson content: the demo shows structure, never the material itself. -->
          <div class="mt-8 border border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-50">
            <Lock class="w-8 h-8 text-gray-400 mx-auto mb-3" />
            <h3 class="font-bold text-gray-800 mb-1">Lesson content is locked in the demo</h3>
            <p class="text-gray-600 text-sm mb-4">
              Become a student — create an account and choose a course plan or subscription — to open
              the lessons, activities and quizzes for this course.
            </p>
            <button
              class="inline-block px-5 py-2.5 bg-[#0055A4] hover:bg-[#003d7a] text-white rounded-lg font-medium transition-colors"
              @click="gate.open('to unlock this course')"
            >
              Unlock this course
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { Lock } from 'lucide-vue-next'
import axios from 'axios'
import { useDemoGate } from '../../composables/useDemoGate'
import { COURSE_PLACEHOLDER, makeImageErrorHandler } from '../../utils/imagePlaceholder'

const onImageError = makeImageErrorHandler(COURSE_PLACEHOLDER)
const gate = useDemoGate()
const route = useRoute()
const course = ref({})
const loading = ref(false)
const error = ref('')

const facts = computed(() => [
  { label: 'Level', value: course.value.level },
  { label: 'Language', value: course.value.language },
  { label: 'Category', value: course.value.category },
].filter(fact => fact.value))

const loadCourse = async () => {
  loading.value = true
  error.value = ''
  try {
    const response = await axios.get(`/api/demo/courses/${route.params.id}`)
    course.value = response.data?.data ?? {}
  } catch (err) {
    console.error('Failed to load demo course:', err)
    error.value = 'This course is not available in the demo.'
    course.value = {}
  } finally {
    loading.value = false
  }
}

onMounted(loadCourse)
</script>
