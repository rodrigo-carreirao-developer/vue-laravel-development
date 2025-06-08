<template>
  <div class="border-b border-gray-900/10 pb-12">
    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
      <div class="sm:col-span-2">
        <form-tag
          name="myform"
          event="searchEvent"
        >
          <select-input
            label="Search By"
            name="search"
            @change="selectValueUpdate"
            :items="items"
          ></select-input>
          <text-input
            v-model="search"
            label="Query"
            type="text"
            name="query"
          >
          </text-input>
          <input type="button" @click="submitHandler" class="bg-blue-500 hover:bg-blue-700 disabled:bg-blue-300 text-white font-bold py-2 px-4 rounded transition duration-200 flex items-center gap-2" value="Search" />
        </form-tag>
      </div>

      <div class="sm:col-span-2">
        <div class="mt-2">
          <date-input
            v-model="createdAt"
            label="Created At"
            type="text"
            name="createdAt"
          ></date-input>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import TextInput from "../../components/forms/TextInput.vue";
import DateInput from "../../components/forms/DateInput.vue";
import SelectInput from "../../components/forms/SelectInput.vue";
import FormTag from "../../components/forms/FormTag.vue";
import { ref, watch, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";

const name = "FilterComponent";
const props = defineProps(['onChildEvent']);
const items = [
        { text: "Everything", value: "everything" },
        { text: "Email", value: "email" },
        { text: "Name", value: "name" },
      ];
  
const route = useRoute();
const router = useRouter();

const search = ref(route.query.search || "");
const selectValue = ref('everything');
const query = ref('');
const createdAt = ref('');
const emit = defineEmits(['child-event']);


// Watch the input and update URL
watch(search, (newVal) => {
    router.replace({ query: { ...route.query, search: newVal } });
});
watch(createdAt, (newValue) => {
    localStorage.setItem("createdAt", newValue);
});   
// Sync search value when query changes externally
onMounted(() => {
    let saved = localStorage.getItem("query");
    if (saved !== null) {
        query.value = query;
    }
    saved = localStorage.getItem("createdAt");
    if (saved !== null) {
        createdAt.value = saved;
    }

});
const submitHandler =() => {
    console.log("submitHandler called");
    emit('child-event', { search: search.value, selectValue: selectValue.value, created_at: createdAt.value, query: query.value });
};

const selectValueUpdate = (e) =>{
    selectValue.value = e.target.value;
}
</script>