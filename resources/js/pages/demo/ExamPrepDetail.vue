<template>
  <div class="p-8">
    <router-link to="/demo/exam-prep" class="text-[#0055A4] hover:text-[#003d7a] mb-4 inline-block">
      ← Back to Exam Prep
    </router-link>

    <div v-if="loading" class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-[#0055A4]"></div>
      <p class="mt-2 text-gray-500">Loading exam prep...</p>
    </div>

    <div v-else-if="error" class="text-center py-12 bg-white rounded-lg mt-4">
      <p class="text-gray-700 mb-4">{{ error }}</p>
      <router-link
        to="/demo/exam-prep"
        class="inline-block px-4 py-2 bg-[#0055A4] hover:bg-[#003d7a] text-white rounded-lg transition-colors"
      >
        Back to Exam Prep
      </router-link>
    </div>

    <div v-else class="bg-white rounded-lg shadow-lg p-8 mt-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Exam Prep Image -->
        <div class="md:col-span-1">
          <img
            :src="examPrep.image_url || EXAM_PREP_PLACEHOLDER"
            :alt="examPrep.title"
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

        <!-- Exam Prep Details -->
        <div class="md:col-span-2">
          <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ examPrep.title }}</h1>
          <p v-if="examPrep.subtitle" class="text-gray-600 text-lg mb-4">{{ examPrep.subtitle }}</p>

          <div class="grid grid-cols-3 gap-4 mb-8 p-4 bg-gray-50 rounded-lg">
            <div>
              <p class="text-gray-600 text-sm">Level</p>
              <p class="text-lg font-bold text-[#0055A4]">{{ examPrep.level || 'Beginner' }}</p>
            </div>
            <div>
              <p class="text-gray-600 text-sm">Language</p>
              <p class="text-lg font-bold text-[#0055A4]">{{ examPrep.language || 'French' }}</p>
            </div>
            <div>
              <p class="text-gray-600 text-sm">Exam</p>
              <p class="text-lg font-bold text-[#0055A4]">{{ examPrep.category || 'General' }}</p>
            </div>
          </div>

          <h2 class="text-2xl font-bold text-gray-800 mb-4">About This Exam Prep</h2>
          <p class="text-gray-700 mb-6">{{ examPrep.description }}</p>

          <h2 class="text-2xl font-bold text-gray-800 mb-4">What You'll Practise</h2>
          <ul class="space-y-3 mb-8">
            <li v-for="outcome in outcomes" :key="outcome" class="flex items-center text-gray-700">
              <span class="text-green-600 font-bold mr-3">✓</span>
              {{ outcome }}
            </li>
          </ul>

          <h2 class="text-2xl font-bold text-gray-800 mb-4">What's Included</h2>
          <div class="space-y-4">
            <div class="border border-gray-200 rounded-lg p-4">
              <h3 class="font-bold text-gray-800 mb-2">Full Mock Exams</h3>
              <p class="text-gray-600">Timed practice papers that mirror the real exam format</p>
            </div>
            <div class="border border-gray-200 rounded-lg p-4">
              <h3 class="font-bold text-gray-800 mb-2">Section Drills</h3>
              <p class="text-gray-600">Targeted listening, reading, writing and speaking exercises</p>
            </div>
            <div class="border border-gray-200 rounded-lg p-4">
              <h3 class="font-bold text-gray-800 mb-2">Scoring &amp; Feedback</h3>
              <p class="text-gray-600">Track your band level and see where to focus next</p>
            </div>
          </div>

          <!-- Locked material: the demo shows structure, never the material itself. -->
          <div class="mt-8 border border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-50">
            <Lock class="w-8 h-8 text-gray-400 mx-auto mb-3" />
            <h3 class="font-bold text-gray-800 mb-1">Practice material is locked in the demo</h3>
            <p class="text-gray-600 text-sm mb-4">
              Become a student — create an account and choose a plan or subscription — to open the
              mock exams, drills and scoring for this exam prep.
            </p>
            <button
              class="inline-block px-5 py-2.5 bg-[#0055A4] hover:bg-[#003d7a] text-white rounded-lg font-medium transition-colors"
              @click="gate.open('to unlock this exam prep')"
            >
              Unlock this exam prep
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { Lock } from 'lucide-vue-next'
import axios from 'axios'
import { useDemoGate } from '../../composables/useDemoGate'
import { EXAM_PREP_PLACEHOLDER, makeImageErrorHandler } from '../../utils/imagePlaceholder'

const onImageError = makeImageErrorHandler(EXAM_PREP_PLACEHOLDER)
const gate = useDemoGate()
const route = useRoute()
const examPrep = ref({})
const loading = ref(false)
const error = ref('')

const outcomes = [
  'Work through full timed mock exams',
  'Sharpen listening and reading comprehension',
  'Structure strong written responses',
  'Build confidence for the speaking section',
  'Learn the marking criteria examiners use',
]

const loadExamPrep = async () => {
  loading.value = true
  error.value = ''
  try {
    const response = await axios.get(`/api/demo/exam-preps/${route.params.id}`)
    examPrep.value = response.data?.data ?? {}
  } catch (err) {
    console.error('Failed to load demo exam prep:', err)
    error.value = 'This exam prep is not available in the demo.'
    examPrep.value = {}
  } finally {
    loading.value = false
  }
}

onMounted(loadExamPrep)
</script>
