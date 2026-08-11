<template>
  <div class="flex flex-col min-h-screen">
    <PublicHeader />
    <div class="flex-grow flex items-center justify-center bg-gradient-to-br from-brand-600 to-brand-700 px-4 pt-40 pb-12">
      <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl">
        <!-- Form Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 p-6 z-10">
          <h1 class="text-3xl font-bold text-brand-600 text-center mb-2">Enrollment Form</h1>
          <p class="text-gray-600 text-center">Join our learning community today</p>
        </div>

        <form @submit.prevent="handleRegister" class="p-6 space-y-6">
          <!-- Personal Information Section -->
          <div class="border-b pb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Personal Information</h3>
            
            <!-- Name Fields -->
            <div class="grid grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                  First Name <span class="text-red-500">*</span>
                </label>
                <input
                  v-model="form.firstName"
                  type="text"
                  required
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
                  placeholder="Enter Your First Name"
                />
              </div>
              <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                  Last Name <span class="text-red-500">*</span>
                </label>
                <input
                  v-model="form.lastName"
                  type="text"
                  required
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
                  placeholder="Enter Your Last Name"
                />
              </div>
            </div>

            <!-- Email -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-semibold mb-2">
                Email Address <span class="text-red-500">*</span>
              </label>
              <input
                v-model="form.email"
                type="email"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
                placeholder="Enter an active Email Address"
              />
            </div>

            <!-- Username -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-semibold mb-2">
                Create a Username <span class="text-red-500">*</span>
              </label>
              <input
                v-model="form.username"
                type="text"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
                placeholder="Choose a username"
              />
              <small class="text-gray-500 text-xs mt-1 block">
                (Our Student Portal account for free library and LingoPie)
              </small>
            </div>

            <!-- Password -->
            <div class="grid grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                  Password <span class="text-red-500">*</span>
                </label>
                <input
                  v-model="form.password"
                  type="password"
                  required
                  minlength="6"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
                  placeholder="Minimum 6 characters"
                />
              </div>
              <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                  Confirm Password <span class="text-red-500">*</span>
                </label>
                <input
                  v-model="form.passwordConfirmation"
                  type="password"
                  required
                  minlength="6"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
                  placeholder="Confirm password"
                />
                <p v-if="form.password && form.passwordConfirmation && form.password !== form.passwordConfirmation" class="text-red-500 text-xs mt-1">
                  Passwords do not match
                </p>
              </div>
            </div>

            <!-- Phone Number -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-semibold mb-2">
                Phone Number <span class="text-red-500">*</span>
              </label>
              <input
                v-model="form.phone"
                type="tel"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
                placeholder="Enter your phone number"
              />
            </div>

            <!-- City -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-semibold mb-2">
                City <span class="text-red-500">*</span>
              </label>
              <input
                v-model="form.city"
                type="text"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
                placeholder="Enter your city"
              />
            </div>
          </div>

          <!-- Language & Learning Information Section -->
          <div class="border-b pb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Language & Learning Information</h3>
            
            <!-- Native Language -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-semibold mb-2">
                Native Language <span class="text-red-500">*</span>
              </label>
              <select
                v-model="form.nativeLanguage"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
              >
                <option value="">Select Native Language</option>
                <option value="english">English</option>
                <option value="spanish">Spanish</option>
                <option value="mandarin">Mandarin</option>
                <option value="hindi">Hindi</option>
                <option value="arabic">Arabic</option>
                <option value="other">Other</option>
              </select>
            </div>

            <!-- English Level -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-semibold mb-2">
                English Level <span class="text-red-500">*</span>
              </label>
              <select
                v-model="form.englishLevel"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
              >
                <option value="">Select English Level</option>
                <option value="beginner">Beginner</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
                <option value="native">Native</option>
              </select>
            </div>

            <!-- French Level -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-semibold mb-2">
                French Level <span class="text-red-500">*</span>
              </label>
              <select
                v-model="form.frenchLevel"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
              >
                <option value="">Select French Level</option>
                <option value="complete-beginner">Complete Beginner</option>
                <option value="a1">A1</option>
                <option value="a2">A2</option>
                <option value="b1">B1</option>
                <option value="b2">B2</option>
                <option value="c1">C1</option>
                <option value="c2">C2</option>
              </select>
            </div>

            <!-- Course Purpose -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-semibold mb-2">
                Course Purpose <span class="text-red-500">*</span>
              </label>
              <input
                v-model="form.coursePurpose"
                type="text"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
                placeholder="e.g., Hobby, Travel, Immigration"
              />
            </div>
          </div>

          <!-- Class Selection Section -->
          <div class="border-b pb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Class Selection</h3>
            
            <div v-if="loadingClassTypes" class="text-center py-4">
              <p class="text-gray-500">Loading class types...</p>
            </div>
            
            <div v-else-if="classTypes.length === 0" class="text-center py-4">
              <p class="text-gray-500">No class types available</p>
            </div>
            
            <div v-else class="space-y-3">
              <div
                v-for="classType in classTypes"
                :key="classType.id"
                class="border rounded-lg p-4 transition-colors"
                :class="{
                  'border-gray-300 hover:border-brand-600 cursor-pointer': !classType.is_batch_full,
                  'border-red-300 bg-red-50 cursor-not-allowed opacity-75': classType.is_batch_full,
                  'border-brand-600 bg-brand-600/10': form.classTypeId === classType.id && !classType.is_batch_full
                }"
                @click="!classType.is_batch_full && (form.classTypeId = classType.id)"
              >
                <div class="flex items-start gap-3">
                  <input
                    type="radio"
                    :id="`class-${classType.id}`"
                    :value="classType.id"
                    v-model="form.classTypeId"
                    :disabled="classType.is_batch_full"
                    :required="!classType.is_batch_full"
                    class="mt-1"
                    :class="{ 'cursor-not-allowed': classType.is_batch_full }"
                  />
                  <div class="flex-1">
                    <label 
                      :for="`class-${classType.id}`" 
                      class="font-semibold text-gray-800"
                      :class="{ 'cursor-pointer': !classType.is_batch_full, 'cursor-not-allowed text-gray-500': classType.is_batch_full }"
                    >
                      {{ classType.class_name || classType.name || 'Class Type' }}
                    </label>
                    <p v-if="classType.description" class="text-sm text-gray-600 mt-1">
                      {{ classType.description }}
                    </p>
                    <p class="text-sm font-bold text-brand-600 mt-2" v-if="!classType.is_batch_full">
                      {{ formatPrice(classType.price || 0, classType.currency || 'CAD') }}
                    </p>
                    <div v-if="classType.is_batch_full" class="mt-2">
                      <p class="text-sm font-semibold text-red-600">
                        {{ classType.batch_full_message || 'This batch is full' }}
                    </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Availability Information (Conditional) -->
            <div v-if="requiresAvailability" class="mt-6 p-4 bg-brand-50 border border-brand-200 rounded-lg animate-fade-in">
              <label class="block text-gray-800 text-sm font-bold mb-2">
                Add availability and time zone <span class="text-red-500">*</span>
              </label>
              <p class="text-sm text-gray-600 mb-3">
                Please let us know your full availability <span class="font-bold text-gray-900">(including time zone)</span>
              </p>
              <textarea
                v-model="form.availability"
                required
                rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
                placeholder="e.g., Monday 5pm-7pm (EST), Saturday mornings..."
              />
            </div>
          </div>

          <!-- Confirmation Section -->
          <div class="border-b pb-6">
            <div class="flex items-start gap-3 mb-4">
              <input
                type="checkbox"
                id="confirmation"
                v-model="form.confirmation"
                required
                class="mt-1"
              />
              <label for="confirmation" class="text-sm text-gray-700 cursor-pointer">
                I confirm the information provided is accurate <span class="text-red-500">*</span>
                <br>
                <small class="text-gray-500">Note: Group batches are limited to 5 slots only</small>
              </label>
            </div>

          </div>

          <!-- Additional Information Section -->
          <div class="border-b pb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Additional Information</h3>
            
            <!-- Special Request -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-semibold mb-2">
                Special Request (Optional)
              </label>
              <textarea
                v-model="form.specialRequest"
                rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
                placeholder="Any special requests or messages..."
              />
            </div>

            <!-- How Did You Hear About Us -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-semibold mb-2">
                How Did You Hear About Us? <span class="text-red-500">*</span>
              </label>
              <select
                v-model="form.referralSource"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20"
              >
                <option value="">Select an option</option>
                <option value="instagram">Instagram</option>
                <option value="facebook">Facebook</option>
                <option value="google">Google</option>
                <option value="friend-family">Friend/Family</option>
                <option value="tiktok">TikTok</option>
                <option value="youtube">YouTube</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>

          <!-- Pricing Section -->
          <div class="border-b pb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Pricing</h3>
            
            <!-- Coupon Code -->
            <div v-if="!couponsDisabled" class="mb-4">
              <label class="block text-gray-700 text-sm font-semibold mb-2">Coupon Code (Optional)</label>
              <div class="flex gap-2">
                <input
                  v-model="couponCode"
                  type="text"
                  placeholder="Enter coupon code"
                  class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 transition-colors"
                  :class="couponError 
                    ? 'border-red-500 focus:border-red-500 focus:ring-red-200' 
                    : appliedCoupon 
                      ? 'border-green-500 focus:border-green-500 focus:ring-green-200' 
                      : 'border-gray-300 focus:border-brand-600 focus:ring-brand-600/20'"
                  :disabled="appliedCoupon !== null || applyingCoupon"
                  @input="couponError = ''"
                />
                <button
                  v-if="!appliedCoupon"
                  type="button"
                  @click="applyCoupon"
                  :disabled="applyingCoupon"
                  class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center min-w-[80px]"
                >
                  <svg v-if="applyingCoupon" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <span v-else>Apply</span>
                </button>
                <button
                  v-else
                  type="button"
                  @click="removeCoupon"
                  class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors"
                >
                  Remove
                </button>
              </div>
              <p v-if="couponError" class="text-red-500 text-sm mt-1 font-medium">{{ couponError }}</p>
              <p v-if="appliedCoupon && !couponError" class="text-green-600 text-sm mt-1 font-medium">
                ✓ Coupon applied successfully
              </p>
            </div>

            <!-- Price Display -->
            <div class="bg-gray-50 rounded-lg p-4">
              <p class="text-xs text-gray-500 mb-3">
                *Prices are subject to change. Final price will be confirmed before payment.
              </p>
              <div class="space-y-2">
                <div class="flex justify-between text-gray-700">
                  <span>Subtotal:</span>
                  <span>{{ formatPrice(subtotal, selectedCurrency) }}</span>
                </div>
                <div v-if="discount > 0" class="flex justify-between text-green-600">
                  <span>Discount:</span>
                  <span>-{{ formatPrice(discount, selectedCurrency) }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg text-gray-800 border-t pt-2">
                  <span>Total:</span>
                  <span>{{ formatPrice(total, selectedCurrency) }}</span>
                </div>
              </div>
            </div>

            <!-- Privacy Policy Checkbox -->
            <div class="flex items-start gap-3 mt-4 p-4 bg-white border-2 border-gray-200 rounded-lg">
              <input
                type="checkbox"
                id="privacyPolicy"
                v-model="form.privacyPolicy"
                required
                class="mt-1"
              />
              <label for="privacyPolicy" class="text-sm text-gray-700 cursor-pointer">
                I agree to the
                <a href="/new-policies/" class="text-brand-600 hover:text-brand-700 font-semibold underline">
                  Privacy Policy
                </a>
                <span class="text-red-500">*</span>
              </label>
            </div>
          </div>

          <!-- Error Message -->
          <p v-if="error" class="p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
            {{ error }}
          </p>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="loading || form.password !== form.passwordConfirmation || !form.confirmation || !form.privacyPolicy"
            class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
          >
            <svg v-if="loading" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            {{ loading ? 'Processing...' : 'Proceed to Payment' }}
          </button>
        </form>

        <div class="p-6 border-t text-center">
          <p class="text-gray-600 text-sm">
            Already have an account?
            <router-link to="/login" class="text-brand-600 hover:text-brand-700 font-semibold">
              Sign in here
            </router-link>
          </p>
        </div>
      </div>

    </div>
    <PublicFooter />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch, nextTick } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'
