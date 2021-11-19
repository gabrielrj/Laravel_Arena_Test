<template>
    <Head title="Preference" />

    <BreezeAuthenticated>
        <template #header>
            <h1 class="text-3xl font-bold text-gray-900">
                {{ preference === null ? 'New Preference' : 'Edit Preference' }}
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
                                             v-model="number.customer.name"/>
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="number" value="Number" />
                                <BreezeInput id="number" type="text" class="mt-1 block w-full"
                                             disabled=""
                                             v-model="number.number"/>
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="name" value="Name" />
                                <BreezeInput id="name" type="text" class="mt-1 block w-full"
                                             v-model="form.name" required autofocus />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="value" value="Value" />
                                <BreezeInput id="value" type="text" class="mt-1 block w-full"
                                             v-model="form.value" required autofocus />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <Link :href="route('preferences.index', number.id)"
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
        preference: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                number_id: this.number.id,
                name: null,
                value: null,
            })
        }
    },

    mounted() {
        if(this.preference !== null){
            this.form.number_id = this.number.id
            this.form.name = this.preference.name
            this.form.value = this.preference.value
        }
    },

    methods: {
        submit() {
            if(this.preference == null){
                this.form.post(this.route('preferences.store'), {
                    //onFinish: () => this.form.reset('password', 'password_confirmation'),
                    onSuccess: () => { Swal.fire('Success', 'Successfully registered preference.', 'success') }
                })
            }else{
                this.form.put(this.route('preferences.update', this.preference.id), {
                    //onFinish: () => this.form.reset('password', 'password_confirmation'),
                    onSuccess: () => { Swal.fire('Success', 'Successfully updated preference.', 'success') }
                })
            }
        }
    }
}
</script>
