<script setup lang="ts">
import { defineProps, onMounted } from 'vue';

const props = withDefaults(
  defineProps<{
    label: string
    name: string
    required?: boolean
    min?: number
    max?: number
    initialValue?: number
  }>(),
  {
    required: false,
    min: 0,
    max: 99999,
    initialValue: undefined,
  },
)

const value = defineModel<number>('value', {
  required: false,
})

onMounted(() => {
  value.value = props.initialValue
})

const increment = () => {
  if (value.value === undefined) {
    value.value = 1
  } else {
    value.value++
  }
}

const decrement = () => {
  if (value.value === undefined) {
    value.value = -1
  } else {
    value.value--
  }
}
</script>

<template>
  <label :for="name" class="block text-sm font-medium text-gray-900"
    >{{ props.label }}
  </label>

  <div class="relative flex items-center max-w-[8rem]">
    <button
      type="button"
      class="p-3 bg-gray-100 border border-gray-300 hover:bg-gray-200 rounded-s-lg h-11 focus:ring-gray-100 focus:ring-2 focus:outline-none"
      @click="decrement"
    >
      <svg
        class="w-3 h-3 text-gray-900"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 18 2"
      >
        <path
          stroke="currentColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M1 1h16"
        />
      </svg>
    </button>
    <input
      type="number"
      :name="props.name"
      class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5"
      :required="props.required"
      v-model="value"
      :min="props.min"
      :max="props.max"
    />
    <button
      type="button"
      class="p-3 bg-gray-100 border border-gray-300 hover:bg-gray-200 rounded-e-lg h-11 focus:ring-gray-100 focus:ring-2 focus:outline-none"
      @click="increment"
    >
      <svg
        class="w-3 h-3 text-gray-900"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 18 18"
      >
        <path
          stroke="currentColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M9 1v16M1 9h16"
        />
      </svg>
    </button>
  </div>
</template>