import { useToast } from '../../composables/useToast'
import { useSEO } from '../../composables/useSEO'
import axios from 'axios'
import PublicFooter from '../../components/PublicFooter.vue'
import PublicHeader from '../../components/PublicHeader.vue'

const router = useRouter()
const auth = useAuthStore()
const toast = useToast()

// SEO: noindex for register page
useSEO({
  title: 'Register',
  description: 'Create your account and enroll in our courses',
  noindex: true
})

const form = ref({
  firstName: '',
  lastName: '',
  email: '',
  username: '',
  password: '',
  passwordConfirmation: '',
  phone: '',
  city: '',
  nativeLanguage: '',
  englishLevel: '',
  frenchLevel: '',
  coursePurpose: '',
  classTypeId: null,
  confirmation: false,
  privacyPolicy: false,
  specialRequest: '',
  referralSource: '',
  availability: ''
})

const loading = ref(false)
const error = ref('')
const classTypes = ref([])
const loadingClassTypes = ref(false)
const couponCode = ref('')
const appliedCoupon = ref(null)
const applyingCoupon = ref(false)
const couponError = ref('')

// Payment modal state
const showPaymentModal = ref(false)
const loadingPayment = ref(false)
const loadingPaymentMessage = ref('Loading payment form...')
const paymentError = ref('')
const paymentSuccess = ref(false)
const processingPayment = ref(false)
const stripeLoaded = ref(false)
const currentEnrollmentId = ref(null)
const redirectCountdown = ref(5)

