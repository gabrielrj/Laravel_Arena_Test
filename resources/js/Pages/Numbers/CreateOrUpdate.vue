<template>
    <Head title="Number" />

    <BreezeAuthenticated>
        <template #header>
            <h1 class="text-3xl font-bold text-gray-900">
                {{ number === null ? 'New Number' : 'Edit Number' }}
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <BreezeValidationErrors class="mb-4" />

                        <form @submit.prevent="submit">

                            <div>
                                <BreezeLabel for="customer" value="Customer" />
                                <BreezeInput id="customer" type="text" class="mt-1 block w-full"
                                             disabled=""
                                             v-model="customer.name"/>
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="number" value="Number" />
                                <BreezeInput id="number" type="text" class="mt-1 block w-full"
                                             maxlength="14"
                                             v-model="form.number" required autofocus />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="status" value="Status" />
                                <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                        name="status" id="status"
                                        v-model="form.status">
                                    <option value="" disabled>Select status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <Link :href="route('numbers.index')"
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
        number: {
            type: Object,
            default: null
        },
        customer: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                customer_id: this.customer.id,
                number: null,
                status: null,
            })
        }
    },

    mounted() {
        if(this.number !== null){
            this.form.customer_id = this.customer.id
            this.form.number = this.number.number
            this.form.status = this.number.status
        }
    },

    methods: {
        submit() {
            if(this.number == null){
                this.form.post(this.route('numbers.store'), {
                    //onFinish: () => this.form.reset('password', 'password_confirmation'),
                    onSuccess: () => { Swal.fire('Success', 'Successfully registered number.', 'success') }
                })
            }else{
                this.form.put(this.route('numbers.update', this.number.id), {
                    //onFinish: () => this.form.reset('password', 'password_confirmation'),
                    onSuccess: () => { Swal.fire('Success', 'Successfully updated number.', 'success') }
                })
            }
        }
    }
}
</script>
