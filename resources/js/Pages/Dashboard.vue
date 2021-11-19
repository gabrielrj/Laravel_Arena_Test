<template>
    <Head title="Dashboard" />

    <BreezeAuthenticated>
        <template #header>
            <h1 class="text-3xl font-bold text-gray-900">
                Dashboard
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <BreezeValidationErrors class="mb-4" />
                        <p>You're logged in!</p>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticated>
</template>

<script>
import BreezeAuthenticated from '@/Layouts/Authenticated.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticated,
        BreezeValidationErrors,
        Head,
    },
}
</script>