// Stripe variables
let stripe = null
let elements = null
let cardElement = null

const selectedCurrency = computed(() => {
  const selected = classTypes.value.find(ct => ct.id === form.value.classTypeId)
  return selected?.currency || 'CAD'
})

const subtotal = computed(() => {
  const selected = classTypes.value.find(ct => ct.id === form.value.classTypeId)
  return selected?.price || 0
})

const requiresAvailability = computed(() => {
  const selected = classTypes.value.find(ct => ct.id === form.value.classTypeId)
  if (!selected) return false
  const name = (selected.class_name || selected.name || '').toLowerCase()
  return name.includes('one-on-one') || name.includes('1-on-1')
})

const couponsDisabled = computed(() => {
  const selected = classTypes.value.find(ct => ct.id === form.value.classTypeId)
  return selected?.disable_coupons === true
})

const discount = computed(() => {
  if (!appliedCoupon.value) return 0
  if (appliedCoupon.value.discount_type === 'percentage') {
    return (subtotal.value * appliedCoupon.value.discount_value) / 100
  }
  return appliedCoupon.value.discount_value
})

const total = computed(() => {
  return Math.max(0, subtotal.value - discount.value)
})

const formatPrice = (price, currency = 'CAD') => {
  if (!price) return '$0.00'
  return new Intl.NumberFormat('en-CA', {
    style: 'currency',
    currency: currency || 'CAD'
  }).format(price)
}

