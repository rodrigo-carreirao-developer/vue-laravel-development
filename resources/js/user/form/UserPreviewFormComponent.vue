<template>
  <div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="space-y-12">
          <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base/7 font-semibold text-gray-900">Preview User</h2>
            <p class="mt-1 text-sm/6 text-gray-600">
              This is information about to be registered
            </p>
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
              <div class="sm:col-span-4">
                <label :for="name" class="block text-sm/6 font-medium text-gray-900">Name: </label>
                {{ name }}
              </div>
              <div class="sm:col-span-4">
                <label :for="name" class="block text-sm/6 font-medium text-gray-900">Email: </label>
                {{ email }}
              </div>
              <div class="sm:col-span-4">
                <label :for="name" class="block text-sm/6 font-medium text-gray-900">Password: </label>
                {{ password }}
              </div>
              <div class="sm:col-span-4">
                <label :for="name" class="block text-sm/6 font-medium text-gray-900">Confirmed Password: </label>
                {{ password_confirmation }}
              </div>
            </div>
          </div>
        </div>
        <!-- Form Summary -->
        <div v-if="Object.keys(errors).length > 0" class="mt-4 p-3 bg-red-50 border border-red-200 rounded-md">
            <h4 class="text-sm font-medium text-red-800 mb-2">Please fix the following errors:</h4>
            <ul class="text-sm text-red-700 space-y-1">
            <li v-for="(error, field) in errors" :key="field">
                • {{ error }}
            </li>
            </ul>
        </div>
        <div v-if="isReady == true" class="mt-4 p-3 bg-green-50 border border-green-200 rounded-md">
            <h4 class="text-sm font-medium text-green-800 mb-2">All fields are validated from backend. You can proceed with registry.</h4>
        </div>
        <div v-if="isFinished == true" class="mt-4 p-3 bg-green-50 border border-green-200 rounded-md">
            <h4 class="text-sm font-medium text-green-800 mb-2">Response from backend: {{ backendResponse }}</h4>
        </div>
          <div class="mt-6 flex items-center justify-end gap-x-6">
            <input type="button" @click="previousPage" class="text-sm/6 font-semibold text-gray-900" value="Go back"/>
            <input type="button" @click="validateBackendHandler" class="rounded-md px-3 py-2 text-sm font-semibold text-white shadow-xs bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium" value="Validate with Backend"/>
            <input type="button" @click="submitHandler" :disabled="!isReady " 
            :class="[
            'rounded-md px-3 py-2 text-sm font-semibold text-white shadow-xs',
            isReady
                ? 'bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'
                : 'bg-gray-300 text-gray-500 cursor-not-allowed'
            ]"
            class="" value="Save" />
          </div>
        <div class="req-response">
          {{ response }}
        </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";

const isReady = ref(false)
const isFinished = ref(false)
const backendResponse = ref('')
const errors = ref({});
const email = ref('');
const name = ref('');
const password = ref('');
const password_confirmation = ref('');
const response = ref('');
const route = useRoute();
const router = useRouter();

onMounted(() => {
    let saved = localStorage.getItem("name");
    if (saved !== null) {
        name.value = saved;
    }
    saved = localStorage.getItem("email");
    if (saved !== null) {
        email.value = saved;
    }
    saved = localStorage.getItem("password");
    if (saved !== null) {
        password.value = saved;
    }
    saved = localStorage.getItem("password_confirmation");
    if (saved !== null) {
        password_confirmation.value = saved;
    }
});
const resetAllFields = () => {
    localStorage.setItem("name", '');
    localStorage.setItem("email", '');
    localStorage.setItem("password", '');
    localStorage.setItem("password_confirmation", '');
};
const previousPage = () => {
    router.push({ path: '/user/registry' });
};
const validateBackendHandler = () => {
    console.log("validateBackendHandler called");
    errors.value = [];
    const payload = {
        email: localStorage.getItem("email"),
        name: localStorage.getItem("name"),
        password: localStorage.getItem("password"),
        password_confirmation: localStorage.getItem("password_confirmation"),
    };
    const requestOptions = {
        method: "POST",
        body: JSON.stringify(payload),
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
    };
        fetch("http://localhost:8000/api/users/validate", requestOptions)
        .then((response) => response.json())
        .then((data) => {
            let message = "";

            if (data.success == false) {
                for (var key in data.errors) {
                    message += data.errors[key] + "<br />";
                }
                console.log("Error", data.errors);
                errors.value = data.errors;
            } else {
                isReady.value = true;
            }
        }).catch(function(err)
        {
            errors.value = ["Failed to fecth api."];
        });;
        
    
};
const submitHandler = () => {
    console.log("submitHandler called");
    errors.value = [];
    const payload = {
        email: localStorage.getItem("email"),
        name: localStorage.getItem("name"),
        password: localStorage.getItem("password"),
        password_confirmation: localStorage.getItem("password_confirmation"),
    };
    const requestOptions = {
        method: "POST",
        body: JSON.stringify(payload),
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
    };

        fetch("http://localhost:8000/api/users", requestOptions)
        .then((response) => response.json())
        .then((data) => {
            let message = "";

            if (data.success == false) {
            for (var key in data.errors) {
                message += data.errors[key] + "<br />";
            }
                errors.value = data.errors;
            } else {
                isFinished.value = true;
                isReady.value = false;
                resetAllFields();
                backendResponse.value = "User registered successfully. ID:" + data.data.id;
            }
        }).catch(function(err)
        {
            errors.value = ["Failed to fecth api."];
        });
        
};
    
</script>