<script setup lang="ts">
import { defineProps } from 'vue';

const {
  label,
  name,
  value,
  required = false,
} = defineProps<{
  label: string
  name: string
  required?: boolean
  value: string | number
}>()

const modelValue = defineModel<boolean>({
  required: false,
  default: false,
})

const toggle = () => {
  modelValue.value = !modelValue.value
}
</script>

<template>
  <label
    class="flex items-center gap-4 cursor-pointer"
    :for="name"
    @click="toggle"
  >
    <span class="block text-sm font-medium text-gray-900">{{ label }}</span>
    <input
      class="sr-only peer"
      type="checkbox"
      :name="name"
      :required="required"
      v-model="modelValue"
      :value="value"
    />
    <div
      class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"
    ></div>
  </label>
</template>
