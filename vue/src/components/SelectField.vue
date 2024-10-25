<script lang="ts" setup>
import type { SelectOption } from '@/utils/types';
import { defineProps } from 'vue';

const props = defineProps<{
  modelValue: string | number
  options: SelectOption[]
  label: string
  name: string
  placeholder: string
  required?: boolean
}>()

const emit = defineEmits(['update:modelValue'])

const updateValue = (event: Event) => {
  const target = event.target as HTMLSelectElement
  emit('update:modelValue', target.value)
}
</script>

<template>
  <div>
    <label :for="name" class="block mb-2 text-sm font-medium text-gray-900">{{
      props.label
    }}</label>
    <select
      :name="props.name"
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
      :value="props.modelValue"
      @change="updateValue"
      :required="props.required"
    >
      <option :selected="modelValue === ''" value="" disabled hidden>{{ props.placeholder }}</option>

      <option
        v-for="option in props.options"
        :value="option.value"
        :key="option.value"
        :selected="modelValue === option.value"
      >
        {{ option.label }}
      </option>
    </select>
  </div>
</template>
