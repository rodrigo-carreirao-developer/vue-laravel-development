<template>
    <nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
            <div class="flex shrink-0 items-center">
            <img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
            </div>
            <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4">
                <a href="/user" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="">Home</a>
                <a href="/user/listing" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">User Listing</a>
                <a href="/user/registry" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">User Registry</a>
            </div>
            </div>
        </div>
        </div>
    </div>
    </nav>
</template>

<style scoped>

</style>
<script>
export default {
    data() {
        return {
            currentHome: "aria-current='page'"
        }
    },
}
</script>
