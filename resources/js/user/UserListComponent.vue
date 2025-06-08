<template>
  <main-header></main-header>
  <div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
      <h1 class="text-3xl font-bold text-gray-800 mb-4">User List</h1>
        <filter-component @child-event="handleChildEvent"></filter-component>
        <user-table-component ref="refreshTable"></user-table-component>
    </div>
  </div>
</template>

<script setup>
import FilterComponent from './filter/FilterComponent.vue';
import UserTableComponent from './UserTableComponent.vue';
import { ref, watch, onMounted } from "vue";

const refreshTable = ref();
const handleChildEvent = (data) => {
    console.log('Event received from child:', );
    refreshTable.value.refreshTable(data);
}

</script>