<script setup lang="ts">
import { ref } from 'vue'
import NumberInput from './components/NumberInput.vue'
import SelectField from './components/SelectField.vue'
import TableInfo from './components/TableInfo.vue'
import ToggleField from './components/ToggleField.vue'
import { generateData } from './utils/api'
import type { SelectOption } from './utils/types'
import { __ } from './utils/wp'

const tableList = fdg.tables as SelectOption[]
const selectedTable = ref<string>('')
const loading = ref(false)
const error = ref(null)

const handleSubmit = async (e: Event) => {
  const formData = new FormData(e.target as HTMLFormElement)
  loading.value = true
  try {
    const res = await generateData(formData)
    if (res === 'success') {
    } else {
      error.value = res
    }
  } catch (ex) {
    console.log(ex)
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <h1 class="mb-4 text-4xl">Fake Data Generator</h1>

  <form class="space-y-4" @submit.prevent="handleSubmit">
    <SelectField
      v-model="selectedTable"
      :options="tableList"
      label="Tables"
      name="table"
      placeholder="Choose a Table"
    />

    <div v-if="selectedTable">
      <TableInfo :table-name="selectedTable" />
    </div>

    <NumberInput
      :label="__('Number of Rows', 'fdg')"
      name="num_of_rows"
      :initial-value="100"
      required
      v-if="selectedTable"
    />

    <ToggleField
      :label="__('Delete existing data before inserting', 'fdg')"
      name="trunc"
      value="trunc"
      v-if="selectedTable"
    />

    <button
      :disabled="!selectedTable || loading"
      type="submit"
      class="text-white bg-blue-500 hover:bg-blue-600 disabled:bg-blue-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none cursor-pointer disabled:cursor-not-allowed"
    >
      {{ loading ? __('Please Wait...', 'fdg') : __('Generate', 'fdg') }}
    </button>

    <span v-if="error">{{ error }}</span>
  </form>
</template>

<style scoped></style>
