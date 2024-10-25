<script lang="ts" setup>
import { getOptions, getType } from '@/utils/get-options'
import { ref } from 'vue'
import DateField from './DateField.vue'
import NumberInput from './NumberInput.vue'
import SelectField from './SelectField.vue'
import ToggleField from './ToggleField.vue'

const { dataType, nullable, name } = defineProps<{
  dataType: string
  nullable: boolean
  name: string
}>()

const type = getType(dataType)
const options = type ? getOptions(type) : null

const selectedOption = ref('')
</script>

<template>
  <div v-if="options !== null" class="pt-10 space-y-8">
    <SelectField
      v-model="selectedOption"
      :options="options"
      label="Random Data Type"
      :name="name"
      placeholder="Choose an Option"
      required
    />

    <!-- Int -->
    <div
      v-if="type === 'int' && selectedOption === 'int'"
      class="flex items-center gap-10"
    >
      <NumberInput label="Min" :name="name + '_int-min'" :required="false" />
      <span class="text-sm font-bold text-slate-400">To</span>
      <NumberInput label="Max" :name="name + '_int-max'" :required="false" />
    </div>

    <!-- Float -->
    <div v-if="type === 'float' && selectedOption === 'float'">
      <NumberInput label="Min" :name="name + '_float-min'" :required="false" />
      <NumberInput label="Max" :name="name + '_float-max'" :required="false" />
    </div>

    <!-- Year -->
    <div v-if="type === 'year' && selectedOption === 'year'">
      <NumberInput
        label="Min Year"
        :name="name + '_year-min'"
        :required="false"
        :min="0"
        :max="9999"
      />
      <NumberInput
        label="Max Year"
        :name="name + '_year-max'"
        :required="false"
        :min="0"
        :max="9999"
      />
    </div>

    <!-- Datetime -->
    <div
      v-if="type === 'datetime' && selectedOption === 'datetime'"
      class="flex flex-row items-center justify-start gap-2"
    >
      <DateField
        label="Min Datetime"
        :name="name + '_datetime-min'"
        :required="false"
        type="datetime"
        :inline="true"
      />

      <DateField
        label="Max Datetime"
        :name="name + '_datetime-max'"
        :required="false"
        type="datetime"
        :inline="true"
      />
    </div>

    <!-- Time -->
    <div
      v-if="type === 'time' && selectedOption === 'time'"
      class="flex flex-row items-center justify-start gap-2"
    >
      <DateField
        label="Min Time"
        :name="name + '_time-min'"
        :required="false"
        type="time"
        :inline="true"
      />

      <DateField
        label="Max Time"
        :name="name + '_time-max'"
        :required="false"
        type="time"
        :inline="true"
      />
    </div>

    <!-- Date -->
    <div
      v-if="type === 'date' && selectedOption === 'date'"
      class="flex flex-row items-center justify-start gap-2"
    >
      <DateField
        label="Min Date"
        :name="name + '_date-min'"
        :required="false"
        type="date"
        :inline="true"
      />

      <DateField
        label="Max Date"
        :name="name + '_date-max'"
        :required="false"
        type="date"
        :inline="true"
      />
    </div>

    <!-- String -->
    <div
      v-if="type === 'string'"
      class="flex flex-row items-center justify-start gap-2"
    >
      <NumberInput
        label="Max number of characters"
        :name="name + '_text-max'"
        :min="1"
        :max="99999"
        :initial-value="100"
        v-if="selectedOption === 'text'"
        required
      />
    </div>

    <ToggleField
      label="Can have null values"
      name="is-null"
      value="hasNull"
      v-if="nullable"
    />
  </div>
</template>
