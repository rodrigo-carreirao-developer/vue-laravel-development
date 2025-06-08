<template>
  <main-header></main-header>
  <div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
      <h1 class="text-3xl font-bold underline">User Preview</h1>
        <user-preview-form-component></user-preview-form-component>
    </div>
  </div>
</template>

<script setup>
import UserPreviewFormComponent from './UserPreviewFormComponent.vue';
</script>