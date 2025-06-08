<template>
     <div class="mb-3">
        <label :for="name" class="block text-sm/6 font-medium text-gray-900">{{label}} </label>
        <input 
            v-bind:type="type"
            :name="name"
            :placeholder="placeholder"
            :required="required"
            :min="min"
            :max="max"
            :value="modelValue"
            :autocomplete="name + '-new'"
            @input="applyMask"
            v-model="dateValue"
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
            />
    </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';
const emit = defineEmits(['update:modelValue']);
const name = 'DateInput';
const props = defineProps({
    name: String,
    type: String,
    label: String,
    placeholder: String,
    required: String,
    min: String,
    max: String,
    modelValue: String
});

const dateValue = ref('');

const applyMask = (event) => {
    let value = event.target.value;
    value = value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    if (value.length > 2) {
    value = value.substring(0, 2) + '/' + value.substring(2);
    }
    if (value.length > 5) {
        value = value.substring(0, 5) + '/' + value.substring(5);
    }
    if (value.length > 10) {
        value = value.substring(0, 10);
    }
    dateValue.value = value;
    emit('update:modelValue', value)
};

</script>