const loadClassTypes = async () => {
  loadingClassTypes.value = true
  try {
    // Try public endpoint first, fallback to admin endpoint
    let response
    try {
      response = await axios.get('/api/class-types')
    } catch {
      response = await axios.get('/api/admin/class-types')
    }
    
    if (response.data.success) {
      classTypes.value = response.data.data.filter(ct => ct.is_active !== false)
    }
  } catch (error) {
    toast.error('Failed to load class types. Please refresh the page.')
  } finally {
    loadingClassTypes.value = false
  }
}

const applyCoupon = async () => {
  // Clear previous errors
  couponError.value = ''
  
  // Validation checks with user feedback
  if (!couponCode.value || !couponCode.value.trim()) {
    couponError.value = 'Please enter a coupon code'
    toast.error('Please enter a coupon code')
    return
  }
  
  if (!form.value.classTypeId) {
    couponError.value = 'Please select a class type first'
    toast.error('Please select a class type first')
    return
  }
  
  if (subtotal.value === 0) {
    couponError.value = 'Please select a valid class type'
    toast.error('Please select a valid class type')
    return
  }
  
  applyingCoupon.value = true
  
  try {
    const response = await axios.post('/api/utility/validate-coupon', {
      code: couponCode.value.toUpperCase().trim(),
      amount: subtotal.value,
      class_type_id: form.value.classTypeId
    })
    
    if (response.data.success) {
      appliedCoupon.value = {
        code: response.data.data.coupon_code,
        discount_type: response.data.data.discount_type,
        discount_value: response.data.data.discount_value,
        discount: response.data.data.discount_type === 'percentage' 
          ? response.data.data.discount_value 
          : ((response.data.data.discount_value / subtotal.value) * 100).toFixed(0)
      }
      couponError.value = ''
      toast.success('Coupon applied successfully!')
    } else {
      couponError.value = response.data.message || 'Invalid coupon code'
      toast.error(couponError.value)
      appliedCoupon.value = null
    }
  } catch (error) {
    const errorMessage = error.response?.data?.message || 'Invalid coupon code'
    couponError.value = errorMessage
    toast.error(errorMessage)
    appliedCoupon.value = null
  } finally {
    applyingCoupon.value = false
  }
}

const removeCoupon = () => {
  appliedCoupon.value = null
  couponCode.value = ''
  couponError.value = ''
}

// Watch for class type changes to clear coupons if they are disabled for the new selection
watch(() => form.value.classTypeId, (newId) => {
  if (couponsDisabled.value && appliedCoupon.value) {
    removeCoupon()
    toast.info('Coupons are not available for this class type')
  }
})

