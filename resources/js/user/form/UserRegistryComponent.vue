<template>
  <main-header></main-header>
  <div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
      <h1 class="text-3xl font-bold underline">User Registry</h1>
        <user-form-component></user-form-component>
    </div>
  </div>
</template>

<script >
import UserFormComponent from './UserFormComponent.vue';


export default {

    components: {
        'user-form-component': UserFormComponent,
    },
}

</script>