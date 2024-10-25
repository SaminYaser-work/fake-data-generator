<script setup lang="ts">
import { defineProps } from 'vue';

const {
  label,
  name,
  required = false,
  inline = false,
} = defineProps<{
  label: string
  name: string
  type: 'date' | 'datetime' | 'year' | 'month' | 'week' | 'time'
  required?: boolean
  inline?: boolean
}>()

const value = defineModel<string>('value', {
  required: false,
})
</script>

<template>
  <div
    :class="[
      'flex',
      inline ? 'flex-row items-center' : 'flex-col items-start',
      'gap-1',
    ]"
  >
    <label :for="name" class="block text-sm font-medium text-gray-900"
      >{{ label }}
    </label>

    <input
      :name="name"
      :required="required"
      :type="type === 'datetime' ? 'datetime-local' : type"
      :value="value"
    />
  </div>
</template>
