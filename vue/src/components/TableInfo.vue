<script setup lang="ts">
import { getTableInfo } from '@/utils/api';
import type { TableInformation } from '@/utils/types';
import { defineProps, ref, watchEffect } from 'vue';
import FieldData from './FieldData.vue';

const { tableName } = defineProps<{
  tableName: string
}>()

const tableInfo = ref<TableInformation[]>()
const loading = ref(false)

watchEffect(async () => {
  if (tableName) {
    loading.value = true
    tableInfo.value = await getTableInfo(tableName)
    loading.value = false
  }
})

</script>

<template>
  <div v-if="!loading && tableInfo?.length" class="space-y-4">
    <div
      v-for="row in tableInfo"
      :key="row.Field"
      class="p-4 bg-white border border-gray-200 rounded-lg shadow-md"
    >
      <ul class="space-y-2">
        <li class="text-lg font-semibold text-gray-800">
          {{ row.Field }} -
          <span class="text-sm text-gray-700">{{ row.Type }}</span>
        </li>
        <li
          v-if="row.Null === 'YES' || row.Key || row.Default || row.Extra"
          class="mb-5 text-sm text-gray-600"
        >
          <span v-if="row.Null === 'YES'">Nullable, </span>
          <span v-if="row.Key" class="font-bold">{{ row.Key }}, </span>
          <span v-if="row.Default">Default: {{ row.Default }}</span>
          <span v-if="row.Extra">{{ row.Extra }}</span>

          <br />
        </li>
        <FieldData
          :name="row.Field"
          :data-type="row.Type"
          :nullable="row.Null === 'YES'"
          v-if="!row.Key.includes('PRI')"
        />
      </ul>
    </div>
  </div>

  <div v-if="!loading && !tableInfo?.length" class="text-2xl text-gray-400">
    Selected Table has no columns!
  </div>

  <div v-if="loading">Loading...</div>
</template>
