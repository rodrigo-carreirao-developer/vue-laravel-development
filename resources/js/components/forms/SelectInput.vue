<template>
    <div class="sm:col-span-3">
        <label :for="name" class="block text-sm/6 font-medium text-gray-900">{{label}}</label>
        <select :id="name" 
        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" 
        :name="name" :required="required"
        >
            <option v-for="option in items" :value="option.value" :key="option.value">
                {{option.text}}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    name: 'SelectInput',
    props: ["items", "name", "required", "label"],
    
}
</script>