const handleRegister = async () => {
  if (form.value.password !== form.value.passwordConfirmation) {
    error.value = 'Passwords do not match'
    return
  }

  if (!form.value.confirmation) {
    error.value = 'Please confirm that the information provided is accurate'
    return
  }

  if (!form.value.privacyPolicy) {
    error.value = 'Please agree to the Privacy Policy'
    return
  }

  if (!form.value.classTypeId) {
    error.value = 'Please select a class type'
    return
  }

  if (requiresAvailability.value && !form.value.availability) {
    error.value = 'Please enter your availability for One-on-One classes'
    return
  }

  error.value = ''
  loading.value = true

  try {
    // Register user first
    await auth.register(
      form.value.firstName,
      form.value.lastName,
      form.value.email,
      form.value.password,
      form.value.passwordConfirmation
    )
    
    // Wait a moment for auth store to update
    await new Promise(resolve => setTimeout(resolve, 100))
    
    // Get user ID from auth store (should be set after registration)
    const userId = auth.user?.id
    if (!userId) {
      throw new Error('User ID not found. Please try again.')
    }
    
    // Create enrollment record
    const enrollmentResponse = await axios.post('/api/enrollments', {
      user_id: userId,
      class_type_id: form.value.classTypeId,
      phone: form.value.phone,
      city: form.value.city,
      native_language: form.value.nativeLanguage,
      english_level: form.value.englishLevel,
      french_level: form.value.frenchLevel,
      course_purpose: form.value.coursePurpose,
      special_request: form.value.specialRequest,
      referral_source: form.value.referralSource,
      coupon_code: appliedCoupon.value?.code || null,
      discount_amount: discount.value,
      final_amount: total.value,
      availability: form.value.availability,
    })

    if (enrollmentResponse.data.success) {
      // Create Stripe Checkout session and redirect
      const enrollmentData = enrollmentResponse.data.data
      currentEnrollmentId.value = enrollmentData.enrollment_id

      // Get class type name for Stripe
      const selectedClassType = classTypes.value.find(ct => ct.id === form.value.classTypeId)
      const classTypeName = selectedClassType?.class_name || 'Course Enrollment'

      // Create checkout session
      const checkoutResponse = await axios.post('/api/payment/create-checkout-session', {
        enrollment_id: enrollmentData.enrollment_id,
        amount: subtotal.value,
        currency: 'cad',
        class_type_name: classTypeName,
        coupon_code: appliedCoupon.value?.code || null,
        discount_amount: discount.value,
      })

      if (checkoutResponse.data.success && checkoutResponse.data.data.checkout_url) {
        // Redirect to Stripe Checkout
        window.location.href = checkoutResponse.data.data.checkout_url
      } else {
        throw new Error(checkoutResponse.data.message || 'Failed to create payment session')
      }
    } else {
      throw new Error(enrollmentResponse.data.message || 'Failed to create enrollment')
    }
  } catch (err) {
    error.value = err.response?.data?.message || err.message || 'Registration failed. Please try again.'
    toast.error(error.value)
  } finally {
    loading.value = false
  }
}

// Load Stripe.js library
const loadStripe = () => {
  return new Promise((resolve, reject) => {
    if (window.Stripe) {
      resolve(window.Stripe)
      return
    }
    const script = document.createElement('script')
    script.src = 'https://js.stripe.com/v3/'
    script.onload = () => resolve(window.Stripe)
    script.onerror = () => reject(new Error('Failed to load Stripe.js'))
    document.head.appendChild(script)
  })
}

