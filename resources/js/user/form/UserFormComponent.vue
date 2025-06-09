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
                                <text-input v-model="name" label="Name" type="text" name="name" :defaultClass="[
                                    'block w-full rounded-md bg-white px-3 py-1.5 text-base ',
                                    errors.name
                                        ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500'
                                        : 'text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6'
                                ]" @blur="validateField('name')" @update:modelValue="clearFieldError('name')">
                                </text-input>
                            </div>
                            <div class="sm:col-span-4">
                                <text-input v-model="email" label="Email" type="text" name="email" :defaultClass="[
                                    'block w-full rounded-md bg-white px-3 py-1.5 text-base ',
                                    errors.email
                                        ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500'
                                        : 'text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6'
                                ]" @blur="validateField('email')" @update:modelValue="clearFieldError('email')">
                                </text-input>
                            </div>
                            <div class="sm:col-span-4">
                                <text-input v-model="password" label="Password" type="text" name="password"
                                    :defaultClass="[
                                        'block w-full rounded-md bg-white px-3 py-1.5 text-base ',
                                        errors.password
                                            ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500'
                                            : 'text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6'
                                    ]" @blur="validateField('password')" @update:modelValue="clearFieldError('password')">
                                </text-input>
                            </div>
                            <div class="sm:col-span-4">
                                <text-input v-model="password_confirmation" label="Confirm Password" type="text"
                                    name="password_confirmation" :defaultClass="[
                                        'block w-full rounded-md bg-white px-3 py-1.5 text-base ',
                                        errors.password_confirmation
                                            ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500'
                                            : 'text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6'
                                    ]" @blur="validateField('password_confirmation')"
                                    @update:modelValue="clearFieldError('password_confirmation')">
                                </text-input>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <input type="button" @click="clearFields" class="text-sm/6 font-semibold text-gray-900"
                        value="Clear" />
                    <input type="button" class="text-sm/6 font-semibold text-gray-900" value="Cancel" />

                    <input type="submit" :disabled="!isFormValid" :class="[
                        'rounded-md px-3 py-2 text-sm font-semibold text-white shadow-xs',
                        isFormValid
                            ? 'bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'
                            : 'bg-gray-300 text-gray-500 cursor-not-allowed'
                    ]" class="" value="Review" />
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
import { ref, watch, reactive, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";

const errors = ref({});
const email = ref('');
const name = ref('');
const password = ref('');
const password_confirmation = ref('');
const response = ref('');
const route = useRoute();
const router = useRouter();
// Form data
const form = reactive({
    name: name,
    email: email,
    password: password,
    password_confirmation: password_confirmation
});
watch(name, (newValue) => {
    localStorage.setItem("name", newValue);
});
watch(password, (newValue) => {
    localStorage.setItem("password", newValue);
});
watch(password_confirmation, (newValue) => {
    localStorage.setItem("password_confirmation", newValue);
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
    saved = localStorage.getItem("password_confirmation");
    if (saved !== null) {
        password_confirmation.value = saved;
    }
});
const submitHandler = () => {
    router.push({ path: '/user/preview' });
};
const clearFields = () => {
    name.value = "";
    email.value = "";
    password.value = "";
    password_confirmation.value = "";
    console.log("cleared");
};
// Form validation
const isFormValid = computed(() => {
    return Object.keys(errors.value).length === 0 &&
        form.name.trim() !== '' &&
        form.email.trim() !== '' &&
        form.password.trim() !== '' &&
        form.password_confirmation.trim() !== '';
});

// Helper functions
const getFieldLabel = (fieldName) => {
    const labels = {
        name: 'Name',
        email: 'Email',
        password: 'Password',
        password_confirmation: 'Confirm Password'
    };
    return labels[fieldName] || fieldName;
};
const getPatternErrorMessage = (fieldName) => {
    const messages = {
        name: 'Name can only contain letters and spaces',
        email: 'Please enter a valid email address',
        password: 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character'
    };
    return messages[fieldName] || 'Invalid format';
};
const clearFieldError = (fieldName) => {
    if (errors.value[fieldName]) {
        delete errors.value[fieldName];
    }
};
const validationRules = {
    name: {
        required: true,
        minLength: 2,
        maxLength: 50,
        pattern: /^[a-zA-ZÀ-ÿ\s]+$/
    },
    email: {
        required: true,
        pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    },
    password: {
        required: true,
        minLength: 8,
        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/
    },
    password_confirmation: {
        required: true,
        matchField: 'password'
    }
};
// Validation functions
const validateField = (fieldName) => {
    const value = form[fieldName];
    const rules = validationRules[fieldName];
    let error = '';

    // Required validation
    if (rules.required && (!value || value.trim() === '')) {
        error = `${getFieldLabel(fieldName)} is required`;
    }
    // Minimum length validation
    else if (rules.minLength && value.length < rules.minLength) {
        error = `${getFieldLabel(fieldName)} must be at least ${rules.minLength} characters`;
    }
    // Maximum length validation
    else if (rules.maxLength && value.length > rules.maxLength) {
        error = `${getFieldLabel(fieldName)} must not exceed ${rules.maxLength} characters`;
    }
    // Pattern validation
    else if (rules.pattern && !rules.pattern.test(value)) {
        error = getPatternErrorMessage(fieldName);
    }
    // Match field validation (for confirm password)
    else if (rules.matchField && value !== form[rules.matchField]) {
        error = `${getFieldLabel(fieldName)} does not match ${getFieldLabel(rules.matchField)}`;
    }
    console.log(error);
    if (error) {
        errors.value[fieldName] = error;
    } else {
        delete errors.value[fieldName];
    }

    return !error;
};  
</script>