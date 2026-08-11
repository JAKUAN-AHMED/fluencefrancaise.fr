<template>
  <div class="p-8">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">Courses</h1>
    </div>

    <div v-if="loading" class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-[#0055A4]"></div>
      <p class="mt-2 text-gray-500">Loading courses...</p>
    </div>

    <div v-else-if="error" class="text-center py-12 bg-white rounded-lg">
      <p class="text-gray-700 mb-4">{{ error }}</p>
      <button
        class="px-4 py-2 bg-[#0055A4] hover:bg-[#003d7a] text-white rounded-lg transition-colors"
        @click="loadCourses"
      >
        Try again
      </button>
    </div>

    <div v-else-if="courses.length === 0" class="text-center py-12 bg-white rounded-lg">
      <p class="text-gray-500 mb-4">No courses available yet</p>
      <router-link to="/register" class="text-[#0055A4] hover:text-[#003d7a] font-medium">
        Create a free account
      </router-link>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="course in courses"
        :key="course.id"
        class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden cursor-pointer"
        @click="gate.open('to view this course')"
      >
        <img
          :src="course.image_url || 'https://via.placeholder.com/400x200?text=Course'"
          :alt="course.title"
          class="w-full h-48 object-cover"
        />
        <div class="p-6">
          <div class="flex justify-between items-start mb-2">
            <h3 class="text-xl font-bold text-gray-800 line-clamp-2">{{ course.title }}</h3>
            <span
              v-if="course.category"
              class="px-2 py-1 bg-[#0055A4]/10 text-[#003d7a] text-xs rounded-full ml-2 flex-shrink-0"
            >
              {{ course.category }}
            </span>
          </div>
          <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ course.description }}</p>
          <div class="flex items-center justify-between mb-4">
            <span class="text-sm text-gray-600">
              <strong>Level:</strong> {{ course.level || 'Beginner' }}
            </span>
            <span class="text-sm text-gray-600">
              <strong>Language:</strong> {{ course.language || 'French' }}
            </span>
          </div>
          <div class="flex gap-2">
            <button
              class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors"
              @click.stop="gate.open('to view this course')"
            >
              View Details
            </button>
            <button
              class="flex-1 px-4 py-2 bg-[#0055A4] hover:bg-[#003d7a] text-white rounded-lg transition-colors"
              @click.stop="gate.open('to enrol')"
            >
              Enroll
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useDemoGate } from '../../composables/useDemoGate'

const gate = useDemoGate()
const courses = ref([])
const loading = ref(false)
const error = ref('')

const loadCourses = async () => {
  loading.value = true
  error.value = ''
  try {
    const response = await axios.get('/api/demo/courses')
    const payload = response.data?.data
    courses.value = payload?.data ?? payload ?? []
  } catch (err) {
    console.error('Failed to load demo courses:', err)
    error.value = 'Unable to load the demo catalogue. Please try again.'
    courses.value = []
  } finally {
    loading.value = false
  }
}

onMounted(loadCourses)
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