// Initialize Stripe for modal
const initializeStripeModal = async () => {
  try {
    paymentError.value = ''
    loadingPaymentMessage.value = 'Loading Stripe...'
    
    // Keep loadingPayment false so form stays visible (form is in v-else block)
    loadingPayment.value = false
    
    // Wait for modal to render and form to be visible
    await nextTick()
    await new Promise(resolve => setTimeout(resolve, 400))

    // Get Stripe publishable key
    const settingsResponse = await axios.get('/api/stripe/publishable-key')
    if (!settingsResponse.data.success || !settingsResponse.data.data.publishable_key) {
      throw new Error('Stripe publishable key not configured. Please configure it in admin settings.')
    }

    const publishableKey = settingsResponse.data.data.publishable_key

    // Load Stripe.js
    const Stripe = await loadStripe()
    
    // Initialize Stripe
    stripe = Stripe(publishableKey)
    elements = stripe.elements()

    // Wait for card element container to be rendered - use a retry mechanism
    let cardElementContainer = null
    let retries = 0
    const maxRetries = 20
    
    while (!cardElementContainer && retries < maxRetries) {
      await nextTick()
      await new Promise(resolve => setTimeout(resolve, 150))
      cardElementContainer = document.getElementById('card-element-modal')
      retries++
    }

    if (!cardElementContainer) {
      throw new Error('Payment form element not found. Please refresh and try again.')
    }
    
    // Create and mount card element (form should be visible now)
    if (cardElement) {
      try {
        cardElement.unmount()
      } catch (e) {
        // Ignore unmount errors
      }
    }

    cardElement = elements.create('card', {
      style: {
        base: {
          fontSize: '16px',
          color: '#2B2D42',
          '::placeholder': {
            color: '#8D99AE',
          },
        },
      },
    })

    cardElement.mount('#card-element-modal')

    // Handle card errors
    cardElement.on('change', (event) => {
      const displayError = document.getElementById('card-errors-modal')
      if (displayError) {
        if (event.error) {
          displayError.textContent = event.error.message
        } else {
          displayError.textContent = ''
        }
      }
    })

    stripeLoaded.value = true
    // Keep loadingPayment false so form stays visible
    loadingPayment.value = false
  } catch (err) {
    paymentError.value = err.message || 'Failed to initialize payment form'
    loadingPayment.value = false
  }
}

// Handle payment submission
const handlePayment = async () => {
  if (!stripe || !cardElement) {
    toast.error('Payment form not ready. Please wait...')
    return
  }

  processingPayment.value = true
  const cardErrors = document.getElementById('card-errors-modal')
  if (cardErrors) {
    cardErrors.textContent = ''
  }

  try {
    // Create payment intent
    const intentResponse = await axios.post('/api/payment/create-intent', {
      enrollment_id: currentEnrollmentId.value,
      amount: total.value,
      currency: 'cad',
      coupon_code: appliedCoupon.value?.code || null,
      discount_amount: discount.value || 0,
    })

    if (!intentResponse.data.success) {
      throw new Error(intentResponse.data.message || 'Failed to create payment intent')
    }

    const clientSecret = intentResponse.data.data.client_secret
    if (!clientSecret) {
      throw new Error('No payment intent returned from server')
    }

    // Confirm payment with Stripe
    const { error: stripeError, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
      payment_method: {
        card: cardElement,
        billing_details: {
          name: `${form.value.firstName} ${form.value.lastName}`.trim(),
          email: form.value.email,
        },
      },
    })

    if (stripeError) {
      throw new Error(stripeError.message)
    }

    if (paymentIntent.status === 'succeeded') {
      // Confirm payment and update both payment and enrollment status
      try {
        const confirmResponse = await axios.post('/api/payment/confirm', {
          payment_intent_id: paymentIntent.id,
          enrollment_id: currentEnrollmentId.value,
        })

        if (confirmResponse.data.success) {
          toast.success('Payment successful! Registration completed.')
        } else {
          throw new Error(confirmResponse.data.message || 'Payment confirmation failed')
        }
      } catch (err) {
        toast.warning('Payment succeeded but status update incomplete. Your enrollment will be activated shortly.')
      }

      // Show success message
      paymentSuccess.value = true
      redirectCountdown.value = 5
      
      // Countdown timer
      const timer = setInterval(() => {
        redirectCountdown.value--
        if (redirectCountdown.value <= 0) {
          clearInterval(timer)
          showPaymentModal.value = false
          // Hard redirect after registration to sync server-side auth state
          window.location.href = '/student/dashboard'
        }
      }, 1000)
    } else {
      throw new Error('Payment was not successful')
    }
  } catch (err) {
    const errorMessage = err.response?.data?.message || err.message || 'Payment failed. Please try again.'
    if (cardErrors) {
      cardErrors.textContent = errorMessage
    }
    toast.error(errorMessage)
  } finally {
    processingPayment.value = false
  }
}

// Cleanup on unmount
onUnmounted(() => {
  if (cardElement) {
    cardElement.unmount()
  }
})

// Watch modal visibility to cleanup Stripe when closed
watch(showPaymentModal, (isOpen) => {
  if (!isOpen && cardElement) {
    cardElement.unmount()
    cardElement = null
    stripeLoaded.value = false
  }
})

onMounted(async () => {
  await loadClassTypes()
})
</script>

<style scoped>
/* Scrollbar styling */
.overflow-y-auto::-webkit-scrollbar {
  width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #555;
  border-radius: 4px;
}
</style>
