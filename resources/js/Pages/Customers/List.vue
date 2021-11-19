<template>
    <Head title="Customer" />

    <BreezeAuthenticated>

        <template #header>
            <h1 class="text-3xl font-bold text-gray-900">
                Customers
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <BreezeValidationErrors class="mb-4" />

                        <!--Alert class="mb-4" :status="$page.props.flash.message" :msg="msg"></Alert-->

                        <Link v-if="hasPermission(this.$page.props.auth.permissions, $Permissions.CREATEPERMISSION)"
                              :href="route('customers.create')"
                              class="float-right bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-sm px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                              type="button">
                            <i class="fas fa-plus"></i> New Customer
                        </Link>

                        <br>
                        <br>

                        <div v-if="customers.length === 0"
                             class="block text-sm text-left text-white bg-gray-500 h-12 flex items-center p-4 rounded-md"
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
                            No registered customers were found
                        </div>

                        <CustomerList v-else :customers="customers"></CustomerList>

                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticated>
</template>

<script>
import BreezeAuthenticated from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import CustomerList from "@/Components/Customers/CustomerList";
import {Link} from "@inertiajs/inertia-vue3";
import Swal from 'sweetalert2'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import Alert from "@/Components/Alert";


export default {
    components: {
        BreezeAuthenticated,
        Head,
        CustomerList,
        Link,
        BreezeValidationErrors,
        Alert,
    },
    provide() {
        return {
            index: this
        }
    },
    props: {
        customers: Array,
    },
    methods: {

        deleteCustomer(customer){
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
                    this.$inertia.delete(`/customers/${customer.id}`, {
                        //preserveState: true,
                        onSuccess: () => { Swal.fire('Success', 'Successfully deleted customer.', 'success') }
                    })
                }
            })

        },

        async changeStatus(customer){
            let arrStatus = ['new', 'active', 'suspended', 'cancelled']

            let indexOfStatusCustomerInArrStatus = _.indexOf(arrStatus, customer.status)

            arrStatus.splice(indexOfStatusCustomerInArrStatus, 1)

            let options = {}

            _.forEach(arrStatus, (status) => {
                options[status] = status
            })

            const { value: statusSelected } = await Swal.fire({
                title: 'Select new status of the customer',
                input: 'select',
                inputOptions: options,
                inputPlaceholder: 'Select a status',
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value !== '') {
                            resolve()
                        } else {
                            resolve('Select the status of the customer. :)')
                        }
                    })
                }
            })

            if (statusSelected) {
                this.$inertia.put(`/customers/change/status/${customer.id}`, {'status' : statusSelected}, {
                    //preserveState: true,
                    onSuccess: () => { Swal.fire('Success', 'Successfully updated customer.', 'success') }
                })
            }
        }
    },
}
</script>
