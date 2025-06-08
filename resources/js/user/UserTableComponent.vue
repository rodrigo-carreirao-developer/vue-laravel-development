<template>
  <div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
      <!-- Header -->
      <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h2 class="text-2xl font-bold text-gray-800">Users</h2>
          <button 
            @click="fetchUsers"
            :disabled="loading"
            class="bg-blue-500 hover:bg-blue-700 disabled:bg-blue-300 text-white font-bold py-2 px-4 rounded transition duration-200 flex items-center gap-2"
          >
            <svg v-if="loading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ loading ? 'Loading...' : 'Refresh' }}
          </button>
        </div>
      </div>

      <!-- Error Message -->
      <div v-if="error" class="bg-red-50 border-l-4 border-red-400 p-4 m-6">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm text-red-700">{{ error }}</p>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading && users.length === 0" class="p-8 text-center">
        <div class="inline-flex items-center gap-2 text-gray-600">
          <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Loading users...
        </div>
      </div>

      <!-- Users Table -->
      <div v-else-if="users.length > 0" class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                ID
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Name
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Email
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Created At
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50 transition duration-200">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                {{ user.id }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ user.email }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(user.created_at) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button 
                  @click="viewUser(user)"
                  class="text-indigo-600 hover:text-indigo-900 mr-3"
                >
                  View
                </button>
                <button 
                  @click="editUser(user)"
                  class="text-green-600 hover:text-green-900 mr-3"
                >
                  Edit
                </button>
                <button 
                  @click="deleteUser(user)"
                  class="text-red-600 hover:text-red-900"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Empty State -->
      <div v-else-if="!loading" class="p-8 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by adding some users to your application.</p>
      </div>

      <!-- Pagination (if needed) -->
      <div v-if="pagination && pagination.total > pagination.per_page" class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <div class="flex items-center justify-between">
          <div class="flex-1 flex justify-between sm:hidden">
            <button 
              @click="previousPage"
              :disabled="!pagination.prev_page_url"
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50"
            >
              Previous
            </button>
            <button 
              @click="nextPage"
              :disabled="!pagination.next_page_url"
              class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50"
            >
              Next
            </button>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results
              </p>
            </div>
            <div class="flex gap-2">
              <button 
                @click="previousPage"
                :disabled="!pagination.prev_page_url"
                class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 rounded-md"
              >
                Previous
              </button>
              <button 
                @click="nextPage"
                :disabled="!pagination.next_page_url"
                class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 rounded-md"
              >
                Next
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

// Reactive data
const users = ref([]);
const loading = ref(false);
const error = ref(null);
const pagination = ref(null);
const currentPage = ref(1);
const search = ref('')
const name = ref('')
const createdAt = ref('')
const selectValue = ref('')

// Fetch users from API
const fetchUsers = async (page = 1) => {
  loading.value = true;
  error.value = null;
    const params = new URLSearchParams();
    params.append("page", page);
    if(selectValue.value != 'everything' && search.value != ''){
        params.append(selectValue.value, search.value);
    }else if(search.value != ''){
        params.append("search", search.value);
    }
    if(createdAt.value != ''){
        params.append("created_at", createdAt.value);
    }
  try {
    const response = await fetch(`/api/users?`+params, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        // Add CSRF token if needed
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
      },
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    
    // Handle different API response formats
    if (data.data && Array.isArray(data.data)) {
      // Paginated response
      users.value = data.data;
      pagination.value = {
        current_page: data.pagination.current_page,
        last_page: data.pagination.total_pages,
        per_page: data.pagination.per_page,
        total: data.pagination.total,
        from: data.pagination.start,
        to: data.pagination.to,
        prev_page_url: data.pagination.links.prev,
        next_page_url: data.pagination.links.next,
      };
    } else if (Array.isArray(data)) {
      // Simple array response
      users.value = data;
      pagination.value = null;
    } else {
      throw new Error('Unexpected API response format');
    }
    
    currentPage.value = page;
  } catch (err) {
    error.value = `Failed to fetch users: ${err.message}`;
    console.error('Error fetching users:', err);
  } finally {
    loading.value = false;
  }
};

// Pagination methods
const nextPage = () => {
  if (pagination.value?.next_page_url) {
    fetchUsers(currentPage.value + 1);
  }
};

const previousPage = () => {
  if (pagination.value?.prev_page_url) {
    fetchUsers(currentPage.value - 1);
  }
};

// Utility methods
const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
};

// Action methods
const viewUser = (user) => {
  console.log('View user:', user);
  // Implement view logic or emit event
  // this.$emit('view-user', user);
};

const editUser = (user) => {
  console.log('Edit user:', user);
  // Implement edit logic or emit event
  // this.$emit('edit-user', user);
};

const deleteUser = async (user) => {
  if (!confirm(`Are you sure you want to delete ${user.name}?`)) {
    return;
  }
  
  try {
    const response = await fetch(`/api/users/${user.id}`, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
      },
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Remove user from local array
    users.value = users.value.filter(u => u.id !== user.id);
    
    // Show success message (you might want to use a toast library)
    console.log(`User ${user.name} deleted successfully`);
  } catch (err) {
    error.value = `Failed to delete user: ${err.message}`;
    console.error('Error deleting user:', err);
  }
};

// Load users when component mounts
onMounted(() => {
  fetchUsers();
});

defineExpose({
  refreshTable,
});
function refreshTable(filter){
  console.log("dosomething");
  search.value = filter.search;
  createdAt.value = filter.created_at;
  selectValue.value = filter.selectValue;
  name.value = filter.name;
  fetchUsers();
}
</script>