<template>
  <div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
      <form-tag @saveEvent="submitHandler" name="myform" event="saveEvent">
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
                {{ confirmed_password }}
              </div>
            </div>
          </div>
        </div>
          <div class="mt-6 flex items-center justify-end gap-x-6">
            <input type="button" @click="previousPage" class="text-sm/6 font-semibold text-gray-900" value="Go back"/>
            <input type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" value="Save" />
          </div>
        <div class="req-response">
          {{ response }}
        </div>
      </form-tag>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";

const email = ref('');
const name = ref('');
const password = ref('');
const confirmed_password = ref('');
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
    saved = localStorage.getItem("confirmed_password");
    if (saved !== null) {
        confirmed_password.value = saved;
    }
});
const previousPage = () => {
    router.push({ path: '/user/registry' });
};
const submitHandler = () => {
    console.log("submitHandler called");

    const payload = {
        email: localStorage.getItem("email"),
        name: localStorage.getItem("name"),
        password: localStorage.getItem("password"),
        confirmed_password: localStorage.getItem("confirmed_password"),
    };
    const requestOptions = {
        method: "POST",
        body: JSON.stringify(payload),
    };

    fetch("http://localhost:8000/api/users", requestOptions)
    .then((response) => response.json())
    .then((data) => {
        let message = "";

        if (data.success == false) {
        for (var key in data.errors) {
            message += data.errors[key] + "<br />";
        }
        console.log("Error", data.errors);
        } else {
        message = "User registered successfully. ID:" + data.data.id;
        }
        this.response = message;
    });
};
    
</script>