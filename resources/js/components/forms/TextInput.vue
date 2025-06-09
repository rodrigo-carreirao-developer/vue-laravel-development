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
            @input="$emit('update:modelValue', $event.target.value)"
            @blur="$emit('blur', $event.target.value)"
            v-bind:class="defaultClass"
            />
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
    name: 'TextInput',
    props: {
        name: String,
        defaultClass: {
            type: Array,
            default: "block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
        },
        type: String,
        label: String,
        placeholder: String,
        required: String,
        min: String,
        max: String,
        modelValue: String
    }

}
</script>