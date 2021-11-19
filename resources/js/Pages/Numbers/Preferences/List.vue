<template>
    <Head title="Number preferences" />

    <BreezeAuthenticated>

        <template #header>
            <h1 class="text-3xl font-bold text-gray-900">
                Numbers
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <BreezeValidationErrors class="mb-4" />

                        <div class="mb-4">
                            <BreezeLabel for="customer" value="Customer" />
                            <BreezeInput id="customer" type="text" class="mt-1 block w-full"
                                         disabled=""
                                         v-model="customerOwner.name"/>
                        </div>

                        <div class="mb-4">
                            <BreezeLabel for="number" value="Number" />
                            <BreezeInput id="number" type="text" class="mt-1 block w-full"
                                         disabled=""
                                         v-model="numberOwner.number"/>
                        </div>

                        <Link v-if="hasPermission(this.$page.props.auth.permissions, $Permissions.CREATEPERMISSION)"
                              :href="route('preferences.create', numberOwner.id)"
                              class="float-right bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-sm px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                              type="button">
                            <i class="fas fa-plus"></i> New Preference
                        </Link>
                        <br>
                        <br>

                        <div v-if="preferenceList.length === 0" class="block text-sm text-left text-white bg-gray-500 h-12 flex items-center p-4 rounded-md"
                             role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 class="w-6 h-6 mx-2 stroke-current">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                            There are no registered preferences for this number.
                        </div>

                        <PreferenceList v-else :preferences="preferenceList"></PreferenceList>


                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticated>
</template>

<script>
import BreezeLabel from '@/Components/Label.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeAuthenticated from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import PreferenceList from "@/Components/Preferences/PreferenceList.vue";
import {Link} from "@inertiajs/inertia-vue3";
import Swal from 'sweetalert2'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import Alert from "@/Components/Alert";


export default {
    components: {
        BreezeAuthenticated,
        Head,
        PreferenceList,
        Link,
        BreezeValidationErrors,
        Alert,
        BreezeLabel,
        BreezeInput,
    },
    provide() {
        return {
            index: this
        }
    },
    props: {
        customer: Object,
        number: Object,
        preferences: Array
    },
    data() {
        return {
            customerOwner: this.customer,
            numberOwner: this.number,
            preferenceList: this.preferences
        }
    },
    watch: {
        customer: {
            handler(){
                this.customerOwner = this.customer
            },
            deep: true,
        },
        number: {
            handler(){
                this.numberOwner = this.number
            },
            deep: true,
        },
        preferences: {
            handler(){
                this.preferenceList = this.preferences
            },
            deep: true,
        },

    },
    methods: {

        deletePreference(preference){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(`/preferences/${preference.id}`, {
                        //preserveState: true,
                        onSuccess: () => {
                            Swal.fire('Success', 'Successfully deleted number.', 'success')
                        }
                    })
                }
            })

        },

    },
}
</script>
