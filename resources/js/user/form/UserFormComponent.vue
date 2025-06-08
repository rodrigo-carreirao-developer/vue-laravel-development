<template>
  <div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
      <form-tag @saveEvent="submitHandler" name="myform" event="saveEvent">
        <div class="space-y-12">
          <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base/7 font-semibold text-gray-900">New User</h2>
            <p class="mt-1 text-sm/6 text-gray-600">
              Use this form to store a new user.
            </p>
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
              <div class="sm:col-span-4">
                <text-input
                  v-model="name"
                  label="Name"
                  type="text"
                  name="name"
                >
                </text-input>
              </div>
              <div class="sm:col-span-4">
                <text-input
                  v-model="email"
                  label="Email"
                  type="text"
                  name="email"
                >
                </text-input>
              </div>
              <div class="sm:col-span-4">
                <text-input
                  v-model="password"
                  label="Password"
                  type="text"
                  name="password"
                >
                </text-input>
              </div>
              <div class="sm:col-span-4">
                <text-input
                  v-model="confirm_password"
                  label="Confirm Password"
                  type="text"
                  name="confirm_password"
                >
                </text-input>
              </div>
            </div>
          </div>
        </div>
          <div class="mt-6 flex items-center justify-end gap-x-6">
            <input type="button" @click="clearFields" class="text-sm/6 font-semibold text-gray-900" value="Clear" />
            <input type="button" class="text-sm/6 font-semibold text-gray-900" value="Cancel" />
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
import TextInput from "../../components/forms/TextInput.vue";
import FormTag from "../../components/forms/FormTag.vue";
import { ref, watch, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";

const email = ref('');
const name = ref('');
const password = ref('');
const confirm_password = ref('');
const response = ref('');
const route = useRoute();
const router = useRouter();
watch(name, (newValue) => {
    localStorage.setItem("name", newValue);
});
watch(password, (newValue) => {
    localStorage.setItem("password", newValue);
});
watch(confirm_password, (newValue) => {
    localStorage.setItem("confirm_password", newValue);
});
watch(email, (newValue) => {
    localStorage.setItem("email", newValue);
});
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
    saved = localStorage.getItem("confirm_password");
    if (saved !== null) {
        confirm_password.value = saved;
    }
});
const submitHandler = () => {
    router.push({ path: '/user/preview' });
};
const clearFields = () => {
    name.value = "";
    email.value = "";
    password.value = "";
    confirm_password.value = "";
    console.log("cleared");
};
    
</script>