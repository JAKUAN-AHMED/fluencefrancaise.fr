<template>
  <div class="flex h-screen bg-gray-100">
    <div
      v-if="isSidebarOpen"
      class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden"
      @click="isSidebarOpen = false"
    ></div>

    <!-- Sidebar -->
    <div
      class="fixed inset-y-0 left-0 z-50 w-64 text-white shadow-lg transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto md:flex md:flex-col"
      :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
      style="background-color: #0055A4;"
    >
      <div class="p-6 border-b" style="border-color: #003d7a;">
        <h2 class="text-2xl font-bold">{{ settingsStore.siteName }}</h2>
        <p class="text-white/80 text-sm">Student Portal — Demo</p>
      </div>

      <nav class="mt-6 flex-1 space-y-1 px-2 overflow-y-auto">
        <template v-for="item in demoMenu" :key="item.name">
          <router-link
            v-if="item.path"
            :to="item.path"
            class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200"
            :class="isActive(item.path) ? 'text-white' : 'text-white/90 hover:opacity-80'"
            :style="isActive(item.path) ? 'background-color: #003d7a;' : ''"
            @click="isSidebarOpen = false"
          >
            <component :is="item.icon" class="w-5 h-5 mr-3" />
            <span class="font-medium">{{ item.name }}</span>
          </router-link>

          <button
            v-else
            type="button"
            class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-white/50 hover:text-white/70 transition-colors"
            @click="gate.open('to unlock this page')"
          >
            <div class="flex items-center">
              <component :is="item.icon" class="w-5 h-5 mr-3" />
              <span class="font-medium">{{ item.name }}</span>
            </div>
            <Lock class="w-4 h-4" />
          </button>
        </template>
      </nav>
    </div>

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
      <div class="bg-white shadow-sm border-b border-gray-200 h-16 flex items-center justify-between px-4 sm:px-8 z-30">
        <div class="flex items-center">
          <button
            class="mr-4 text-gray-600 hover:text-gray-900 focus:outline-none md:hidden"
            @click="isSidebarOpen = !isSidebarOpen"
          >
            <Menu class="w-6 h-6" />
          </button>
          <h1 class="text-xl font-bold text-gray-800 truncate">{{ pageTitle }}</h1>
        </div>

        <div class="flex items-center space-x-2 sm:space-x-4">
          <div class="hidden sm:block text-right">
            <p class="text-sm font-medium text-gray-800">Guest</p>
            <p class="text-xs text-gray-500">Demo preview</p>
          </div>
          <router-link
            to="/register"
            class="px-3 sm:px-4 py-2 bg-[#0055A4] hover:bg-[#003d7a] text-white rounded-lg text-sm font-medium transition-colors"
          >
            Create free account
          </router-link>
        </div>
      </div>

      <!-- Demo banner. Explanatory only — the topbar carries the single call to action,
           so the shell does not compete with itself for the same click. -->
      <div class="bg-amber-50 border-b border-amber-200 px-4 sm:px-8 py-3">
        <p class="text-sm text-amber-900">
          You're viewing a demo of the student portal. Create an account and choose a plan to enrol
          and track your progress.
        </p>
      </div>

      <div class="flex-1 overflow-auto bg-gray-100">
        <router-view />
      </div>
    </div>

    <DemoGateModal />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { BarChart3, BookOpen, User, FileText, Menu, Lock, GraduationCap } from 'lucide-vue-next'
import { useSettingsStore } from '../stores/settings'
import { useDemoGate } from '../composables/useDemoGate'
import DemoGateModal from '../components/DemoGateModal.vue'

const route = useRoute()
const settingsStore = useSettingsStore()
const gate = useDemoGate()
const isSidebarOpen = ref(false)

// A null path marks a locked item: it renders greyed with a lock and opens the gate.
const demoMenu = ref([
  { name: 'Dashboard', path: null, icon: BarChart3 },
  { name: 'Courses', path: '/demo/courses', icon: BookOpen },
  { name: 'Exam Prep', path: '/demo/exam-prep', icon: GraduationCap },
  { name: 'Homework', path: null, icon: FileText },
  { name: 'Account', path: null, icon: User },
])

const pageTitle = computed(() => {
  const match = demoMenu.value.find(item => item.path && route.path.startsWith(item.path))
  return match ? match.name : 'Student Portal Demo'
})

const isActive = (path) => route.path.startsWith(path)

onMounted(() => {
  settingsStore.fetchSettings()
})
</script>
