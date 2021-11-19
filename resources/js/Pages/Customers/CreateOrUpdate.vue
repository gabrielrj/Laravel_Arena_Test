<template>
    <Head title="Customer" />

    <BreezeAuthenticated>
        <template #header>
            <h1 class="text-3xl font-bold text-gray-900">
                {{ customer === null ? 'New Customer' : 'Edit Customer' }}
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <BreezeValidationErrors class="mb-4" />

                        <form @submit.prevent="submit">
                            <div>
                                <BreezeLabel for="name" value="Name" />
                                <BreezeInput id="name" type="text" class="mt-1 block w-full"
                                             v-model="form.name" required autofocus autocomplete="name" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="document" value="Document" />
                                <BreezeInput id="document" type="text" class="mt-1 block w-full"
                                             maxlength="12"
                                             v-model="form.document"
                                             required />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="status" value="Status" />
                                <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                        name="status" id="status"
                                        v-model="form.status">
                                    <option value="" disabled>Select status</option>
                                    <option value="new">New</option>
                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <Link :href="route('customers.index')"
                                      class="text-sm text-red-600 hover:text-red-900">
                                    Cancel
                                </Link>

                                <BreezeButton class="ml-4 bg-blue-800 hover:bg-blue-800 hover:opacity-90"
                                              :class="{'opacity-25': form.processing }"
                                              :disabled="form.processing">
                                    <i class="fas fa-save"></i>&nbsp;Save
                                </BreezeButton>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticated>
</template>

<script>
import BreezeAuthenticated from '@/Layouts/Authenticated.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import BreezeButton from '@/Components/Button.vue';
import { Head } from '@inertiajs/inertia-vue3';
import {Link} from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";


export default {
    components: {
        BreezeAuthenticated,
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
        Link,
        Swal
    },
    props: {
        customer: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                name: null,
                document: null,
                status: null,
            })
        }
    },

    mounted() {
        if(this.customer !== null){
            this.form.name = this.customer.name
            this.form.document = this.customer.document
            this.form.status = this.customer.status
        }
    },

    methods: {
        submit() {
            if(this.customer == null){
                this.form.post(this.route('customers.store'), {
                    //onFinish: () => this.form.reset('password', 'password_confirmation'),
                    onSuccess: () => { Swal.fire('Success', 'Successfully registered customer.', 'success') }
                })
            }else{
                this.form.put(this.route('customers.update', this.customer.id), {
                    //onFinish: () => this.form.reset('password', 'password_confirmation'),
                    onSuccess: () => { Swal.fire('Success', 'Successfully updated customer.', 'success') }
                })
            }
        }
    }
}
</script>
